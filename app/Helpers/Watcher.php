<?php 

namespace App\Helpers;

use App\Helpers\Notification;
use Illuminate\Database\Eloquent\Model;

trait Watcher
{   
    public static function bootWatcher()
    {   
        static::created(function (Model $model) {
            (new Notification())->getNotification($model->table, 'created');
        });

        static::updated(function (Model $model) {
            (new Notification())->getNotification($model->table, 'updated');
        });

        static::deleted(function (Model $model) {
            (new Notification())->getNotification($model->table, 'deleted');
        });
    }
}