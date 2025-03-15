<?php

namespace App\Models;

use App\Helpers\Watcher;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Address extends Model implements Auditable
{
    use HasFactory, AuditableTrait, Watcher;

    protected $connection = 'sqlsrv';

    protected $fillable = [
        'address_title',
        'address_type',
        'address_line_1',
        'address_line_2',
        'city',
        'iso2',
        'state',
        'country',
        'zip_code',
        'phone',
        'addressable_id',
        'addressable_type'
    ];
}
