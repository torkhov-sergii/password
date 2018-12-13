<?php namespace App\Models;

use App\Http\Requests\Request;
use Baum\Node;
use Illuminate\Database\Eloquent\Model;
use Carbon;

class Comment extends Node
{

    protected $parentColumn = 'parent_id';
    protected $leftColumn = 'lft';
    protected $rightColumn = 'rgt';
    protected $depthColumn = 'depth';
    protected $fillable = [
        'body',
        'rate',
        'approved',
        'commented_id',
        'commented_type',
        'name',
        'email',
        'website',
    ];

    public $appends = [
        'date_readable',
    ];

    protected $casts = [
        'approved' => 'boolean'
    ];

    protected $user_comments_ids;

    public function __construct(array $attributes = array()) {
        $this->user_comments_ids = session()->get('user_comments_ids', []);

        parent::__construct($attributes);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function commentable()
    {
        return $this->morphTo()->query(['with'=>'']);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function commented()
    {
        return $this->morphTo();
    }

    /**
     * @return $this
     */
    public function approve()
    {
        $this->approved = true;
        $this->save();

        return $this;
    }

    public function user() {
        return $this->commented();
    }

    public function getDateReadableAttribute() {
        return Carbon::parse($this->created_at)->diffForHumans();
    }

    public static function totalCommentCount()
    {
        return  Comment::all()->count();
    }

    public static function notApprovedCommentCount()
    {
        return  Comment::all()->where('approved', false)->count();
    }

    public function children() {
        //return parent::children()->where('approved', true);
        $items = parent::children()->where(function($query){
            $query->where('approved', true)->orWhereIn('id', $this->user_comments_ids);
        });

        return $items;
    }
}
