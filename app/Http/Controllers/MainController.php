<?php namespace App\Http\Controllers;

use App\Models\Main;
use Baum\Node;
use Illuminate\Http\Request;
use App\Http\Requests;
use View;
use Flash;
use Session;
use Illuminate\Support\Facades\Input;
use Settings;

class MainController extends Controller {

    //get - /
    public function getIndex(Main $mainModel) {
        return View::make('pages.main');
    }

    public function getLandingPoradi() {
        return View::make('landing.poradi.index');
    }

    public function getLandingYak() {
        return View::make('landing.yak.index');
    }

    //post - /ajax/Feedback
    public function postFeedback(Request $request) {
        $data = $request->except(['_token']);

        //отправляем письмо
        \Mail::send(['html' => 'emails.feedback'], ['data'=>$data], function ($message) use ($data) {
            //отправляем приложенные файлы
            if(isset($data['files'])) {
                foreach($data['files'] as $file) {
                    $message->attach($file->getRealPath(), [
                        'as' => 'file.' . $file->getClientOriginalExtension(),
                        'mime' => $file->getMimeType()
                    ]);
                }
            }

            $message->to(Settings::get('global_settings_email'))->subject('Feedback form')->from(Settings::get('global_settings_email'));
        });
    }

    public function subscribe(Request $request) {
        $data = $request->except(['_token']);

        //отправляем письмо
        \Mail::send(['html' => 'emails.subscribe'], ['data'=>$data], function ($message) use ($data) {
            //отправляем приложенные файлы
            if(isset($data['files'])) {
                foreach($data['files'] as $file) {
                    $message->attach($file->getRealPath(), [
                        'as' => 'file.' . $file->getClientOriginalExtension(),
                        'mime' => $file->getMimeType()
                    ]);
                }
            }

            $message->to(Settings::get('global_settings_email'))->subject('Feedback form')->from(Settings::get('global_settings_email'));
        });

        return 'true';
    }


/////////////////////////EXAMPLES////////////////////////

//    public function getIndex(Main $mainModel) {
//        //$locations = Main::where('main.type_id', '=', 33)->query(['with'=>['images'],'seo'=>false,'result'=>'get']);
//        //$testimonials = Main::where('main.type_id', '=', 35)->query(['seo'=>false,'result'=>'get']);
//        //$treatments = Main::where('main.type_id', '=', 37)->query(['seo'=>false,'result'=>'get']);
//        //$main = Main::where('main.id', '=', 72)->query(['seo'=>true,'result'=>'first']);
//        //$page = Main::where('slug', '=', 'main-page')->query(['with'=>'','seo'=>true,'result'=>'first']);
//        //$slides = Main::where('main.type_id', '=', 19)->query(['with'=>['images'],'result'=>'get']);
//        //$posts = Main::where('type_id', '=', 12)->orderBy('created_at', 'desc')->query(['with'=>'images','result'=>'paginate:4']);
//        //$quick_links = Main::where('slug', '=', 'quick-links')->query(['with'=>'','result'=>'first']);
//
//        //$experience = Main::where('main.id', '=', 30)->query(['seo'=>false,'result'=>'first']);
//        //return View::make('main', compact('experience'));
//
//        return View::make('pages.main');
//    }

//    public function getCompany(Main $mainModel) {
//        $page = Main::where('main.id', '=', 20)->query(['with'=>'','seo'=>true,'result'=>'first']);
//        $in_numbers = Main::where('main.type_id', '=', 16)->query(['seo'=>false,'result'=>'get','sort'=>'sort']);
//        $text_blocks = Main::where('main.type_id', '=', 20)->query(['seo'=>false,'result'=>'get','sort'=>'sort']);
//
//        return View::make('pages.company', compact('page','in_numbers','text_blocks'));
//    }
//
//    public function getContacts(Main $mainModel) {
//        $page = Main::where('main.id', '=', 9)->query(['seo'=>true,'result'=>'first']);
//        $filials = Main::where('main.type_id', '=', 11)->query(['seo'=>false,'result'=>'get','sort'=>'sort']);
//
//        return View::make('pages.contacts', compact('page','filials'));
//    }
//

//
//    public function getServices(Main $mainModel) {
//        //$page = Main::where('main.id', '=', 10)->query(['seo'=>true,'result'=>'first']);
//        $text_blocks = Main::where('main.type_id', '=', 26)->query(['with'=>'','result'=>'get','sort'=>'sort']);
//        $license_block = Main::where('main.id', '=', 37)->query(['with'=>'','result'=>'first','sort'=>'sort']);
//        $licenses = Main::where('main.type_id', '=', 28)->query(['with'=>'','result'=>'get','sort'=>'sort']);
//
//        $companies_block = Main::where('main.id', '=', 46)->query(['with'=>'','result'=>'first','sort'=>'sort']);
//        $companies = Main::where('main.type_id', '=', 30)->query(['with'=>'','result'=>'get','sort'=>'sort']);
//
//        return View::make('pages.services', compact('text_blocks','license_block','licenses','companies_block','companies'));
//    }
//
//    public function getPrivacy(Main $mainModel) {
//        $page = Main::where('main.id', '=', 7)->query(['seo'=>true,'result'=>'first']);
//
//        return View::make('pages.text', compact('page'));
//    }
//
//    public function getTermsOfUse(Main $mainModel) {
//        $page = Main::where('main.id', '=', 4)->query(['seo'=>true,'result'=>'first']);
//
//        return View::make('pages.text', compact('page'));
//    }
//
//    public function getCareer(Main $mainModel) {
//        $page = Main::where('main.id', '=', 8)->query(['seo'=>true,'result'=>'first']);
//
//        return View::make('pages.text', compact('page'));
//    }
//
//    public function getAjaxNews(Request $request, Main $mainModel) {
//        $search_text = $request->get('search_text');
//        $limit = $request->get('limit');
//
//        if($search_text) $limit = 100;
//
//        $query = Main::where('main.type_id', '=', 13)
//            ->where(function($query) use ($search_text) {
//                $query
//                    ->where('main_translations.name', 'LIKE', '%' . $search_text . '%')
//                    ->Orwhere('text', 'LIKE', '%'.$search_text.'%');
//            })
//            ->orderBy('date', 'desc');
//
//        $news_items = $query->limit($limit)->query(['seo'=>false,'result'=>'get']);
//
//        $count = $query->count();
//
//        $returnHTML = View::make('blocks.news-item', compact('news_items'))->render();
//
//        return response()->json(array('success' => true, 'count' => $count, 'html'=>$returnHTML));
//        //return View::make('blocks.news-item', compact('news_items'));
//    }
//
//    public function getAjaxServices(Request $request, Main $mainModel) {
//        $search_text = $request->get('search_text');
//        $limit = $request->get('limit');
//
//        if($search_text) $limit = 100;
//
//        $query = Main::where('main.type_id', '=', 30)
//            ->where(function($query) use ($search_text) {
//                $query
//                    ->where('main_translations.name', 'LIKE', '%' . $search_text . '%')
//                    ->Orwhere('text', 'LIKE', '%'.$search_text.'%');
//            })
//            ->orderBy('date', 'desc');
//
//        $items = $query->limit($limit)->query(['seo'=>false,'result'=>'get']);
//
//        $count = $query->count();
//
//        $returnHTML = View::make('blocks.company-item', compact('items'))->render();
//
//        return response()->json(array('success' => true, 'count' => $count, 'html'=>$returnHTML));
//        //return View::make('blocks.news-item', compact('news_items'));
//    }

//    public function getFaq(Main $mainModel) {
//        $page = Main::where('main.id', '=', 10)->query(['seo'=>true,'result'=>'first']);
//        $items = Main::where('main.type_id', '=', 6)->query(['with'=>'','result'=>'get','sort'=>'sort']);
//
//        return View::make('pages.faq', compact('items'));
//    }
//
//    public function getProjects(Main $mainModel) {
//        $page = Main::where('main.id', '=', 16)->query(['seo'=>true,'result'=>'first']);
//        $projects = Main::where('main.type_id', '=', 9)->query(['with'=>'','result'=>'get','sort'=>'sort']);
//
//        return View::make('pages.projects', compact('projects'));
//    }




//    //get - /blog/
//    public function getBlog() {
//        $page = Main::where('slug', '=', 'blog')->query(['with'=>[],'seo'=>true,'result'=>'first']);
//        $items = Main::where('main.type_id', '=', 12)->orderBy('created_at', 'desc')->query(['with'=>['images','relate','parent'],'result'=>'paginate:4']);
//
//        return View::make('blog/main', compact('items'));
//    }
//
//    //get - /blog/{slug}
//    public function getBlogCategory($slug) {
//        $root_category = Main::where('slug', '=', $slug)->query(['with'=>'','seo'=>true,'result'=>'first']);
//        //$items = $root_category->leaves()->paginate(3);
//        $items = Main::where('parent_id', '=', $root_category->id)->orderBy('created_at', 'desc')->query(['with'=>['images'],'result'=>'paginate:3']);
//
//        return View::make('blog/main', compact('items'));
//    }
//
//    //get - /blog/{category_slug}/{slug}
//    public function getBlogPost($category_slug, $slug) {
//        $category = Main::where('slug', '=', $category_slug)->query(['with'=>[],'result'=>'first']); //for 404
//        $item = Main::where('slug', '=', $slug)->query(['with'=>['images'],'seo'=>true,'result'=>'first']);
//
//        return View::make('blog/post', compact('item'));
//    }
//
//    //get - /tag/tags/{slug}
//    public function getBlogTag($slug) {
//        //$root_tag = Main::findBySlug($slug);
//        $root_tag = Main::where('slug', '=', $slug)->query(['with'=>'','seo'=>true,'result'=>'first']);
//        //$items = $root_tag->relate()->query(['with'=>['images','relate2','parent'],'result'=>'paginate:3']);
//        $items = $root_tag->relate()->with(['images', 'parent', 'relate'])->paginate(5);
//        //$items = $root_tag->relate()->query(['with'=>['images','relate','parent'],'result'=>'paginate:5']);
//
//        return View::make('blog/main', compact('items'));
//    }
//
//    //get - /service
//    public function getService() {
//        $page = Main::where('slug', '=', 'services')->query(['with'=>[],'seo'=>true,'result'=>'first']);
//        $items = Main::where('main.type_id', '=', 17)->query(['with'=>['images'],'result'=>'paginate:5']);
//
//        return View::make('services/main', compact('items'));
//    }
//
//    //get - /service/{slug}
//    public function getServiceArticle($slug) {
//        $article = Main::where('slug', '=', $slug)->query(['with'=>['images'],'seo'=>true,'result'=>'first']);
//
//        return View::make('services/article', compact('article'));
//    }
//
//    //get - /privacy_policy/
//    public function getPrivacyPolicy() {
//        $page = Main::where('slug', '=', 'privacy-policy')->query(['with'=>[],'result'=>'first']);
//
//        return View::make('single_page/privacy_policy', compact('page'));
//    }
//
//    //get - /terms_of_service/
//    public function getTermsOfService() {
//        $page = Main::where('slug', '=', 'terms-of-service')->query(['with'=>[],'result'=>'first']);
//
//        return View::make('single_page/terms_of_service', compact('page'));
//    }
}
