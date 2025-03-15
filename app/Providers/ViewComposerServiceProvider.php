<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider
{

    public function register()
    {
        //
    }

    public function boot()
    {
        $this->composeUsersNotification();
    }

    private function composeUsersNotification()
    {
        View::composer(
            'components.notification.notification-component',
            function ($view) {
                $view->with('notifications', User::usersNotifications());
            }
        );
    }
}
