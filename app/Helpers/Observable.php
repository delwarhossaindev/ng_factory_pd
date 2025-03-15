<?php

namespace App\Helpers;

trait Observable
{
    public function bootObservable()
    {
        $observer = '\\App\\Observers\\' . class_basename(static::class) . 'Observer';

        if (class_exists($observer)) {
            (new static())->registerObserver($observer);
        }
    }
}
