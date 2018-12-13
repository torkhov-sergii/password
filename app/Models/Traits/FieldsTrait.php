<?php namespace App\Models\Traits;


trait FieldsTrait
{

    //location
    public function fields() {
        return $this->morphMany('App\Models\Field', 'subject');
    }

    //location
    public function field() {
        return $this->morphOne('App\Models\Field', 'subject');
    }
}
