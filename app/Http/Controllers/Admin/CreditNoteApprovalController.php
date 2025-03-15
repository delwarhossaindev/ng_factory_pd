<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CreditNoteApproval;
use App\Models\User;
use Carbon\Carbon;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
class CreditNoteApprovalController
extends Controller
{
    /**
     * Summary of index
     * @param User $user
     * @param Request $request
     * @return mixed
     */
    public function index(CreditNoteApproval $creditNote, Request $request)
    {

        if ($request->ajax()) {
            return $this->table($creditNote->getCreditNoteApprovalQuery($request))
                ->addColumn('action', function ($row) {
                    return action_button([
                        'show' => [
                            'route' => route('credit_note_approval.show', $row->CodeNo),
                            'is_modal' => false,
                            'button_text' => 'Show',
                            'is_able_to_see' => 'HQ',
                        ],
                    ]);
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.credit_note_approval.index', [
            'cnp' => CreditNoteApproval::creditCountInformation(),
        ]);
    }

    /**
     * Summary of create
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('admin.credit_note_approval.create');
    }

    public function store(Request $request)
    {
        try {
            CreditNoteApproval::create([
                'CodeNo' => generate_unique_code('CreditNoteApproval'),
                'CreatedBy' => auth()->id(),
                'PresentDesk' => userSupervisor(),
                'ShowroomID' => userSupervisor(),
                'CustomerName' => $request->CustomerName,
                'CustomerCode' => $request->CustomerCode,
                'InvoiceNo' => $request->InvoiceNo,
                'DeliveryDate' => $request->DeliveryDate,
                'CaptureDate' => $request->CaptureDate,
                'RotavatorModel' => isset($request->RotavatorModel) ? $request->RotavatorModel : '',
                'Territory' => $request->Territory,
                'Area' => $request->Area,
                'Region' => $request->Region,
                'Remarks' => isset($request->Remarks) ? $request->Remarks : '',
                'created_at' => date('Y-m-d'),
                'InvoiceDate' => Carbon::parse($request->InvoiceDate)->toDateString(),
            ]);
            return back()->withMessage('Data saved successfully');
        } catch (\Throwable $th) {
            return back()->withError($th->getMessage());
        }
    }

    public function show(CreditNoteApproval $creditNoteApproval)
    {
        $data = [
            'model_data' => $creditNoteApproval,
            'related_invoice' => DB::connection('sqlsrv2')
                ->select("SELECT ID.ProductCode,P.ProductName,ID.UnitPrice,ID.SalesQTY,ID.NET
            FROM InvoiceDetails  ID
            inner join Product P ON ID.ProductCode = P.ProductCode
            WHERE ID.InvoiceNo = '$creditNoteApproval->InvoiceNo'"),
        ];

        return view('admin.credit_note_approval.show', compact('data'));
    }

    public function list_old(Request $request)
    {
        $data = [];

        if ($request->ajax()) {
            $data = DB::select("SELECT A.Territory,A.Region,A.CodeNo,A.CustomerCode,A.CustomerName,A.InvoiceNo,A.InvoiceDate,A.CaptureDate,
                            B.ProductCode,P.ProductName,B.SalesQTY,B.NET AS UnitPrice,(B.SalesQTY*B.NET) AS SalesValue,0 AS CreditNoteValue
                            FROM CreditNoteApproval A
                            INNER JOIN [192.168.100.25].MotorBrInvoiceMirror.dbo.InvoiceDetails B ON A.InvoiceNo = B.InvoiceNo
                            INNER JOIN [192.168.100.25].MotorBrInvoiceMirror.dbo.Product P ON P.ProductCode = B.ProductCode");
            return view('admin.credit_note_approval.list', [
                'data' => $data,
            ]);
        }
        return view('admin.credit_note_approval.list', ['data' => $data]);

    }

    public function list(Request $request)
    {
        $data = [];

        if ($request->ajax()) {

            $level2 = $request->Level2;
            $toDate = $request->ToDate;
            $fromDate = $request->FromDate;

            $data = DB::select(
                "SELECT A.ShowroomID,A.Territory,A.Region,A.CodeNo,A.CustomerCode,A.CustomerName,A.InvoiceNo,A.InvoiceDate,A.CaptureDate,
            B.ProductCode,P.ProductName,B.SalesQTY,B.NET AS UnitPrice,(B.SalesQTY*B.NET) AS SalesValue,0 AS CreditNoteValue
            FROM CreditNoteApproval A
            INNER JOIN [192.168.100.25].MotorBrInvoiceMirror.dbo.InvoiceDetails B ON A.InvoiceNo = B.InvoiceNo
            INNER JOIN [192.168.100.25].MotorBrInvoiceMirror.dbo.Product P ON P.ProductCode = B.ProductCode
            INNER JOIN  UserManager U ON U.UserID = A.ShowroomID
            WHERE A.created_at between '$fromDate' and '$toDate' AND A.ShowroomID='$level2' AND A.IsApproved='1'
            "
            );

            $signature = DB::select("select Distinct l2.SignaturePath as ConfirmedBy,
                        l1.SignaturePath as PreparedBy,
                        l3.SignaturePath as AgreedBy,
                        l4.SignaturePath as CheckedBy,
                        l5.SignaturePath as RecommendedBy,
                        l6.SignaturePath as ForwaredBy,
                        l7.SignaturePath as ApprovedBy
                        From UserManager l2
                        inner join UserManager l1 on l1.SupervisorID=l2.UserID
                        inner join UserManager l3 on l3.UserID=l2.SupervisorID
                        inner join UserManager l4 on l4.UserID=l3.SupervisorID
                        inner join UserManager l5 on l5.UserID=l4.SupervisorID
                        inner join UserManager l6 on l6.UserID=l5.SupervisorID
                        inner join UserManager l7 on l7.UserID=l6.SupervisorID
                        Where l2.UserID='$level2'"
            );

            return view('admin.credit_note_approval.report', compact('data', 'signature'))->render();
        }

        // For non-AJAX requests, return the view with empty data
        return view('admin.credit_note_approval.list', compact('data'));

    }

    public function my_submitted_list(CreditNoteApproval $creditNote, Request $request)
    {
        if ($request->ajax()) {
            $data = $creditNote->where('CreatedBy', auth()->user()->UserID)->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $exists = DB::table('CreditNoteApprove')
                        ->where('CreditCodeNo', $row->CodeNo)
                        ->exists();

                    $routeView = route('credit_note_approval.show', $row->CodeNo);
                    $routeEdit = route('credit_note_approval.my_submitted_edit', $row->CodeNo);

                    $btn = '<a href="' . $routeView . '" class="btn btn-primary btn-sm" title="View"><i class="tf-icons bx bxs-show"></i></a>';
                    if (!$exists) {
                        $btn .= ' <a href="' . $routeEdit . '" class="btn btn-warning btn-sm" title="Edit"><i class="tf-icons bx bxs-edit"></i></a>';
                    }

                    return $btn;
                })
                ->addColumn('status', function ($row) {
                    $btn = '';

                    if (($row->PresentDesk != $row->CreatedBy) && $row->IsDeclined == 0) {
                        $btn .= '<button class="btn btn-info btn-sm">In Progress</button>';
                    }

                    if (($row->PresentDesk == $row->CreatedBy) && $row->IsApproved == 1 && $row->IsDeclined == 0) {
                        $btn .= '<button class="btn btn-success btn-sm">Approved</button>';
                    }

                    if (($row->PresentDesk == $row->CreatedBy) && $row->IsApproved == 0 && $row->IsDeclined == 1) {
                        $btn .= '<button class="btn btn-danger btn-sm">Declined</button>';
                    }

                    return $btn;
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }

        return view('admin.credit_note_approval.my_submitted_list');
    }

    public function my_submitted_edit(CreditNoteApproval $creditNoteApproval)
    {

        $creditNote = $creditNoteApproval;

        $creditNoteDetails = DB::connection('sqlsrv2')
            ->select("SELECT ID.ProductCode,P.ProductName,I.InvoiceDate,ID.UnitPrice,ID.SalesQTY,ID.NET
      FROM InvoiceDetails ID
      inner join Product P ON ID.ProductCode = P.ProductCode
      inner join Invoice I ON I.InvoiceNo = ID.InvoiceNo
      WHERE ID.InvoiceNo = '$creditNote->InvoiceNo'");

        return view('admin.credit_note_approval.edit', compact('creditNote', 'creditNoteDetails'));
    }

    public function my_submitted_update(Request $request, $id)
    {
        try {
            $creditNote = CreditNoteApproval::findOrFail($id);
            $creditNote->update([
                'InvoiceNo' => $request->InvoiceNo,
                'CustomerCode' => $request->CustomerCode,
                'InvoiceDate' => $request->InvoiceDate,
                'CustomerName' => $request->CustomerName,
                'DeliveryDate' => $request->DeliveryDate,
                'Territory' => $request->Territory,
                'Area' => $request->Area,
                'Region' => $request->Region,
                'Remarks' => $request->Remarks,
                'CaptureDate' => $request->CaptureDate,
                'RotavatorModel' => $request->RotavatorModel,
            ]);

            return redirect()->route('credit_note_approval.my_submitted_list')->with('success', 'NG Factory PD updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update NG Factory PD. Please try again.');
        }
    }

    public function request_for_approval_list(CreditNoteApproval $creditNote, Request $request)
    {

        if ($request->ajax()) {
            $data = $creditNote->where('PresentDesk', auth()->user()->UserID)->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $routeView = route('credit_note_approval.show', $row->CodeNo);
                    $routeEdit = route('credit_note_approval.request_for_approval_edit', $row->CodeNo);

                    $btn = '<a href="' . $routeView . '" class="btn btn-primary btn-sm" title="View"><i class="tf-icons bx bxs-show"></i></a>';
                    $btn .= ' <a href="' . $routeEdit . '" class="btn btn-warning btn-sm" title="Edit"><i class="tf-icons bx bxs-edit"></i></a>';
                    return $btn;
                })
                ->addColumn('status', function ($row) {
                    $btn = '';
                    if (($row->PresentDesk != $row->CreatedBy) && $row->IsDeclined == 0) {
                        $btn .= '<button class="btn btn-info btn-sm">In Progress</button>';
                    }
                    if (($row->PresentDesk == $row->CreatedBy) && $row->IsApproved == 1 && $row->IsDeclined == 0) {
                        $btn .= '<button class="btn btn-success btn-sm">Approved</button>';
                    }
                    if (($row->PresentDesk == $row->CreatedBy) && $row->IsApproved == 0 && $row->IsDeclined == 1) {
                        $btn .= '<button class="btn btn-danger btn-sm">Declined</button>';
                    }

                    return $btn;
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }

        return view('admin.credit_note_approval.request_for_approval_list');

    }

    public function request_for_approval_edit(CreditNoteApproval $creditNoteApproval)
    {
        $creditNote = $creditNoteApproval;
        $creditNoteDetails = DB::connection('sqlsrv2')
            ->select("SELECT ID.ProductCode,P.ProductName,I.InvoiceDate,ID.UnitPrice,ID.SalesQTY,ID.NET
      FROM InvoiceDetails ID
      inner join Product P ON ID.ProductCode = P.ProductCode
      inner join Invoice I ON I.InvoiceNo = ID.InvoiceNo
      WHERE ID.InvoiceNo = '$creditNote->InvoiceNo'");


        $UserLevel = Auth::user()->Level;

        if($UserLevel =='Level3' || $UserLevel =='Level2' || $UserLevel =='Level14'){
            $status = DB::table('Status')->where('Active', 'Y')->get();
        }else{
            $status = DB::table('Status')->where('StatusName', 'Approve')->get();
        }

        //dd(Auth::user()->Level);

        return view('admin.credit_note_approval.request_for_approval_edit', compact('creditNote', 'creditNoteDetails', 'status','UserLevel'));
    }

    public function request_for_approval_update(Request $request, $id)
    {

        try {
            DB::beginTransaction(); // Start the transaction

            $creditNote = CreditNoteApproval::findOrFail($id);

            if ($request->Status == 1) {

                $StatusApprove = 0;
                $StatusDecline = 0;
                $PresentDesk = userSupervisor();
                if ($PresentDesk == '0000') {
                    $PresentDesk = $creditNote->CreatedBy;
                    $StatusApprove = 1;
                }

            } elseif ($request->Status == 2) {
                $StatusApprove = 0;
                $StatusDecline = 1;

            }
            $UserLevel = Auth::user()->Level;
            if($UserLevel =='Level2' || $UserLevel =='Level3' || $UserLevel =='Level14'){
                $creditNote->update([
                    'PresentDesk' => $PresentDesk,
                    'IsApproved' => $StatusApprove,
                    'IsDeclined' => $StatusDecline,
                ]);
            }else{
                $creditNote->update([
                    'PresentDesk' => $PresentDesk,
                    'IsApproved' => '1',
                    'IsDeclined' => $StatusDecline,
                ]);

            }
            /*
            $creditNote->update([
                'PresentDesk' => $PresentDesk,
                'IsApproved' => $StatusApprove,
                'IsDeclined' => $StatusDecline,
            ]);
            */

            DB::table('CreditNoteApprove')->insert([
                'ApprovedBy' => auth()->id(),
                'ApprovedDate' => now()->toDateString(),
                'Comment' => isset($request->Comment) ? $request->Comment : '',
                'ApprovedType' => 'Approved By',
                'CreditCodeNo' => $creditNote->CodeNo,
                'StatusID' => $request->Status,
            ]);

            DB::commit(); // Commit the transaction

            return redirect()->route('credit_note_approval.request_for_approval')
                ->with('success', 'NG Factory PD updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback the transaction on error
            return redirect()->back()->with('error', 'Failed to update Credit Note Approval. Please try again.');
        }
    }

    public function approved_submission_list(CreditNoteApproval $creditNote, Request $request)
    {

        $userID = auth()->user()->UserID;

        if ($request->ajax()) {

            $data = DB::select("EXEC sp_AllMyApprovedCreditNote '$userID'");

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $routeView = route('credit_note_approval.show', $row->CodeNo);
                    $routeEdit = route('credit_note_approval.request_for_approval_edit', $row->CodeNo);

                    $btn = '<a href="' . $routeView . '" class="btn btn-primary btn-sm" title="View"><i class="tf-icons bx bxs-show"></i></a>';
                    // $btn .= ' <a href="' . $routeEdit . '" class="btn btn-warning btn-sm" title="Edit"><i class="tf-icons bx bxs-edit"></i></a>';
                    return $btn;
                })
                ->addColumn('status', function ($row) {
                    $btn = '';
                    if (($row->PresentDesk != $row->CreatedBy) && $row->IsDeclined == 0) {
                        $btn .= '<button class="btn btn-info btn-sm">In Progress</button>';
                    }
                    if (($row->PresentDesk == $row->CreatedBy) && $row->IsApproved == 1 && $row->IsDeclined == 0) {
                        $btn .= '<button class="btn btn-success btn-sm">Approved</button>';
                    }
                    if (($row->PresentDesk == $row->CreatedBy) && $row->IsApproved == 0 && $row->IsDeclined == 1) {
                        $btn .= '<button class="btn btn-danger btn-sm">Declined</button>';
                    }

                    return $btn;
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }

        return view('admin.credit_note_approval.approved_submission_list');

    }

    public function submit_selected(Request $request)
    {
        $selectedIds = $request;

        // Process the selected IDs
        // You can perform any actions like updating status, deleting records, etc.

        dd($selectedIds);

        return response()->json(['success' => true, 'message' => 'Data processed successfully!']);
    }

}
