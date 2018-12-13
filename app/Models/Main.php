<?php namespace App\Models;

use App\Libraries\ExtendNode;
use Illuminate\Support\Facades\Input;
use App\Models\Traits\ImagesTrait;
use App\Models\Traits\FilesTrait;
use Illuminate\Support\Facades\Route;
use App;
use DB;
use Settings;
//use Carbon;
use Helpers;
use Symfony\Component\Console\Helper\Helper;
use Cviebrock\EloquentSluggable\Sluggable;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Services\SlugService;
use App\Models\Traits\Commentable;
use App\Models\Traits\Locationable;

class Main extends ExtendNode {

    use ImagesTrait, FilesTrait, Sluggable, Commentable, Locationable;

    protected $table = 'main';
    protected $parentColumn = 'parent_id';
    protected $leftColumn = 'lft';
    protected $rightColumn = 'rgt';
    protected $depthColumn = 'depth';
    protected $orderColumn = 'sort';
    protected $guarded = array('id', 'parent_id', 'lft', 'rgt', 'depth');
    public $translatedAttributes = ['name','text', 'title', 'description', 'keywords', 'seo_meta_tags', 'text1', 'text2', 'text3', 'string1', 'string2', 'string3', 'string4', 'string5', 'bool1', 'bool2', 'bool3', 'bool4', 'bool5', 'select1', 'select2', 'select3', 'date', 'date2'];
    protected $fillable = ['id', 'type_id', 'user_id', 'slug', 'sort', 'hide', 'created_at'];
    protected $mustBeApproved = true; //for Commentable

    protected $with = ['preview'];

    public function sluggable() {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    //получить рутовую ноду
    public function getRootNode() {
        return Main::root();
    }

    //получить ноду по id
    public function getNodeById($id) {
        //return $this::findOrFail($id);
        return Main::where('main.id', '=', $id)->query(['with'=>'','result'=>'first','show_hidden'=>true]);
    }

    //перечень элементов в виде дерева
    public function getDescendantsTree(Main $node = null) {
        if($node) {
            return $node->getDescendants()->toHierarchy()->all();
        }
        return [];
    }

    //удалить ноду
    public function destroyNode(Main $node) {
        $node->delete();
    }

    //сохранить изменения ноды
    public function postNode($request) {
        $data = $request->except('_token', 'slug', 'images', 'preview');

        //возможность менять slug
        $slug = Input::get('slug');
        if($slug != '' && $this->slug != $slug) $data['slug'] = SlugService::createSlug(Main::class, 'slug', $slug);

        if(isset($data['text'])) $data['text'] = preg_replace('/<span style="font-size: 1rem;">(.*?)<\/span>/', '$1', $data['text']);
        if(isset($data['text2'])) $data['text2'] = preg_replace('/<span style="font-size: 1rem;">(.*?)<\/span>/', '$1', $data['text2']);

        $this->update($data);

        $this->updateTranslations($data);

        //создать slug если его нет
        $this->slugCheck();
    }

    //Check if slug is empty and generate if it isn't
    public function slugCheck() {
        if(empty($this->slug)) // Is slug empty
        {
            $this->sluggify();      // Create slug
            $this->save();          // Save slug to database
        }
        return $this->slug;    // return the slug to echo out
    }

    //получить массив полей ноды
    public function getFieldsArray($type = 'fields') {
        $fields = $this->type[$type];
        $fields_ar = explode(';', $fields);
        $array = [];
        if(is_array($fields_ar)) {
            foreach($fields_ar as $field) {
                if($field) {
                    $field_ar = explode('->',$field);
                    if(is_array($field_ar)) {
                        $name = '';
                        $type = '';
                        $param = null;

                        if(isset($field_ar[0])) $name = $field_ar[0];
                        if(isset($field_ar[1])) $type = $field_ar[1];
                        if(isset($field_ar[2])) $param = json_decode($field_ar[2], true);

                        $array[] = ['name'=>$name,'type'=>$type,'param'=>$param];
                    }
                }
            }
        }

        return $array;
    }

    //сохраняем данные в таблицу main_translations
    public function updateTranslations($data) {
        $locale = \App::getLocale();
        $locales = config('app.locales');

        foreach ($data as $key => $val) {
            if(in_array($key, $this->translatedAttributes)) {
                $data_translations[$key] = $val;
            }
        }

        if(!isset($data_translations)) return false;

        $item_translations = DB::table('main_translations')->where('main_id', '=', $this->id)->where('locale', '=', $locale);

        //если нет записи - создать - в данном случае у нас есть только имя в $data_translations
        if(!$item_translations->first()) {
            foreach($locales as $lang_code=>$lang_name) {
                $test_lng = DB::table('main_translations')->where('main_id', '=', $this->id)->where('locale', '=', $lang_code)->first();

                if(!$test_lng) {
                    $data_translations['main_id'] = $this->id;
                    $data_translations['locale'] = $lang_code;
                    DB::table('main_translations')->insert($data_translations);
                }
            }
        }
        else {
            $item_translations->update($data_translations);

            // update all languages where field param "copy" = true
            $data_translations_all = [];
            //$data_translations_all['main_id'] = $this->id;

            $fields = $this->getFieldsArray();
            foreach($fields as $field) {
                if (isset($field['param']['copy'])){
                    $data_translations_all[$field['type']] = $data_translations[$field['type']];
                }
            }

            if (count($data_translations_all)>0) {
                foreach($locales as $lang_code=>$lang_name) {
                    if ($lang_code != $locale) {
                        $item_translations_lang = DB::table('main_translations')->where('main_id', '=', $this->id)->where('locale', '=', $lang_code);
                        if (!$item_translations_lang->first()) {
                            $data_translations_all['main_id'] = $this->id;
                            $data_translations_all['locale'] = $lang_code;
                            DB::table('main_translations')->insert($data_translations_all);
                        } else {
                            $item_translations_lang->update($data_translations_all);
                        }
                    }
                }
            }
        }
    }

    //связан ли элемент с id
    public function isRelateWithId($id) {
        if($this->relate->where('id', $id)->first()) return true;
    }

    //добавлять к запросам БД
    //$item = Main::where('slug', '=', $slug)->query(['with'=>'images','result'=>'first']);
    public function scopeQuery($query, $params = null){
        $locale = \App::getLocale();

        if(!(isset($params['show_hidden']) && $params['show_hidden'] == true)) $query->where('hide', 0);

        //если ещё не было leftJoin main_translations то добавить его
        $hasJoinTranslations = false;
        if (!empty($query->getQuery()->joins)) {
            foreach($query->getQuery()->joins as $joinTmp) {
                if($joinTmp->table == 'main_translations') {
                    $hasJoinTranslations = true;
                }
            }
        }
        if ($hasJoinTranslations === false) {
            $query = $query->leftJoin('main_translations', function ($join) use ($locale) {
                $join->on('main.id', '=', 'main_translations.main_id')
                    ->where('locale', '=', $locale);
            });
            if(isset($params['seo']) && $params['seo'] == true) {
                $query = $query->leftJoin('type_translations', function ($join) use ($locale) {
                    $join->on('main.type_id', '=', 'type_translations.type_id')
                        ->where('type_translations.locale', '=', $locale);
                });

                $query = $query->select(['type_translations.title as type_title', 'type_translations.description as type_description', 'type_translations.keywords as type_keywords', 'main_translations.*', 'main.*']);
            }
            else {
                $query = $query->select(['main_translations.*', 'main.*']);
            }
        }

        if(isset($params['with']) && $params['with'] != '') $query = $query->with($params['with']);
        if(isset($params['paginate'])) $query = $query->paginate($params['paginate']);

        //сортировка
        if(isset($params['sort'])) {
            if(strpos($params['sort'], '-') === false) {
                $query = $query->orderBy($params['sort']);
            }
            else {
                $params['sort'] = str_replace('-','',$params['sort']);
                $query = $query->orderBy($params['sort'], 'desc');
            }
        }
        else {
            $query = $query->orderBy('sort');
        }

        if(isset($params['result']) && $params['result'] != '') {
            if($params['result'] == 'get') $return = $query->get();
            if($params['result'] == 'first') {
                $return = $query->first();
                if(!($return)) return abort(404);
            }
            if(strpos($params['result'], 'paginate') !== false) {
                $count = str_replace('paginate:','',$params['result']);
                $return = $query->paginate($count);
            }

            //SEO
            if(isset($params['seo']) && $params['seo'] == true) {
                $this->seo($return, $params['seo']);
            }

            return $return;
        }
        else {
            return $query;
        }
    }

    //SEO - устанавливает глобальную переменную $GLOBALS['meta'] и заполняет их данными
    public function seo($item) {
        $locale = \App::getLocale();
        $locales = config('app.locales');

        //проверка дейстительно ли $item это элемент, а не массив
        if(class_basename($item) != 'Main') {
            echo 'Ошибка. Параметр \'seo\'=>true применим только к элементу, а не массиву. Необходимо использовать параметр \'result\'=>\'first\'';
            exit;
        }

        //хук для мегаполя seo_meta_tags
        $GLOBALS['meta']['seo_meta_tags'] = $item['seo_meta_tags'];
        $GLOBALS['meta']['itemtype'] = $item->type['itemtype'];

        $title = $item['name'];
        $description = Settings::get('global_description_'.$locale);
        $keywords = Settings::get('global_keywords_'.$locale);
        $image = \Request::root().'/i/logo.png';
        $tags = [];

        $meta_arr = ['title', 'description', 'keywords'];
        foreach ($meta_arr as $meta) {
            if($item[$meta] != '') {
                $var_meta = $item[$meta];
            }
            else {
                $var_meta = $item['type_'.$meta];
                if($var_meta) {
                    $var_meta = str_replace('[name]',$item['name'], $var_meta);
                    $var_meta = str_replace('[string2]',$item['string2'], $var_meta);
                    $var_meta = str_replace('[global_title]',Settings::get('global_title_'.$locale), $var_meta);
                    $var_meta = str_replace('[global_description]',Settings::get('global_description_'.$locale), $var_meta);
                    $var_meta = str_replace('[global_keywords]',Settings::get('global_keywords_'.$locale), $var_meta);
                }
            }

            if($var_meta) $$meta = $var_meta;
        }

        //images
        //if(isset($item->images[0])) $image = $item->images[0]->previewCache(['w'=>640, 'h'=>480, 'scale'=>'max', 'type'=>'']);
        $image = $item->previewCache(['w'=>640, 'h'=>480, 'scale'=>'max', 'type'=>'']);

        //хук - tags в блоге
//        if($item->type['route'] == 'blog.post') {
//            foreach ($item->getRelateByType(10) as $item_tag) {
//                $tags[] = $item_tag->name;
//            }
//        }

        //Open Graph data - article:section
        $article_section = $item->type['name'];

        //определяем глобально
        $GLOBALS['meta']['title'] = $title;
        $GLOBALS['meta']['description'] = $description;
        $GLOBALS['meta']['keywords'] = $keywords;
        $GLOBALS['meta']['image'] = $image;
        $GLOBALS['meta']['tags'] = $tags;
        $GLOBALS['meta']['article_section'] = $article_section;
        $GLOBALS['meta']['published_time'] = $item['created_at'];
        $GLOBALS['meta']['modified_time'] = $item['updated_at'];
        $GLOBALS['meta']['fb_admins'] = Settings::get('global_fb_admins_'.$locale);
        $GLOBALS['meta']['og_site_name'] = Settings::get('global_og_site_name_'.$locale);
        $GLOBALS['meta']['twitter_creator'] = Settings::get('global_twitter_creator_'.$locale);
        $GLOBALS['meta']['twitter_site'] = Settings::get('global_twitter_site_'.$locale);

        if (count($locales)>1) {
            $GLOBALS['meta']['alternate'] = [];
            foreach($locales as $locale_code=>$locale_name) {
                $url = \Request::root() . Helpers::buildLangRoute($locale_code);
                if ($locale_code == 'en') { $hreflang = 'en-gb'; }
                    else { $hreflang = $locale_code . '-' . $locale_code; }

                $GLOBALS['meta']['alternate'][$locale_code] = ['url' => $url, 'hreflang' => $hreflang];
            }
        }
    }

    //получить все связанные элемента этого типа
    public function getRelateByType($type_id = null) {
        return $this->relate()->where('type_id', $type_id)->query(['with'=>[],'result'=>'get']);
    }

    //получить все связанные элемента этого родителя
    public function getRelateByParent($parent_id = null) {
        return $this->relate()->where('parent_id', $parent_id)->query(['with'=>[],'result'=>'get']);
    }

    //получить реальный URL объекта
    public function getUrl() {
        //все роуты в массив
        foreach (Route::getRoutes() as $value) {
            $name = $value->getName();
            //echo '<br>'.$value->getPath();
            $routes[$name] = $value;
        }

        if(isset($this->type->route)) {
            $item_route_name = $this->type->route;
            if(isset($routes[$item_route_name]->getAction()['url'])) {
                foreach($routes[$item_route_name]->getAction()['url'] as $url) {
                    if($url == 'slug') {
                        $make_url_arr[] = $this->slug;
                    }
                    elseif ($url == 'id') {
                        $make_url_arr[] = $this->id;
                    }
                    elseif (strpos($url, 'parenttype') !== false) {
                        $url_tmp = explode('=', $url);
                        $parent_type_id = $url_tmp[1];
                        $type = $url_tmp[2];

                        $node = $this->getNodeById($this->id);
                        $parent = $node->ancestors()->where('type_id', '=', $parent_type_id)->first();

                        if(!$parent) return dd('Ошибка в роутах - нет parent (\'url\' => [\'company\', \'parenttype=11=slug\')');
                        if($type == 'slug') $make_url_arr[] = $parent->slug;
                        if($type == 'id') $make_url_arr[] = $parent->id;
                    }
                    else {
                        $make_url_arr[] = $url;
                    }
                }
                $make_url = '/'.implode('/',$make_url_arr);

                return $make_url;
            }
        }

        return null;
    }

    //для построения меню + breadcrumb - можно ли добавлять детей
    public function getIsOnlyEdit() {
        if($this->type) {
            foreach($this->type->children()->get() as $type) {
                if($type['isAdd']) return false;
            }
        }

        return true;
    }

    //если найден sort = 0. Пересчитать и проставить автоикремент
    public static function rebuildSort() {
        $isNullisset = Main::where('sort', 0)->first();

        if($isNullisset) {
            $max_sort = DB::table('main')->max('sort');
            $items = Main::where('sort', 0)->get();

            $i = $max_sort+1;
            foreach ($items as $item) {
                $item->sort = $i;
                $item->save();

                $i++;
            }
        }
    }

    public function getDate($format = 'j F Y') {
        if($this->date) $date = Carbon::parse($this->date)->format($format);
        else $date = Carbon::parse($this->created_at)->format($format);
        return Helpers::getLocalizedDate($date);
    }

    //region RELATION
    public function type() {
        return $this->belongsTo('App\Models\Type');
    }

    public function user() {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function relate() {
        return $this->belongsToMany('App\Models\Main', 'main_main', 'main_id1', 'main_id2')
            ->query();
    }

    //children with translations
    public function children_with_trans() {
        /*
        $locale = App::getLocale();

        return $this->children()
            ->leftJoin('main_translations', function ($join) use ($locale) {
                $join->on( 'main.id', '=', 'main_translations.main_id')
                    ->where('locale', '=', $locale);
            })
            ->select(['main_translations.*', 'main.*']);
        */

        return $this->children()->query();
    }

    public function tags() {
        return $this->belongsToMany('App\Models\Tag');
    }
    //endregion
}
