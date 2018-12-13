<?php namespace App\Http\Controllers;

use App\Models\Main;
use Baum\Node;
use Illuminate\Http\Request;
use App\Http\Requests;
use View;
use Flash;
use Session;

class BlogController extends Controller {

    //------------------------------------BLOG-----------------------------------
    //get - /blog/
    public function getBlog() {
        $page = Main::where('slug', '=', 'blog')->query(['with'=>[],'seo'=>true,'result'=>'first']);
        $items = Main::where('main.type_id', '=', 52)->query(['with'=>['images','relate','parent'],'result'=>'paginate:4']);

        return View::make('blog.main', compact('items'));
    }

    //get - /blog/{slug}
    public function getBlogCategory($slug) {
        $root_category = Main::where('slug', '=', $slug)->query(['with'=>'','seo'=>true,'result'=>'first']);
        //$items = $root_category->leaves()->paginate(3);
        $items = Main::where('parent_id', '=', $root_category->id)->query(['with'=>['images'],'result'=>'paginate:3']);

        return View::make('blog.main', compact('items'));
    }

    //get - /blog/{category_slug}/{slug}
    public function getBlogPost($category_slug, $slug) {
        $category = Main::where('slug', '=', $category_slug)->query(['with'=>[],'result'=>'first']); //for 404
        $item = Main::where('slug', '=', $slug)->query(['with'=>['images'],'seo'=>true,'result'=>'first']);

        return View::make('blog.post', compact('item'));
    }

    //get - /tag/tags/{slug}
    public function getBlogTag($slug) {
        //$root_tag = Main::findBySlug($slug);
        $root_tag = Main::where('slug', '=', $slug)->query(['with'=>'','seo'=>true,'result'=>'first']);
        //$items = $root_tag->relate()->query(['with'=>['images','relate2','parent'],'result'=>'paginate:3']);
        $items = $root_tag->relate()->with(['images', 'parent', 'relate'])->paginate(5);
        //$items = $root_tag->relate()->query(['with'=>['images','relate','parent'],'result'=>'paginate:5']);

        return View::make('blog.main', compact('items'));
    }

}
