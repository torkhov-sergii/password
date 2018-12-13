<?php namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;
use App\Models\Main;
use View;
use Settings;

class StartSide extends AbstractWidget {

    public $cacheTime = 0;

    protected $config = [
        'type' => 0,
    ];

    public function run()
    {
        $type = $this->config['type'];

 //       $item = Main::where('main.id', '=', 57)->query(['with'=>'','result'=>'first']);

        if($type == 'customer' || $type == 'customer_big') {
            $data = unserialize(Settings::get('customer'));
        };

        if($type == 'participant') {
            $data = unserialize(Settings::get('participant'));
        };

        if($type == 'press') {
            $data = unserialize(Settings::get('press'));
        };

//        if($type == 'customer' || $type == 'customer_big') $content = $item['text'];
//        if($type == 'participant') $content = $item['text2'];
//        if($type == 'press') $content = $item['text3'];

        return View::make('widgets.start_side.'.$type, compact('content','data'));
    }
}