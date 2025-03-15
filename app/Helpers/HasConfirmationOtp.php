<?php

namespace App\Helpers;

use App\Models\Otp;

trait HasConfirmationOtp
{
    public function generateConfirmationOtp()
    {
        return $this->confirmationOtp()->create([
            'otp' => random_int(100000, 999999),
            'expire_at' => $this->getConfirmationOtpExpiry()
        ]);
    }

    public function confirmationOtp()
    {
        return $this->hasOne(Otp::class);
    }

    protected function getConfirmationOtpExpiry()
    {
        return $this->freshTimestamp()->addMinutes(1);
    }
}
