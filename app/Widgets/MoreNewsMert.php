<?php namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;
use App\Models\Main;
use View;
use DB;

class MoreNewsMert extends AbstractWidget {

    public $cacheTime = 0;

    public function run()
    {
        $current_id = $this->config['current_id'];

        $item = Main::where('main.id', $current_id)->query()->first();

        $search_string = $item->name.' '.$item->tags->implode('name',' ');

        $search_string_exploded = explode(' ', $search_string);

        foreach ($search_string_exploded as $q) {
            $q = '%'.trim(addslashes(strip_tags($q))).'%';
            $like_arr[] = '(main_translations.name LIKE "'.$q.'")';
        }
        $like = implode('+',$like_arr);

        $items = Main::where('main.type_id', '=', 22)
            ->whereNotIn('id', [$current_id])
            ->where('bool3', 0)
            ->query()
            ->addSelect(DB::raw($like. 'as hits'))
            ->orderBy('hits', 'desc')
            ->limit(3)
            ->get();

        return View::make('widgets.more_news_mert', compact('items'));
    }
}