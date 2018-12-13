<?php

namespace App\Transformers;

use App\Models\Main;
use Helpers;

class ArticleTransformer extends \League\Fractal\TransformerAbstract
{
    //protected $availableIncludes = ['category'];

    public function transform(Main $item)
    {

        $default_image = 'no_image_gray';

        $type_id = $item->getRelateByType(19)->first() ? $item->getRelateByType(19)->first()->id : null;

        if($type_id == 28) $default_image = 'no_image_blue';
        if($type_id == 30) $default_image = 'no_image_green';
        if($type_id == 31) $default_image = 'no_image_orange';
        if($type_id == 32) $default_image = 'no_image_gray';
        if($type_id == 33) $default_image = 'no_image_gray';

        if(count($item->getRelateByType(19)) > 1)  $default_image = 'no_image_gray';


        return [
            'id' => $item->id,
            'name' => $item->name,
            //'text' => $item->string1 ? $item->string1 : Helpers::catString($item->text, 700, '...'),
            'text' => $item->string1,
            'date' => $item->getDate('d.m.Y'),
            'url' => route('articles.view', $item->slug),
            'img' => $item->previewCache(['w'=>300, 'h'=>300, 'scale'=>'min', 'type'=>'', 'default'=>$default_image]),
            'type' => $item->getRelateByType(20)->first() ? 'type__'.$item->getRelateByType(20)->first()->slug : null,
            'category' => $item->getRelateByType(19)->first() ? $item->getRelateByType(19)->first()->name : null,
            'category_slug' => $item->getRelateByType(19)->first() ? $item->getRelateByType(19)->first()->slug : null,
        ];
    }

//    public function includeCategory(Club $club)
//    {
//        $categories = $club->categories;
//
//        if($categories) {
//            return $this->collection($categories, new CategoryTransformer());
//        }
//    }
}