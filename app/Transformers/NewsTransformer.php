<?php

namespace App\Transformers;

use App\Models\Main;
use Helpers;

class NewsTransformer extends \League\Fractal\TransformerAbstract
{
    public function transform(Main $item)
    {
        return [
            'id' => $item->id,
            'name' => $item->name,
            //'text' => Helpers::catString($item->text, 700, '...'),
            'text' => $item->string1,
            //'text' => $item->text,
            'date' => $item->getDate('d.m.Y'),
            'url' => $item->type_id == 9 ? route('news.view', $item->slug) : route('news-mert.view', $item->slug),
            'img' => $item->previewCache(['w'=>640, 'h'=>480, 'scale'=>'min', 'type'=>'', 'default'=>'no_image2']),
        ];
    }
}