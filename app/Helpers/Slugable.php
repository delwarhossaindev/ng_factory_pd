<?php 

namespace App\Helpers;

trait Slugable
{   
    /**
     * Summary of setSlugAttribute
     * @param mixed $value
     * @return void
     */
    public function setSlugAttribute($value) {
        if (static::whereSlug($slug = str()->slug($value))->exists()) {
            $slug = $this->incrementSlug($slug);
        }
    
        $this->attributes['slug'] = $slug;
    }
    
    /**
     * Summary of incrementSlug
     * @param mixed $slug
     * @return mixed
     */
    public function incrementSlug($slug) {
        $original = $slug;
        $count = 2;
        while (static::whereSlug($slug)->exists()) {
            $slug = "{$original}-" . $count++;
        }

        return $slug;
    }
}