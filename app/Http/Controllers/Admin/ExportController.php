<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\PHPExportable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Contracts\Database\Query\Builder;

class ExportController extends Controller
{

    /**
     * Summary of export
     * @param Request $request
     * @return string
     */
    public function export(Request $request)
    {
        $headers = explode(',', $request->rows);
        $headers[0] === 'on' ? array_shift($headers) : true;

        $queryResult = DB::table($request->db_table)
            ->when(
                $request->date_from && !$request->date_to,
                function (Builder $builder) use ($request) {
                    $builder->whereDate('created_at', $request->date_from);
                }
            )
            ->when(
                $request->date_to && !$request->date_from,
                function (Builder $builder) use ($request) {
                    $builder->whereDate('created_at', $request->date_to);
                }
            )
            ->when(
                $request->date_from && $request->date_to,
                function (Builder $builder) use ($request) {
                    $builder->whereBetween('created_at', [
                        $request->date_from,
                        $request->date_to
                    ]);
                }
            )
            ->select($headers)
            ->get()
            ->toArray();

        $fileName = (new PHPExportable())->exportFromData(
            $queryResult,
            'csv_data',
            $headers
        );

        return asset('csv/' . $fileName);
    }

    /**
     * Summary of download
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download()
    {
        $file = File::glob(storage_path('app/*.csv'))[0];
        return response()->download($file)->deleteFileAfterSend();
    }
}
