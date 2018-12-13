<?php namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;
use App\Models\Main;
use View;

class Courses extends AbstractWidget {

    public $cacheTime = 0;

    protected $config = [
        'type' => 'default',
    ];

    public function run()
    {
        $type = $this->config['type'];

        $items = Main::where('main.type_id', '=', 24)->limit(6)->query(['with'=>'','result'=>'get','sort'=>'-created_at']);

        return View::make('widgets.courses', compact('items', 'type'));
    }
}