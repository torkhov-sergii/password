<?php namespace App\Http\Controllers;

use App\Models\Main;
use App\Transformers\ArticleTransformer;
use Baum\Node;
use Illuminate\Http\Request;
use App\Http\Requests;
use View;
use Flash;
use Session;
use Illuminate\Support\Facades\Input;
use Settings;
use DB;
use Illuminate\Pagination\Paginator;

class ArticlesController extends Controller {

    public function getArticles(Main $mainModel)
    {
        return View::make('articles.index');
    }

    public function getArticleItem(Main $mainModel, $slug)
    {
        $item = $mainModel::where('slug', '=', $slug)->query(['seo'=>true,'result'=>'first']);

        $interesting_items = $item->getRelateByType(16);
        $interesting_html = view('articles.block.interesting', compact('interesting_items'))->render();
        $item->text = str_replace('[interesting]', $interesting_html, $item->text);

        return View::make('articles.view', compact('item'));
    }

    public function getAjaxArticles(Request $request, Main $mainModel)
    {
        $perPage = $request->get('perPage');
        $filters_ids = $request->get('filters_ids');
        $filtersData = $request->get('filtersData');
        $filtersSort = $request->get('filtersSort');

        $tag = $filtersData['tag'];
        $difficulty = $filtersData['difficulty'];
        $author = $filtersData['author'];

        $query = Main::
        where('main.type_id', '=', 16)
            ->leftJoin('main_main', function ($join) {
                $join->on('main.id', '=', 'main_main.main_id1');
            })
            ->groupBy('main_id1')
            ->query()
            ->select('main_translations.*', 'main.*', DB::raw('GROUP_CONCAT(DISTINCT main_id2 SEPARATOR \',\') as relations_ids'));
            //->having('relations_ids', 'LIKE', '%28%')

        if($filters_ids) {
            foreach ($filters_ids as $id) {
                $query->having('relations_ids', 'LIKE', '%'.$id.'%');
            }
        }

        if ($tag) {
            $query->leftJoin('main_tag', function ($join) {
                $join->on('main.id', '=', 'main_tag.main_id');
            })->where('tag_id', $tag['id']);
        }

        if ($difficulty) {
            $query->where('select3', $difficulty);
        }

        if ($author) {
            $query->where('user_id', $author['id']);
        }

        $sort_direction = $filtersSort['direction'] ? 'asc' : 'desc';
        if($filtersSort['key'] == 'date') $query->orderBy('created_at', $sort_direction);
        elseif($filtersSort['key'] == 'popularity') $query->orderBy('id', $sort_direction);
        else $query->orderBy('id', 'desc');

        $curPage = Paginator::resolveCurrentPage(); // reads the query string, defaults to 1

        // clone the query to make 100% sure we don't have any overwriting
        $itemQuery = clone $query;
        $itemQuery->addSelect('main.*');
        // this does the sql limit/offset needed to get the correct subset of items
        $items = $itemQuery->forPage($curPage, $perPage)->get();

        // manually run a query to select the total item count
        // use addSelect instead of select to append
        $totalResult = $query->addSelect(DB::raw('count(*) as count'))->get();

        $totalItems = $totalResult->count();

        // make the paginator, which is the same as returned from paginate()
        // all() will return an array of models from the collection.
        //$items = new Paginator($items->all(), $totalItems, $perPage);
        $items = new Paginator($items->all(), $perPage);

        return response()->json([
            'lastPage' => number_format(ceil($totalItems/$perPage), 0),
            'items' =>
                fractal()
                ->collection($items)
                ->transformWith(new ArticleTransformer())
        ]);
    }

    public function redirect(Request $request, Main $mainModel, $id)
    {
        $item = $mainModel->where('id_old', $id)->first();

        if($item) return redirect()->route('articles.view', $item->slug);
        return abort(404);
    }

    public function getAjaxSliderArticles(Request $request, Main $mainModel)
    {
        $type = $request->get('type');

        $query = Main::
        where('main.type_id', '=', 16)
            ->leftJoin('main_main', function ($join) {
                $join->on('main.id', '=', 'main_main.main_id1');
            })
            ->groupBy('main_id1')
            ->query()
            ->select('main_translations.*', 'main.*', DB::raw('GROUP_CONCAT(DISTINCT main_id2 SEPARATOR \',\') as relations_ids'));

        if($type) {
            $query->having('relations_ids', 'LIKE', '%'.$type.'%');
        }

        $items = $query->limit(10)->get();

        return response()->json([
            'items' =>
                fractal()
                    ->collection($items)
                    ->transformWith(new ArticleTransformer())
        ]);
    }
}