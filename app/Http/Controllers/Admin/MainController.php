<?php namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Models\Main;
use App\Models\Type;
use DB;
use View;
use Flash;
use Auth;
use Input;
use Settings;
use Request as Request2;
use Session;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Helpers;
use DataTables;
use App\Models\Tag;

class MainController extends Controller {

	//get /admin/main
	public function index(Main $mainModel, Request $request) {
        Main::rebuildSort();

        $selected_category = $request->get('selected_category');
        //$category = $mainModel->find($selected_category);

        $user = Auth::user();
        $allowCategories = $user->getAllowCategories();
        if(count($allowCategories)) {
            if(!in_array($selected_category, $allowCategories)) {
                return abort(404);
            }
        }

        if($selected_category) {
            $category = $mainModel->where('main.id',$selected_category)->query(['with'=>[],'result'=>'first','show_hidden'=>true]);
        }
        else {
            return View('admin.main');
        }

        return View('admin.main.main_server_side', compact('category'));
	}
 
	public function create(Main $mainModel, Type $typeModel, $parent_id, $type_id) {
        $main = $mainModel->getNodeById($parent_id);

		return view('admin.main.create', compact('root', 'parent_id', 'type_id', 'main'));
	}

	public function store(Request $request, Main $mainModel, Type $typeModel) {
		$data = $request->except(['_token','parent_id']);
		$parent = $request->input('parent_id');

        //автор
        $data['user_id'] = Auth::user()->id;

        //сортировка
        $max_sort = DB::table('main')->max('sort');
        $data['sort'] = $max_sort+1;

        //создаем
        //$data['slug'] = Main::createSlug($data['name']);
        $data['slug'] = SlugService::createSlug(Main::class, 'slug', $data['name']);
		$main = Main::create($data);
        $main->updateTranslations($data);

        //родитель
        $node_parent = $mainModel::findOrFail($parent);;
		$main->makeChildOf($node_parent);

		Flash::success('Item was added');
		return redirect()->route('admin.main.edit', $main->id);
	}

	//get /admin/main/{$id}/edit
	public function edit(Request $request, Type $typeModel, Main $mainModel, $id) {
        $locale = \App::getLocale();
        $locales = config('app.locales');
        $main = $mainModel::where('main.id', '=', $id)->query(['with'=>'','result'=>'first','show_hidden'=>true]);

        $user = Auth::user();
        $allowCategories = $user->getAllowCategories();
        if(count($allowCategories)) {
            $main_ancestors = $main->getAncestors()->pluck('id')->toArray();

            if(count(array_intersect($main_ancestors, $allowCategories)) < count($main_ancestors)) {
                return abort(404);
            }
        }

        //Разрешено ли пользователяю менять slug - разрешено, только если в rout->url встречается slug
        //все роуты в массив
        foreach (Route::getRoutes() as $value) {
            $name = $value->getName();
            //echo '<br>'.$value->getPath();
            $routes[$name] = $value;
        }
        if(isset($main->type->route)) {
            $item_route_name = $main->type->route;

            if(isset($routes[$item_route_name]->getAction()['url'])) {
                foreach($routes[$item_route_name]->getAction()['url'] as $url) {
                    if($url == 'slug') $main->change_slug = true;
                }
            }
        }

        //получить список связанных элементов
        $relate_with = unserialize($main->type['relate_with']);
        if(is_array($relate_with)) {
            foreach($relate_with as $relate) {
                $type = $typeModel->getNodeById($relate);
                if (!empty($type)) {
                    $types[$type->id] = $type;

                    //$tepe_category = $mainModel->where('main.type_id',$type->parent->id)->where('parent_id', 1)->first();
                    $tepe_category = $mainModel->where('main.type_id',$type->parent->id)->first();
                    if($tepe_category) {
                        $relate_list[$relate] = $mainModel->where('main.id',$tepe_category->id)->query(['with'=>[],'result'=>'get']);
                    }
                    //$relate_list[$relate] = $mainModel->where('main.type_id',$type->id)->query(['with'=>[],'result'=>'get']);
                    //$relate_list[$relate] = $mainModel->where('main.type_id',$type->id)->where('parent_id', '!=',  1)->query(['with'=>[],'result'=>'get']);
                }
            }
        }

        if (count($locales)>1) {
            $current_url = Request2::root(). '/' . $locale . $main->getUrl();
        } else {
            $current_url = Request2::root().$main->getUrl();
        }

        //хук для мегаполя seo_meta_tags
        if($main['seo_meta_tags'] == '') {
            $main_seo = Main::where('main.id', '=', $id)->query(['with'=>'','result'=>'first','seo'=>true,'show_hidden'=>true]);
            $mainModel->seo($main_seo);
            $main['seo_meta_tags'] = '
            <title>'.$GLOBALS['meta']['title'].'</title>
            <meta name="description" content="'.$GLOBALS['meta']['description'].'" />

            <!-- Schema.org markup for Google+ -->
            <meta itemprop="name" content="'.$GLOBALS['meta']['title'].'">
            <meta itemprop="description" content="'.$GLOBALS['meta']['description'].'">
            <meta itemprop="image" content="">

            <!-- Twitter Card data -->
            <meta name="twitter:card" content="summary">
            <meta name="twitter:site" content="'.Settings::get('global_twitter_site').'">
            <meta name="twitter:title" content="'.$GLOBALS['meta']['title'].'">
            <meta name="twitter:description" content="'.$GLOBALS['meta']['description'].'">
            <meta name="twitter:creator" content="'.Settings::get('global_twitter_creator').'">
            <!-- Twitter summary card with large image must be at least 280x150px -->
            <meta name="twitter:image:src" content="">

            <!-- Open Graph data -->
            <meta property="og:title" content="'.$GLOBALS['meta']['title'].'" />
            <meta property="og:type" content="article" />
            <meta property="og:url" content="'. $current_url .'" />
            <meta property="og:image" content="" />
            <meta property="og:description" content="'.$GLOBALS['meta']['description'].'" />
            <meta property="og:site_name" content="'.Settings::get('global_og_site_name').'" />
            <meta property="article:published_time" content="'.$GLOBALS['meta']['published_time'].'" />
            <meta property="article:section" content="'.$GLOBALS['meta']['article_section'].'" />
            <meta property="article:tag" content="" />
            <meta property="fb:admins" content="'.Settings::get('global_fb_admins').'" />';
            $main['seo_meta_tags'] = str_replace("            ",'',$main['seo_meta_tags']);
        }

        $seo_alternates = [];
        if (count($locales)>1) {
            foreach($locales as $locale_code=>$locale_name) {
                $current_url_alt = Request2::root(). '/' . $locale_code . $main->getUrl();
                if ($locale_code == 'en') { $hreflang = 'en-gb'; }
                else { $hreflang = $locale_code . '-' . $locale_code; }

                $seo_alternates[$locale_code] = ['url' => $current_url_alt, 'hreflang' => $hreflang];
            }
        }

        $category = $mainModel->findOrFail($main->parent_id);

        return view('admin.main.edit', compact('main', 'relate_list', 'types', 'seo_alternates','category'));
	}

	//post /admin/main/{$id}
	public function update(Request $request, Main $mainModel, $id) {
        $data = $request->except(['_token','parent_id']);

        $main = $mainModel::where('main.id', '=', $id)->query(['with'=>'','result'=>'first','show_hidden'=>true]);
        $main->postNode($request);

        if($request->file('files')) {
            foreach ($request->file('files') as $type => $files) {
                //if(!$type) $type = '';
                $main->addFile($files);
            }
        }

        if($request->file('images')) {
            foreach ($request->file('images') as $type => $images) {
                if(!$type) $type = null;
                $main->addImage($images, 0, $type); //file, (0 - обычные фотки, 1 - превьюшки), image_type
            }
        }
        //$main->addImage($request->file('images'), 0, '', $request->input('alt')); //file, (0 - обычные фотки, 1 - превьюшки), image_type
        //$main->addImage($request->file('preview'), 1);
        //$user->destroyAllImage(0); //параметр 0 - обычные фотки, 1 - превьюшки

        //родитель
        $parent = $request->input('parent_id');
        if($parent) {
            $node_parent = $mainModel::findOrFail($parent);
            $main->makeChildOf($node_parent);
        }

        //sync tags
        $tagModel = new Tag();
        $tagModel->attachTag($main, $request->get('tags'));

        //sync relates
        if($main->relate) {
            foreach ($main->relate as $relate) {
                $id1 = $main->id;
                $relate->relate()->detach($id1);
            }
        }
        $main->relate()->detach();
        if($request->get('relates')) {
            foreach ($request->get('relates') as $relate) {
                $id1 = $main->id;
                $id2 = $relate;

                $node1 = $main;
                $node2 = $mainModel->getNodeById($id2);

                $node1->relate()->attach([$id2]);

                $node2->relate()->detach($id1);
                $node2->relate()->attach([$id1]);
            }
        }

        //сохраняем location
        $locations = $request->only('locations');
        if($locations) {
            $main->saveLocations($locations);
        }

        Flash::success('Saved successfully');
		return \Redirect::back();
	}

	//destroy /admin/main/{$id}
	public function destroy(Request $request, Main $mainModel, $id) {
		$node = $mainModel->getNodeById($id);

		$mainModel->destroyNode($node);

		Flash::success('Item was removed');

        return \Redirect::back();
//        if(isset($data['selected_category'])) {
//            return \Redirect::back();
//        }
//        else {
//            return \Redirect::route('admin.main.index');
//        }
	}

    //post /ajax/translate_all/
    public function translateAll() {
        $locale = config('app.fallback_locale');
        $locales = config('app.locales');

        foreach($locales as $lang_code=>$lang_name) {
            $items = DB::table('main_translations')->where('locale', '=', $locale)->get();
            foreach ($items as $item) {
                $item_translations = DB::table('main_translations')->where('main_id', '=', $item->main_id)->where('locale', '=', $lang_code);
                if(!$item_translations->first()) {
                    $data_translations['main_id'] = $item->main_id;
                    $data_translations['locale'] = $lang_code;
                    $data_translations['name'] = $item->name;
                    DB::table('main_translations')->insert($data_translations);
                }
            }
        }

        return 1;
    }

    //get /admin/main/1/up - сортировка
    public function sort($id, $direction) {
        $element = Main::findOrfail($id);
        $element_sort = $element->sort;

        if($direction == 'up') {
            $other_element = Main::where('parent_id', $element->parent_id)->where('sort', '<', $element_sort)->orderBy('sort', 'desc')->first();

            if($other_element) {
                $other_element_sort = $other_element->sort;

                $element->sort = $other_element_sort;
                $element->save();

                $other_element->sort = $element_sort;
                $other_element->save();
            }
        }

        if($direction == 'down') {
            $other_element = Main::where('parent_id', $element->parent_id)->where('sort', '>', $element_sort)->orderBy('sort')->first();

            if($other_element) {
                $other_element_sort = $other_element->sort;

                $element->sort = $other_element_sort;
                $element->save();

                $other_element->sort = $element_sort;
                $other_element->save();
            }
        }

        return \Redirect::back();
    }

    public function serverSide(Main $mainModel, Request $request) {
        $category_id = $request->get('category');

        if($category_id) {
            $items = $mainModel->where('id', '!=', 0)
                ->where('parent_id', $category_id)
                ->query(['with'=>'','result'=>'','show_hidden'=>true])
                ->orderBy('main.sort');
        }

        $datatable = Datatables::of($items)
            ->rawColumns(['option','name','created_at','status'])
            ->addColumn('user', function ($items) {
                return ($items->user) ? $items->user->login : '';
            })
            ->addColumn('option', function ($item) use ($category_id) {
                return view('admin.main.datatable.option', compact(['item','category_id']));
            })
            ->editColumn('name', function ($item) {
                return view('admin.main.datatable.name', compact(['item']));
            })
            ->editColumn('created_at', function ($item) {
                return view('admin.main.datatable.created_at', compact(['item']));
            })
            ->editColumn('status', function ($item) {
                return $item->hide ? trans('admin.main.draft') : trans('admin.main.published');
            })
            /*
            ->editColumn('status', function ($item) {
                return '<span class="badge badge-'.Helpers::status_options($item->status)['class'].'">' . $item->status . '</span>';
            })
            */
            ->filter(function ($query) use ($request) {
                if (@$request->search['value']) {
                    $query
                        //->where('type_id', $type_id)
                        ->where(function ($query) use ($request){
                            $query
                                ->where('main.id', 'like', "%{$request->search['value']}%")
                                ->orWhere('name', 'like', "%{$request->search['value']}%");
                        })

                        /*
                        ->orWhere('main.user', 'like', "%{$request->search['value']}%")
                        ->orWhere('main.surname', 'like', "%{$request->search['value']}%")
                        ->orWhere('main.email', 'like', "%{$request->search['value']}%")
                        ->orWhere('main', 'like', "%{$request->search['value']}%")
                        ->orWhere('main', 'like', "%{$request->search['value']}%")
                        */
                    ;
                }
            });

        return $datatable->make(true);
    }

    /*
    public function serverSideRelate(Main $mainModel, Request $request) {
        $category_id = $request->get('category');

        $category = $mainModel->findOrFail($category_id);

        $items = $category->relate;

        //$type = Main::where('id', '!=', 0)->where('parent_id', $selected_category)->first();

        $datatable = Datatables::of($items)
            ->addColumn('user', function ($items) {
                if($items->user) return $items->user->login;
                else return '';
            })
            ->addColumn('option', function ($items) use ($category) {
                $option = '';
                //if($selected_category == 3) $option .= '<a href="'.url('admin/main/create', [$items->id,$items->type->id]).'" class="btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i> Add sub '.$items->type->name.'</a>';
                if($items->type->isEdit) $option .= '<a href="'.route('admin.main.edit', $items->id).'" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
                //if($doctor->user_id) $option .= '<a href="'.route('user.login_as', $doctor->user_id).'" class="btn btn-warning btn-xs"><i class="glyphicon glyphicon-new-window"></i> Login as user</a>';
                if($items->type->isDel) $option .= '<form action="'.route('admin.main.destroy', $items->id).'" method="POST" style="display: inline;" onsubmit="if(confirm(\'Delete? Are you sure?\')) { return true } else {return false };"><input type="hidden" name="_method" value="DELETE"><input type="hidden" name="_token" value="'.csrf_token().'"> <button class="btn btn-danger btn-xs" type="submit"><i class="glyphicon glyphicon-trash"></i> Delete</button></form>';
                return $option;
            })
            ->editColumn('name', function ($item) {
                if(count($item->children))  {
                    return '<a href="'.route('admin.main.index', ['selected_category'=>$item->id]).'">'.$item->name.'</a>';
                }
                else {
                    return $item->name;
                }
            })
//            ->editColumn('status', function ($item) {
//                return '<span class="badge badge-'.Helpers::status_options($item->status)['class'].'">' . $item->status . '</span>';
//            })
            ->filter(function ($query) use ($request) {
                if (@$request->search['value']) {
                    $query
                        //->where('type_id', $type_id)
                        ->where(function ($query) use ($request){
                            $query
                                ->where('main.id', 'like', "%{$request->search['value']}%")
                                ->orWhere('name', 'like', "%{$request->search['value']}%");
                        })

                        //->orWhere('main.user', 'like', "%{$request->search['value']}%")
//                        ->orWhere('main.surname', 'like', "%{$request->search['value']}%")
//                        ->orWhere('main.email', 'like', "%{$request->search['value']}%")
//                        ->orWhere('main', 'like', "%{$request->search['value']}%")
//                        ->orWhere('main', 'like', "%{$request->search['value']}%")
                    ;
                }
            });
        ;

        return $datatable->make(true);
    }
    */

    public function getPostsInCategory(Main $mainModel, $id) {
        $category = $mainModel->findOrFail($id);

        return View::make('admin.main.main_server_side_posts', compact('category'));
    }
}
