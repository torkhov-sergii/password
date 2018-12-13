<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Main;
use Illuminate\Support\Facades\App;
use Helpers;
use Response;


class SearchController extends Controller {

    function search(Request $request, Main $mainModel, $slug = null) {
        $count = 0;
        $items_new = [];
        $locale = App::getLocale();
        $limit = 10;

        if($slug) {
            $search_string = $slug;
        }
        else {
            $limit = 5;
            $search_string = $request->get('search_string');
        }

        if($search_string) {
            $search_string_exploded = explode(' ',$search_string);

            foreach ($search_string_exploded as $q) {
                $q = '%'.trim(addslashes(strip_tags($q))).'%';
                $like_arr[] = '(main_translations.name LIKE "'.$q.'")';
                $like_arr[] = '(main_translations.text LIKE "'.$q.'")';
            }
            $like = implode('+',$like_arr);

            $query = $mainModel
                ->leftJoin('main_translations', function ($join) use ($locale) {
                    $join
                        ->on('main.id', '=', 'main_translations.main_id')
                        ->where('locale', '=', $locale);
                })
                ->leftJoin('type', 'main.type_id', '=', 'type.id')
//                ->where(function($query) use ($search_string) {
//                    $query
//                        ->where('main_translations.name', 'LIKE', '%' . $search_string . '%')
//                        ->Orwhere('text', 'LIKE', '%'.$search_string.'%');
//                })
                ->where('route', '!=', '')
                ->where('hide', 0)
                //->selectRaw(('(main_translations.name LIKE \'%те%\')+(main_translations.text LIKE \'%те%\') as hits'))
                ->selectRaw($like.' as hits')
                ->addSelect(['main_translations.*', 'main.*'])
                ->orderBy('hits', 'desc');

            $items = $query->limit($limit)->get();
            $count = $items->count();

            foreach ($items as $item) {
                $item_url = $item->getUrl();

                if($item_url) {
                    $item->name = str_ireplace($search_string,'<span class="search_found">'.$search_string.'</span>',$item->name);
                    //$item->text = str_ireplace($slug,'<span class="search_found">'.$slug.'</span>',$item->text);
                    $item->text = str_ireplace($search_string,'<span class="search_found">'.$search_string.'</span>',Helpers::catString($item->text, 300, '...'));
                    $item->url = $item_url;
                    $item->category = $item->type->name;

                    $items_new[] = $item;
                }
            }

            //return Response::json(['result'   => $items]);
        }

        $items = $items_new;

        if($slug) {
            return view('vendor.search.main', compact('items', 'count', 'search_string'));
        }

        return response()->json([
            'count' => $count,
            'html' => view('vendor.search.live', compact('items', 'count', 'search_string'))->render()
        ]);
    }

}
