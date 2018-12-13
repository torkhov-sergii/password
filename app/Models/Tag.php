<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\Services\SlugService;

class Tag extends Model
{
    use Sluggable;

    protected $fillable = ['id','name','slug'];
    public $timestamps = false;

    public function sluggable() {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

//    //прикрепляет теги к юзеру
//    public function attachToUser($tags = null, $type = null) {
//        $tags = explode(',',$tags);
//        $user = Auth::user();
//
//        if(count($user->tags($type)->lists('id')->all())) $user->tags($type)->detach($user->tags($type)->lists('id')->all());
//        //$user->tags($type)->detach($user->tags($type)->lists('id')->all());
//        //$user->tags($type)->delete();
//
//        foreach ($tags as $tag) {
//            $item_tag = $this->firstOrCreate(['name'=>$tag, 'type'=>$type]);
//            $user->tags($type)->attach($item_tag->id);
//        }
//    }

    //прикрепляет теги к элементу
    public function attachTag($item, $tags = null) {
        $item->tags()->detach();

        if($tags) {
            foreach ($tags as $tag) {
                if($tag) {
                    $item_tag = $this->firstOrCreate(['name'=>$tag]);
                    $item->tags()->attach($item_tag->id);
                }
            }
        }
    }

    public function post() {
        return $this->belongsToMany('App\Models\Main')->query();
    }
}
