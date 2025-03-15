<?php

namespace App\Http\Controllers;

use App\Helpers\Alertable;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, Alertable;

    public function table($query)
    {
        return DataTables::of($query)
            ->addIndexColumn();
    }
}
