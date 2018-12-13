<?php namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;
use App\Models\Main;
use View;

class News extends AbstractWidget {

    public $cacheTime = 0;

    protected $config = [
        'type' => 0,
    ];

    public function run()
    {
        $type = $this->config['type'];

        $items = Main::where('main.type_id', '=', $type)->limit(3)->query(['with'=>'','result'=>'get','sort'=>'-created_at']);

        return View::make('widgets.news', compact('items','type'));
    }
}