<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Field extends Model {

    protected $table = 'fields';
    protected $fillable = ['subject_id', 'subject_type', 'value', 'value2', 'type', 'param', 'isPublic'];
    public $timestamps = false;

    //region RELATION
    //cоздавший
    public function subject() {
        return $this->morphTo();
    }
    //endregion
}
