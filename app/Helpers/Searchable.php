<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Builder;

trait Searchable
{
  /**
   * Summary of scopeSearch
   * @param Builder $query
   * @param mixed $columns
   * @return mixed
   */
  public function scopeSearch(Builder $query, $columns = [])
  {
    return $query->when(
      request()->get('q'),
      function (Builder $q) use ($columns) {
        $q->whereLike($columns, request()->get('q'));
      }
    );
  }
}
