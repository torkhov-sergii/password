<?php namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;
use App\Models\Main;
use View;

class HeaderMenu extends AbstractWidget {

    protected $config = [
        'current_category_slug' => null,
    ];
    public $cacheTime = 10;

    public function run()
    {
        $items = Main::where('main.parent_id', '=', 3)->where('bool1', 1)->query(['with'=>'','result'=>'get','sort'=>'sort']);

        $current_category_slug = $this->config['current_category_slug'];

        return View::make('widgets.header-menu', compact('items', 'current_category_slug'));
    }
}