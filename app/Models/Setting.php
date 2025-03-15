<?php

namespace App\Models;

use App\Helpers\Watcher;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Collection;
use OwenIt\Auditing\Auditable as AuditableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Setting extends Model implements Auditable
{
    use HasFactory, AuditableTrait, Watcher;
    
    protected $fillable = [
        'display_name',
        'key',
        'value'
    ];

    /**
     * Summary of settings
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function settings() : Collection
    {
        return $this::all();
    }
}
