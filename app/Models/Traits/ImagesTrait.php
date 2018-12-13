<?php namespace App\Models\Traits;

use App\Models\Image;

trait ImagesTrait {

    //добавить фотки или аватарку
    public function addImage($images, $isPreview = null, $image_type = null) {
        $newimage_arr = [];
        if(!is_array($images)) $images = [$images];

        foreach($images as $image) {
            $imageModel = new Image([], $this);
            $newimage = $imageModel->addImage($image, $isPreview, $image_type);

            $newimage_arr[] = $newimage;
        }

        if($isPreview) return $newimage;
        return $newimage_arr;
    }

    //удалить все фотки, или аватарку
    public function destroyAllImage($isPreview = null, $image_type = '') {
        $imageModel = new Image([], $this);
        $imageModel->destroyAll($isPreview, $image_type);
    }

    //получить url на превью или на нет_превью
    public function previewCache($params) {
        $default = isset($params['default']) ? $params['default'] : 'default';
        $type = isset($params['type']) ? $params['type'] : false;

        if($type) {
            $image = $this->preview($type)->first();
            if($image) return $image->getCache($params);
        }
        else {
            $image = $this->preview;
            if($image) return $image->getCache($params);
        }

        return url('/images/icons/'.$default.'.png');
    }

    //получить url на первое фото или на нет_фото
    public function imageCache($params) {
        $default = isset($params['default']) ? $params['default'] : 'default';
        $type = isset($params['type']) ? $params['type'] : false;

        if($type) {
            $image = $this->images($type)->first();
            if($image) return $image->getCache($params);
        }
        else {
            $image = $this->images;
            if($image->first()) return $image->first()->getCache($params);
        }

        return url('/images/icons/'.$default.'.png');
    }

    //region RELATION
    public function images($image_type = null) {
        if($image_type) $images = $this->morphMany('App\Models\Image', 'subject')->where('isPreview', 0)->where('image_type', $image_type);
        else $images = $this->morphMany('App\Models\Image', 'subject')->where('isPreview', 0)->whereNull('image_type');

        return $images;
    }

    public function preview($image_type = null) {
        if($image_type) return $this->morphOne('App\Models\Image', 'subject')->where('isPreview', 1)->where('image_type', $image_type);
        return $this->morphOne('App\Models\Image', 'subject')->where('isPreview', 1)->whereNull('image_type');
    }
    //endregion
}
