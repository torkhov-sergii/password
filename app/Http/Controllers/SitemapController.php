<?php namespace App\Http\Controllers;

use DB;
use App;
use URL;
use Route;
use App\Models\User;
use App\Models\Main;
use App\Models\Tag;
use Carbon\Carbon;

class SitemapController extends Controller {

	public function generate()	{
        // create new sitemap object
        $sitemap = App::make("sitemap");

        // set cache key (string), duration in minutes (Carbon|Datetime|int), turn on/off (boolean)
        // by default cache is disabled
        $sitemap->setCache('laravel.sitemap', 60);

        // check if there is cached sitemap and build new only if is not
        if (!$sitemap->isCached())
        {

            // add item to the sitemap (url, date, priority, freq)
            $sitemap->add(route('home'), Carbon::now()->toDateTimeString(), '1.0', 'daily');

            //news
            $items = Main::where('main.type_id', '=', 9)->get();
            foreach ($items as $item) {
                $sitemap->add(route('news.view', [$item->slug]), $item->updated_at, '0.5', 'monthly');
            }

            //news-mert
            $items = Main::where('main.type_id', '=', 22)->get();
            foreach ($items as $item) {
                $sitemap->add(route('news-mert.view', [$item->slug]), $item->updated_at, '0.5', 'monthly');
            }

            //courses
            $items = Main::where('main.type_id', '=', 24)->get();
            foreach ($items as $item) {
                $sitemap->add(route('courses.view', [$item->slug]), $item->updated_at, '0.8', 'monthly');
            }

            //articles
            $items = Main::where('main.type_id', '=', 16)->get();
            foreach ($items as $item) {
                $sitemap->add(route('articles.view', [$item->slug]), $item->updated_at, '0.6', 'monthly');
            }

            //faq
            $items = Main::where('main.type_id', '=', 28)->get();
            foreach ($items as $item) {
                $sitemap->add(route('faq.view', [$item->slug]), $item->updated_at, '0.3', 'monthly');
            }


//            //blog
//            $sitemap->add(route('blog'), $date, '0.9', 'monthly');
//            //blog category
//            $items = Main::where('main.type_id', '=', 11)->get();
//            foreach ($items as $item) {
//                $sitemap->add(route('blog.category', $item->slug), $item->updated_at, '0.7', 'monthly');
//            }


//            //posts
//            $items = Main::where('main.type_id', '=', 3)->limit(10000)->get();
//            foreach ($items as $item) {
//                $sitemap->add(url($item->postUrl()), $item->updated_at, '0.7', 'monthly');
//            }

//            //tags
//            $items = Tag::where('id', '>', 0)->limit(10000)->get();
//            foreach ($items as $item) {
//                $sitemap->add(route('tag', $item->slug), $item->updated_at, '0.3', 'monthly');
//            }
        }

        // show your sitemap (options: 'xml' (default), 'html', 'txt', 'ror-rss', 'ror-rdf')
        return $sitemap->render('xml');
	}

}
