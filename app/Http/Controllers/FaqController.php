<?php namespace App\Http\Controllers;

use App\Models\Main;
use Illuminate\Http\Request;
use App\Http\Requests;
use View;
use App\Transformers\ArticleTransformer;
use JavaScript;

class FaqController extends Controller {

    public function getIndex(Main $mainModel) {
        $categories = Main::where('main.type_id', '=', 30)->orderBy('date', 'desc')->query(['seo'=>false,'result'=>'get']);

//        JavaScript::put([
//            'items' => $items,
//        ]);

        return View::make('faq.index', compact('categories'));
    }

    public function getItem(Main $mainModel, $slug) {
        $item = $mainModel::where('slug', '=', $slug)->query(['seo'=>true,'result'=>'first']);

        return View::make('faq.view', compact('item'));
    }

}
