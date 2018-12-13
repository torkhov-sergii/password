<?php

namespace App\Transformers;

use App\Models\Main;
use Helpers;

class CourseTransformer extends \League\Fractal\TransformerAbstract
{
    public function transform(Main $item)
    {
        return [
            'id' => $item->id,
            'name' => $item->name,
            'text' => Helpers::catString($item->text, 700, '...'),
            'text2' => $item->text2,
            'string2' => $item->string2,
            'for' => Helpers::courses_for_whom_options($item->select1),
            'url' => route('courses.view', $item->slug),
            'img' => $item->previewCache(['w'=>640, 'h'=>480, 'scale'=>'min', 'type'=>'', 'default'=>'no_image2']),
        ];
    }
}