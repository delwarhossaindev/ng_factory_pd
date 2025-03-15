<?php

namespace App\Http\Controllers\Ajax;

use App\Models\Invoice;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AjaxController extends Controller
{
    /**
     * Summary of deleteRows
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteRows(Request $request)
    {
        $modelPath = <<<TEXT
        App\Models\
        TEXT;
        $model = $modelPath . $request->table;
        $permission =  str_replace('_', '-', Str::snake($request->table));
        $permission = 'delete-' . strtolower($permission);

        if (can_do($permission)) {
            if (strlen($request->rows[0]) === 36) {
                $model::whereIn('uuid', $request->rows)
                    ->delete();
            }
            $model::whereIn('id', $request->rows)
                ->delete();

            return response()->json([
                'msg' => 'Rows deleted successfully!'
            ], 200);
        }

        return response()->json([
            'msg' => '419'
        ], 200);
    }

    /**
     * Summary of invoiceSearch
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function invoiceSearch(Request $request)
    {
        return DB::connection('sqlsrv2')
            ->select("SELECT I.InvoiceNo, I.InvoiceDate,I.CustomerCode,C.CustomerName1,I.DeliveryDate,L1.Level1Name AS 'Territory',L2.Level2Name AS 'Zone',L3.Level3Name AS 'Area'
        FROM Invoice  I
        inner join Customer C ON I.CustomerCode = C.CustomerCode
        inner join Level1 L1 ON I.Level1 = L1.Level1
        inner join Level2 L2 ON I.Level2 = L2.Level2
        inner join Level3 L3 ON I.Level3 = L3.Level3
        WHERE I.InvoiceNo Like '%" . $request->get('query') . "%' 
        or I.CustomerCode Like '%" . $request->get('query') . "%'");
    }

    public function searchInvoiceDetails(Request $request)
    {
        return DB::connection('sqlsrv2')
            ->select("SELECT ID.ProductCode,P.ProductName,I.InvoiceDate,ID.UnitPrice,ID.SalesQTY,ID.NET
            FROM InvoiceDetails ID
            inner join Product P ON ID.ProductCode = P.ProductCode 
            inner join Invoice I ON I.InvoiceNo = ID.InvoiceNo 
            WHERE ID.InvoiceNo = '$request->invoiceNo'");
    }
}
