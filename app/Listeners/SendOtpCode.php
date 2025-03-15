<?php

namespace App\Listeners;

use App\Mail\SendOtpMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendOtpCode
{
    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        Mail::to($event->user)
            ->send(new SendOtpMail(
                $event->user->generateConfirmationOtp()
            ));
    }
}
