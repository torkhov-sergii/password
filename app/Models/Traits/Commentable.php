<?php namespace App\Models\Traits;

use App\Http\Requests\Request;
use App\Models\Comment;
use Carbon;

trait Commentable
{

    protected $user_comments_ids;

    public function __construct(array $attributes = array()) {
        $this->user_comments_ids = session()->get('user_comments_ids', []);

        parent::__construct($attributes);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function commentsApproved()
    {
        if ($this->mustBeApproved()) {
            //return $this->morphMany(Comment::class, 'commentable')->where('approved', true)->whereNull('parent_id');
            //return $this->morphMany(Comment::class, 'commentable')
            //->where('approved', true)
            //->whereNull('parent_id');
            //->orWhere('created_at', '>', Carbon::now()->subMinutes(60)->toDateTimeString());
            return $this->morphMany(Comment::class, 'commentable')->whereNull('parent_id')->where(function($query){
                $query->where('approved', true)->orWhereIn('id', $this->user_comments_ids);
            });
        }
        else {
            return $this->morphMany(Comment::class, 'commentable')->whereNull('parent_id');
        }
    }

    /**
     * @return bool
     */
    public function getCanBeRated()
    {
        return (isset($this->canBeRated)) ? $this->canBeRated : false;
    }

    /**
     * @return bool
     */
    public function mustBeApproved()
    {
        return (isset($this->mustBeApproved)) ? $this->mustBeApproved : false;
    }

    /**
     * @return mixed
     */
    public function totalCommentCount()
    {
        //return ($this->mustBeApproved()) ? $this->comments()->where('approved', true)->count() : $this->comments()->count();
        //return $this->comments()->where('approved', true)->orWhereIn('id', $this->user_comments_ids)->count();
        return $this->comments()->where(function ($query){
            $query->where('approved', true)->orWhereIn('id', $this->user_comments_ids);
        })->count();
    }

    /**
     * @return float
     */
    public function averageRate()
    {
        return ($this->getCanBeRated()) ? $this->comments()->where('approved', true)->avg('rate') : 0;
    }
}
