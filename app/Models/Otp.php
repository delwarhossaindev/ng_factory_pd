<?php

namespace App\Models;

use App\Helpers\Uuidable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
    use HasFactory, Uuidable;

    public $incrementing = false;

    protected $keyType = 'uuid';

    protected $fillable = [
        'user_id',
        'otp',
        'expire_at'
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($otp) {
            $otp?->user?->confirmationOtp?->delete();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function hasExpired()
    {
        return $this->freshTimestamp()->gt($this->expire_at);
    }
}
