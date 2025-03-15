<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Builder;

trait Scopeable
{   
    /**
     * Summary of scopePublished
     * @param Builder $query
     * @return mixed
     */
    public function scopePublished(Builder $query)
    {
        return $query->whereStatus(true)
                    ->where('deleted_at',NULL);
    }
    
    /**
     * Summary of scopeWithoutTrashed
     * @param Builder $query
     * @return mixed
     */
    public function scopeWithoutTrashed(Builder $query)
    {
        return $query->where('deleted_at',NULL);
    }

    /**
     * Summary of scopeDraft
     * @param Builder $query
     * @return mixed
     */
    public function scopeDraft(Builder $query)
    {
        return $query->whereStatus(false)
                    ->where('deleted_at',NULL);
    }
    
    /**
     * Summary of scopeTrash
     * @param Builder $query
     * @return mixed
     */
    public function scopeTrash(Builder $query)
    {
        return $query->onlyTrashed();
    }

    /**
     * Summary of scopeActive
     * @param Builder $query
     * @return mixed
     */
    public function scopeActive(Builder $query)
    {
        return $query->whereStatus(true)
                    ->where('deleted_at',NULL);
    }
    
    /**
     * Summary of scopeInactive
     * @param Builder $query
     * @return mixed
     */
    public function scopeInactive(Builder $query)
    {
        return $query->whereStatus(false)
                    ->where('deleted_at',NULL);
    }
}