<?php 

namespace App\Helpers;

use App\Models\Tag;

Trait Taggable 
{   
    /**
     * Summary of hasTags
     * @return bool
     */
    public function hasTags()
    {
        return (bool) $this->tags()->count();
    }
    
    /**
     * Summary of tags
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }
    
    /**
     * Summary of saveTags
     * @param mixed $request
     * @return array
     */
    public function saveTags($tags)
    {   
        return $this->tags()->sync($tags);
    }
}