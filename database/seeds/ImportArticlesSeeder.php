<?php

use Illuminate\Database\Seeder;
use App\Models\Main;
use App\Models\Tag;
use Cviebrock\EloquentSluggable\Services\SlugService;

class ImportArticlesSeeder extends Seeder
{
    public function run(Main $mainController) {
        //->where('id', 703)
        $items = DB::table('els_resource_pages')->where('site_id', 3)->where('is_published', 1)->where('created_by', '!=', 1)->limit(2000)->get();

        //dd($items->count());

        foreach ($items as $item) {
            $cats = [];
            $tags = [];

            $categories = $items = DB::table('els_resource_ref_categories')->where('resource_id', $item->id)->get();
            $files = $items = DB::table('els_resource_files')->where('page_id', $item->id)->get();

            //cat
            $zamovniku = [771,767,763,777,775,776,764,781,783,782,863,760,759,762,773,868,867,784,780]; //zamovniku 28
            $uchasniku = [769,792,865,786,785,871,790,787]; //$uchasniku 30
            $gromad = [797,861,862,758]; //$gromad 31
            //$zakon = [688,752,691,742]; //$zakon
            //$zvit = [860]; //$zvit

            //users
            $new_users = [
                1=>3,
                3=>3,
                14=>3,
                456=>3,
                702=>3,
                4642=>4,
                5857=>4,
                6322=>4,
            ];

            foreach ($categories as $category) {
                if(in_array($category->category_id, $zamovniku)) {
                    $cats[28] = 28;
                }
                if(in_array($category->category_id, $uchasniku)) {
                    $cats[30] = 30;
                }
                if(in_array($category->category_id, $gromad)) {
                    $cats[31] = 31;
                }
            }

            $type = [
                'page'=>29,
                'video'=>35,
                'file'=>37,
                'presentation'=>34,
                //'url'=>75,
                //'scorm'=>74,
                //'longread'=>74,
                'html'=>29,
            ];

            $data = [
               'id_old'=>$item->id,
               'type_id'=>16,
               'user_id'=>$new_users[$item->created_by],
               'updated_at'=>$item->updated_at,
               'created_at'=>$item->created_at,
               'slug'=>SlugService::createSlug(Main::class, 'slug', $item->title)
            ];


            //создаем
            $main = Main::create($data);

            $data = [
                'name'=>$item->title,
                'text'=>$item->body,
                'string1'=>$item->description,
                'string2'=>$item->url,
                'bool1'=>$item->allow_download_original,
            ];

            $main->updateTranslations($data);

            //родитель
            $node_parent = Main::findOrFail(24);
            $main->makeChildOf($node_parent);

            //relate type
            $node1 = $main;
            $node2 = $mainController->getNodeById($type[$item->type]);
            $node1->relate()->attach($node2->id);
            $node2->relate()->attach($node1->id);

            //relate cat
            foreach ($cats as $cat) {
                $node1 = $main;
                $node2 = $mainController->getNodeById($cat);
                $node1->relate()->attach($node2->id);
                $node2->relate()->attach($node1->id);
            }

            //tags
            $tags_arr = explode(',',$item->tags);
            foreach ($tags_arr as $tag_slug) {
                $tags[] = trim(str_replace('#','',$tag_slug));
            }
            $tagModel = new Tag();
            $tagModel->attachTag($main, $tags);

            //files
            if($item->original_url) {
                $main->addFile($item->original_url);
            }

//            dd($cat);

//            $item->title; //name
//            $item->description; //text2
//            $item->body; //text
//            $item->type; //'page','file','url','html','scorm','gallery','presentation','markdown','video','googlefile','longread'
//            $item->allow_download_original; //bool
//            $item->tags; //теги - (учасники,замовники,філії)
//            $item->updated_at;
//            $item->created_at;
//            $item->created_by; //user id
        }

        //$root = Main::create(['slug' => 'root']);
    }
}
