<?php namespace App\Models\Traits;


trait Mainable
{

    //mainable
    public function mainable() {
        return $this->morphToMany('App\Models\Main', 'mainable');
    }

}
