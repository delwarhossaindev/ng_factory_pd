<?php

namespace App\Models;

use App\Helpers\Watcher;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Image extends Model implements Auditable
{
    use HasFactory, AuditableTrait, Watcher;

    protected $fillable = [
        'image',
        'path',
        'size',
        'type',
        'imageable_id',
        'imageable_type'
    ];
}
