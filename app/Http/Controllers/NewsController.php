<?php namespace App\Http\Controllers;

use App\Models\Main;
use App\Transformers\NewsTransformer;
use Illuminate\Http\Request;
use App\Http\Requests;
use View;
use App\Transformers\ArticleTransformer;

class NewsController extends Controller {

    public function getNews(Main $mainModel) {
        //$page = $mainModel::where('main.id', '=', 13)->query(['seo'=>true,'result'=>'first']);
        //$items = Main::where('main.type_id', '=', 9)->orderBy('date', 'desc')->query(['seo'=>false,'result'=>'get']);

        return View::make('news.index');
    }

    public function getNewsItem(Main $mainModel, $slug) {
        $item = $mainModel::where('slug', '=', $slug)->query(['seo'=>true,'result'=>'first']);

        return View::make('news.view', compact('item'));
    }

    public function getAjaxNews(Request $request, Main $mainModel) {
        $perPage = $request->get('perPage');
        $filtersData = $request->get('filtersData');

        $tag = $filtersData['tag'];

        $query = Main::where('main.type_id', '=', 9)->orderBy('created_at', 'desc');

        if ($tag) {
            $query->leftJoin('main_tag', function ($join) {
                $join->on('main.id', '=', 'main_tag.main_id');
            })->where('tag_id', $tag);
        }

        $items = $query->query(['seo'=>false,'result'=>'paginate:'.$perPage]);

        return response()->json([
            'lastPage' => $items->lastPage(),
            'items' => fractal()
                ->collection($items)
                ->transformWith(new NewsTransformer())
        ]);
    }

    public function redirect(Request $request, Main $mainModel, $id)
    {
        $item = $mainModel->where('id_old', $id)->first();

        if($item) return redirect()->route('news.view', $item->slug);
        return abort(404);
    }

    //MERT//

    public function getNewsMert(Main $mainModel) {
        return View::make('explanations.index');
    }

    public function getNewsItemMert(Main $mainModel, $slug) {
        $item = $mainModel::where('slug', '=', $slug)->query(['seo'=>true,'result'=>'first']);

        return View::make('explanations.view', compact('item'));
    }

    public function getAjaxNewsMert(Request $request, Main $mainModel) {
        $perPage = $request->get('perPage');
        $filtersData = $request->get('filtersData');

        $tag = $filtersData['tag'];

        $query = Main::where('main.type_id', '=', 22)->orderBy('created_at', 'desc');

        if ($tag) {
            $query->leftJoin('main_tag', function ($join) {
                $join->on('main.id', '=', 'main_tag.main_id');
            })->where('tag_id', $tag);
        }

        $items = $query->query(['seo'=>false,'result'=>'paginate:'.$perPage]);

        return response()->json([
            'lastPage' => $items->lastPage(),
            'items' => fractal()
                ->collection($items)
                ->transformWith(new NewsTransformer())
        ]);
    }

    public function redirectMert(Request $request, Main $mainModel, $id)
    {
        $item = $mainModel->where('id_old', $id)->first();

        if($item) return redirect()->route('news-mert.view', $item->slug);
        return abort(404);
    }
}
