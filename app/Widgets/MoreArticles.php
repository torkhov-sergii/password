<?php namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;
use App\Models\Main;
use View;
use DB;

class MoreArticles extends AbstractWidget {

    protected $config = [
        'item' => null,
    ];

    public $cacheTime = 0;

    public function run()
    {
        $item = $this->config['item'];

        $search_string = $item->name.' '.$item->tags->implode('name',' ');

        $search_string_exploded = explode(' ', $search_string);

        foreach ($search_string_exploded as $q) {
            $q = '%'.trim(addslashes(strip_tags($q))).'%';
            $like_arr[] = '(main_translations.name LIKE "'.$q.'")';
        }
        $like = implode('+',$like_arr);

        $items = Main::where('main.type_id', '=', 16)
            ->whereNotIn('id', [$item->id])
            ->where('bool3', 0)
            ->query()
            ->addSelect(DB::raw($like. 'as hits'))
            ->orderBy('hits', 'desc')
            ->limit(3)
            ->get();



//        $chapter = $item->getRelateByType(19)->first();
//        $type = $item->getRelateByType(20)->first();
//
//        //$items = Main::where('main.type_id', '=', 16)->limit(3)->inRandomOrder()->query(['with'=>'','result'=>'get','sort'=>'sort']);
//        $query = Main::where('main.type_id', '=', 16)
//            ->where('main.id', '!=', $item->id)
//            ->leftJoin('main_main', function ($join) {
//                $join->on('main.id', '=', 'main_main.main_id1');
//            })
//            ->groupBy('main_id1')
//            ->query()
//            ->select('main_translations.*', 'main.*', DB::raw('GROUP_CONCAT(DISTINCT main_id2 SEPARATOR \',\') as relations_ids'))
//            ->limit(3)
//            ->inRandomOrder();
//
//        if($chapter) {
//            $query->having('relations_ids', 'LIKE', '%'.$chapter->id.'%');
//        }
//
//        if($type) {
//            $query->having('relations_ids', 'LIKE', '%'.$type->id.'%');
//        }
//
//        $items = $query->get();

        return View::make('widgets.more_articles', compact('items'));
    }
}