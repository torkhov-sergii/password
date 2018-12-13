<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeTranslation extends Model {

    public $timestamps = false;
    protected $fillable = ['type_id','locale','title','description', 'keywords', 'itemtype'];

}
