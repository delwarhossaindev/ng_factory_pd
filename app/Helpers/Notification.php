<?php

namespace App\Helpers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class Notification
{
    /**
     * Summary of getNotification
     * @param mixed $model
     * @param mixed $event
     * @return bool
     */
    public function getNotification($table, $event)
    {
        if (
            auth()->user() &&
            isAdministrator()
        ) {
            return true;
        }

        if (!is_null(getAllAdministrator())) {
            foreach (getAllAdministrator() as $user) {
                DB::table('notifications')->insert([
                    'id'              => Str::uuid()->toString(),
                    'type'            => 'App\Notifications\NewTaskCreated',
                    'notifiable_type' => 'App\Models\User',
                    'notifiable_id'   => $user->id,
                    'data'            => auth()->user() ? json_encode($event . ' ' . $table . ' table data') : '',
                    'user_who_does'   => auth()->user() ? auth()->user()->name : '',
                    'event'           => $event,
                    'image_path'      => auth()->user() && auth()->user()->hasImage() ? auth()->user()->image->image : '',
                    'created_at'      => now()
                ]);
            }
        }

        return true;
    }
}
