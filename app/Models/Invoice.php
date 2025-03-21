<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $connection = 'sqlsrv2';
    protected $table      = 'Invoice';
    protected $primaryKey = 'InvoiceNo';
    protected $keyType    = 'string';
    public $timestamps    = false;
}
