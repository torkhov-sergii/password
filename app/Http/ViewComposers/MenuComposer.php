<?php namespace App\Http\ViewComposers;

use App\Models\Main;
use Illuminate\Contracts\View\View;
use App\Libraries\CurrentSpot;
use Cache;

class MenuComposer {

    //меню сайта
    public function compose(View $view) {
////        $services_menu = Main::where('main.type_id', '=', 32)->query(['seo'=>false,'result'=>'get']);
////
//        $mainModel = new Main();
//
//        $services_menu = Cache::remember('services_menu', 30, function() use ($mainModel) {
//            return Main::where('type_id', '=', 32)->query(['with'=>'','result'=>'get']);
//        });
//
//        $view->with('services_menu', $services_menu);
    }
}