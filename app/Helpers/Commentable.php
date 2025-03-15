<?php 

namespace App\Helpers;

use App\Models\Comment;

trait Commentable 
{   
    /**
     * Summary of hasComment
     * @return bool
     */
    public function hasComment()
    {
        return (bool) $this->comments()->count();
    }
    
    /**
     * Summary of hasReply
     * @return mixed
     */
    public function hasReply()
    {
        return $this->replies->count();
    }
    
    /**
     * Summary of comments
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable')->whereNull('parent_id');
    }
    
    /**
     * Summary of replies
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

}