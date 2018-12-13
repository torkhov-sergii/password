<?php

use Illuminate\Database\Seeder;
use App\Models\Main;
use App\Models\Tag;
use Cviebrock\EloquentSluggable\Services\SlugService;

class ImportNewsSeeder extends Seeder
{
    public function run(Main $mainController) {
        //type_id 3 - 4
        $items = DB::table('els_news_posts')->where('site_id', 3)->where('type_id', 3)->where('is_published', 1)->where('created_by', '!=', 1)->limit(1000)->get();

        foreach ($items as $item) {
            $tags = [];

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

            //type_id 9 - 22
            $data = [
                'id_old'=>$item->id,
                'type_id'=>9,
                'user_id'=>$new_users[$item->created_by],
                'updated_at'=>$item->updated_at,
                'created_at'=>$item->created_at,
                'slug'=>SlugService::createSlug(Main::class, 'slug', $item->title)
            ];

            //создаем
            $main = Main::create($data);

            $data = [
                'name'=>$item->title,
                'text'=>$item->body_text,
            ];

            $main->updateTranslations($data);

            //родитель 15 - 46
            $node_parent = Main::findOrFail(15);
            $main->makeChildOf($node_parent);

            //tags
            $tags_arr = explode(',',$item->tags);
            foreach ($tags_arr as $tag_slug) {
                $tags[] = trim(str_replace('#','',$tag_slug));
            }
            $tagModel = new Tag();
            $tagModel->attachTag($main, $tags);

            //files
            if($item->image) {
                $main->addImage($item->image, true, 'first');
            }
        }
    }
}
