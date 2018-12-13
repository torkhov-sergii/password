<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $table = 'locations';
    protected $fillable = ['locations_id','locations_type','country_slug','city_slug','name','location','city','country','postal_code','lat','lng','manually'];
    public $timestamps = false;

    //user
    public function owner() {
        return $this->morphTo();
    }
}
