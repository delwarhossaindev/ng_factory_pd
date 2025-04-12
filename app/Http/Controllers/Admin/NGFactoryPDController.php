<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProposalMaster;
use App\Models\User;
use Auth;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotificationMail;

class NGFactoryPDController extends Controller
{
    /**
     * Summary of index
     * @param User $user
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = ProposalMaster::with(['referenceStatuses', 'generalInfo.details', 'forecasts'])
                ->Where('CreatedBy', auth()->user()->UserID)
                ->orderByDesc('ProposalID')
                ->get();

            return DataTables::of($query)
                ->addColumn('ProductCategory', function ($row) {
                    return $row->ProductCategory ?? '-';
                })
                ->addColumn('GenericName', function ($row) {

                    return $row->generalInfo->GenericName ?? '-';
                })
                ->addColumn('TherapeuticClass', function ($row) {
                    return $row->generalInfo->TherapeuticClass ?? '-';
                })
                ->addColumn('Indication', function ($row) {
                    return $row->generalInfo->Indication ?? '-';
                })
                ->addColumn('LocalCompetitors', function ($row) {
                    return $row->generalInfo->LocalCompetitors ?? '-';
                })
                ->addColumn('OriginatorBrand', function ($row) {
                    return $row->generalInfo->OriginatorBrand ?? '-';
                })
                ->addColumn('action', function ($row) {
                    $routeShow = route('ng_factory_pd.show', $row->ProposalID);
                    $routeEdit = route('ng_factory_pd.edit', $row->ProposalID);
                    $routeDelete = route('ng_factory_pd.destroy', $row->ProposalID);

                    $btn = '<a href="' . $routeShow . '" class="btn btn-primary btn-sm" title="View">
                               <i class="tf-icons bx bxs-show"></i>
                            </a>';

                    $btn .= ' <a href="' . $routeEdit . '" class="btn btn-warning btn-sm" title="Edit">
                                <i class="tf-icons bx bxs-edit"></i>
                              </a>';

                    //         $btn .= ' <button type="button" class="btn btn-danger btn-sm delete-btn"
                    //       data-id="' . $row->ProposalID . '" title="Delete">
                    //       <i class="tf-icons bx bxs-trash"></i>
                    //   </button>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.proposal.index');
    }

    /**
     * Summary of create
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('admin.proposal.create');
    }

    public function store(Request $request)
    {


        DB::beginTransaction();

        try {

            $proposalMaster = ProposalMaster::create([
                'ProductCategory' => $request->ProductCategory,
                'PresentDesk' => $request->ForwardTo ?? auth()->user()->UserID,
                'EvaluatedBy' => $request->ForwardTo ?? null,
                'CreatedBy' => auth()->user()->UserID,
                'CreatedDate' => now()->toDateString(),
            ]);


            foreach ($request->ReferenceStatus as $value) {
                $proposalMaster->referenceStatuses()->create([
                    'ReferenceStatus' => $value,
                ]);
            }


            $proposalGeneralInfo = $proposalMaster->generalInfo()->create([
                'GenericName' => $request->GenericName ?? '',
                'TherapeuticClass' => $request->TherapeuticClass ?? '',
                'Indication' => $request->Indication ?? '',
                'LocalCompetitors' => $request->LocalCompetitors ?? '',
                'OriginatorBrand' => $request->OriginatorBrand ?? '',
            ]);

            if (isset($request->ServicesOneStrength)) {

                foreach ($request->ServicesOneStrength as $key => $value) {
                    $proposalGeneralInfo->details()->create([
                        'ProposalID' => $proposalMaster->ProposalID,
                        'StrengthDosageForm' => $value,
                        'PackSize' => $request->PackSize[$key],
                        'PrimaryPack' => $request->PrimaryPack[$key],
                        'MRPUnit' => $request->MRPUnit[$key],
                        'MRPPack' => $request->MRPPack[$key],
                        'TP' => $request->TP[$key],
                        'DCCNumber' => $request->DCCNumber[$key],
                        'Availability' => $request->Availability[$key],
                    ]);
                }
            }



            if (isset($request->ServicesTwoStrength)) {
                foreach ($request->ServicesTwoStrength as $key => $value) {
                    $proposalMaster->forecasts()->create([
                        'StrengthDosageForm' => $value,
                        'Year1Unit' => $request->Year1Unit[$key],
                        'Year1Value' => $request->Year1Value[$key],
                        'Year2Unit' => $request->Year2Unit[$key],
                        'Year2Value' => $request->Year2Value[$key],
                        'Year3Unit' => $request->Year3Unit[$key],
                        'Year3Value' => $request->Year3Value[$key],
                        'LaunchingMonth' => $request->LaunchingMonth[$key],
                    ]);
                }
            }

            $mailData = [
                'title' => 'Proposal Approval Request',
                'body' => 'This is for testing email using smtp.',
                'link' => route('proposal.request_approval_show', $proposalMaster->ProposalID),
            ];

            User::where('UserID', $request->ForwardTo)->get()->each(function ($user) use ($mailData) {
                Mail::to($user->Email)->send(new NotificationMail($mailData));
            });


            DB::commit();

            return back()->withMessage('Data saved successfully');
        } catch (\Throwable $th) {
            DB::rollback();
            //dd($th->getMessage());
            return back()->withError('Error: ' . $th->getMessage());
        }
    }

    public function show($id)
    {
        $proposal = ProposalMaster::with(['referenceStatuses', 'generalInfo.details', 'forecasts'])->findOrFail($id);

        $ProposedBy = $proposal->CreatedBy ? User::where('UserID', $proposal->CreatedBy)->first() : NULL;
        $EvaluatedBy = $proposal->EvaluatedBy ? User::where('UserID', $proposal->EvaluatedBy)->first() : NULL;
        $RecommendedBy = $proposal->RecommendedBy ? User::where('UserID', $proposal->RecommendedBy)->first() : NULL;

        $EvaluatedProposalApprove = DB::table('ProposalApprove')
            ->where('ProposalID', $id)
            ->where('ApprovedBy', $proposal->EvaluatedBy)
            ->where('StatusID', 1)
            ->orderByDesc('ApprovedDate')
            ->first();

        $RecommendedProposalApprove = DB::table('ProposalApprove')
            ->where('ProposalID', $id)
            ->where('ApprovedBy', $proposal->RecommendedBy)
            ->where('StatusID', 1)
            ->orderByDesc('ApprovedDate')
            ->first();




        $ProposedBy->SignatureDate = $proposal->CreatedDate ? date('d-m-Y', strtotime($proposal->CreatedDate)) : NULL;

        $EvaluatedBy->SignatureDate = $EvaluatedProposalApprove ? date('d-m-Y', strtotime($EvaluatedProposalApprove->ApprovedDate)) : NULL;

        $RecommendedBy->SignatureDate = $RecommendedProposalApprove ? date('d-m-Y', strtotime($RecommendedProposalApprove->ApprovedDate)) : NULL;

        return view('admin.proposal.show', compact('proposal', 'ProposedBy', 'EvaluatedBy', 'RecommendedBy'));
    }

    public function requestForApprovalShow($id)
    {
        $proposal = ProposalMaster::with(['referenceStatuses', 'generalInfo.details', 'forecasts'])->findOrFail($id);

        return view('admin.proposal.request_approval_show', compact('proposal'));
    }

    public function requestForApprovalStoreOld(Request $request)
    {


        DB::beginTransaction();

        try {

            $status = $request->Status;
            $proposalMaster = ProposalMaster::findOrFail($request->ProposalID);


            if ($status == 'Approved') {
                if ($proposalMaster->RecommendedBy == auth()->user()->UserID) {
                    $proposalMaster->update([
                        'RecommendedStatus' => $status,
                        'StatusID' => 1,
                    ]);
                }

                if ($proposalMaster->EvaluatedBy == auth()->user()->UserID) {
                    $proposalMaster->update([
                        'PresentDesk' => $request->ForwardTo ?? auth()->user()->UserID,
                        'EvaluatedStatus' => $status,
                        'RecommendedBy' => $request->ForwardTo ?? null,
                    ]);
                }
            }

            if ($status == 'Declined') {

                if ($proposalMaster->EvaluatedBy == auth()->user()->UserID) {
                    $proposalMaster->update([
                        'PresentDesk' => $proposalMaster->CreatedBy ?? auth()->user()->UserID,
                        'RecommendedBy' => null,
                        'EvaluatedBy' => null,
                        'EvaluatedStatus' => $status,
                        'StatusID' => 2,
                    ]);
                }

                if ($proposalMaster->RecommendedBy == auth()->user()->UserID) {
                    $proposalMaster->update([
                        'PresentDesk' => $proposalMaster->CreatedBy ?? auth()->user()->UserID,
                        'RecommendedBy' => null,
                        'EvaluatedBy' => null,
                        'RecommendedStatus' => $status,
                        'StatusID' => 2,
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('proposal.request_approval_list')->with('message', 'Data updated successfully');
        } catch (\Throwable $th) {
            DB::rollback();
            dd($th->getMessage());
            return back()->withError('Error: ' . $th->getMessage());
        }
    }

    public function requestForApprovalStore(Request $request)
    {

        DB::beginTransaction();

        try {

            $currentUserID = auth()->user()->UserID;
            $UserLevel = auth()->user()->UserLevel;
            $status = $request->Status;
            $proposalMaster = ProposalMaster::findOrFail($request->ProposalID);

            if ($UserLevel == 'Level2') {
                $ApprovedType = 'EvaluatedBy';
                $supervisorID = $request->ForwardTo;
            }
            if ($UserLevel == 'Level3') {
                $ApprovedType = 'RecommendedBy';
                $supervisor = DB::table('Supervisor')
                    ->where('UserID', $currentUserID)
                    ->select('SupervisorID')
                    ->first();

                $supervisorID = $supervisor->SupervisorID ?? null;
            }
            if ($UserLevel == 'Level4') {
                $ApprovedType = 'TopManagement';
                $supervisor = DB::table('Supervisor')
                    ->where('UserID', $currentUserID)
                    ->select('SupervisorID')
                    ->first();

                $supervisorID = $currentUserID != '01645' ? $supervisor->SupervisorID : $proposalMaster->CreatedBy;
            }

            if ($status == '1') {

                DB::table('ProposalApprove')->insert(
                    [
                        'ProposalID' => $request->ProposalID,
                        'ApprovedBy' => $currentUserID,
                        'ApprovedDate' => now(),
                        'Comment' => $request->Comment ?? '',
                        'ApprovedType' => $ApprovedType,
                        'StatusID' => $status,
                    ]
                );

                if ($UserLevel == 'Level4') {

                    $proposalMaster->update([
                        'PresentDesk' => $supervisorID,
                    ]);
                }

                if ($UserLevel == 'Level2') {
                    $proposalMaster->update([
                        'PresentDesk' => $supervisorID,
                        'RecommendedBy' => $supervisorID,
                        'EvaluatedStatus' => $status,
                        'StatusID' => 1,
                    ]);
                }
                if ($UserLevel == 'Level3') {
                    $proposalMaster->update([
                        'PresentDesk' => $supervisorID,
                        'RecommendedStatus' => $status,
                        'StatusID' => 1,
                    ]);

                    $mailData = [
                        'title' => 'Proposal Approval Request',
                        'body' => 'This is for testing email using smtp.',
                        'link' => route('proposal.request_approval_show', $proposalMaster->ProposalID),
                    ];

                    $additionalMail = [
                        'raihana@aci-bd.com',
                        'jasmin@aci-bd.com'
                    ];

                    foreach ($additionalMail as $email) {
                        Mail::to($email)->send(new NotificationMail($mailData));
                    }
                }

                $mailData = [
                    'title' => 'Proposal Approval Request',
                    'body' => 'This is for testing email using smtp.',
                    'link' => route('proposal.request_approval_show', $proposalMaster->ProposalID),
                ];

                if ($currentUserID != '01645') {

                    User::where('UserID', $supervisorID)->get()->each(function ($user) use ($mailData) {
                        Mail::to($user->Email)->send(new NotificationMail($mailData));
                    });
                } else {
                    $additionalMail = [
                        'raihana@aci-bd.com',
                        'jasmin@aci-bd.com',
                        'joyanta@aci-bd.com',
                    ];

                    foreach ($additionalMail as $email) {
                        Mail::to($email)->send(new NotificationMail($mailData));
                    }
                }

            } else {
                if ($UserLevel == 'Level2') {
                    $proposalMaster->update([
                        'PresentDesk' => $proposalMaster->CreatedBy,
                        'EvaluatedStatus' => NULL,
                        'StatusID' => NULL,
                    ]);
                }
                if ($UserLevel == 'Level3') {
                    $proposalMaster->update([
                        'PresentDesk' => $proposalMaster->CreatedBy,
                        'EvaluatedStatus' => NULL,
                        'RecommendedStatus' => NULL,
                        'StatusID' => NULL,
                    ]);
                }
            }





            DB::commit();

            return redirect()->route('proposal.request_approval_list')->with('message', 'Data updated successfully');
        } catch (\Throwable $th) {
            DB::rollback();
            dd($th->getMessage());
            return back()->withError('Error: ' . $th->getMessage());
        }
    }

    public function edit($id)
    {
        $proposal = ProposalMaster::with(['referenceStatuses', 'generalInfo.details', 'forecasts'])->findOrFail($id);

        return view('admin.proposal.edit', compact('proposal'));
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {

            $proposalMaster = ProposalMaster::findOrFail($id);


            $proposalMaster->referenceStatuses()->delete();


            if ($proposalMaster->generalInfo) {
                $proposalMaster->generalInfo->details()->delete();
            }


            $proposalMaster->forecasts()->delete();


            $proposalMaster->update([
                'ProductCategory' => $request->ProductCategory,
                'EvaluatedBy' => $request->ForwardTo ?? null,
                'EditedBy' => auth()->user()->UserID,
                'EditedDate' => now()->toDateString(),
            ]);


            if (!empty($request->ReferenceStatus)) {
                foreach ($request->ReferenceStatus as $value) {
                    $proposalMaster->referenceStatuses()->create([
                        'ReferenceStatus' => $value,
                    ]);
                }
            }


            if ($proposalMaster->generalInfo) {
                $proposalMaster->generalInfo->update([
                    'GenericName' => $request->GenericName ?? '',
                    'TherapeuticClass' => $request->TherapeuticClass ?? '',
                    'Indication' => $request->Indication ?? '',
                    'LocalCompetitors' => $request->LocalCompetitors ?? '',
                    'OriginatorBrand' => $request->OriginatorBrand ?? '',
                ]);


                if (!empty($request->ServicesOneStrength)) {
                    foreach ($request->ServicesOneStrength as $key => $value) {
                        $proposalMaster->generalInfo->details()->create([
                            'ProposalID' => $id,
                            'StrengthDosageForm' => $value,
                            'PackSize' => $request->PackSize[$key] ?? null,
                            'PrimaryPack' => $request->PrimaryPack[$key] ?? null,
                            'MRPUnit' => $request->MRPUnit[$key] ?? null,
                            'MRPPack' => $request->MRPPack[$key] ?? null,
                            'TP' => $request->TP[$key] ?? null,
                            'DCCNumber' => $request->DCCNumber[$key] ?? null,
                            'Availability' => $request->Availability[$key] ?? null,
                        ]);
                    }
                }
            }


            if (!empty($request->ServicesTwoStrength)) {
                foreach ($request->ServicesTwoStrength as $key => $value) {
                    $proposalMaster->forecasts()->create([
                        'ProposalID' => $id,
                        'StrengthDosageForm' => $value,
                        'Year1Unit' => $request->Year1Unit[$key] ?? null,
                        'Year1Value' => $request->Year1Value[$key] ?? null,
                        'Year2Unit' => $request->Year2Unit[$key] ?? null,
                        'Year2Value' => $request->Year2Value[$key] ?? null,
                        'Year3Unit' => $request->Year3Unit[$key] ?? null,
                        'Year3Value' => $request->Year3Value[$key] ?? null,
                        'LaunchingMonth' => $request->LaunchingMonth[$key] ?? null,
                    ]);
                }
            }

            DB::commit();

            return back()->with('message', 'Data updated successfully');
        } catch (\Throwable $th) {
            DB::rollback();

            // Log error instead of using dd()
            Log::error('Update failed: ' . $th->getMessage());

            return back()->with('error', 'Error: ' . $th->getMessage());
        }
    }


    public function destroy($id)
    {

        DB::beginTransaction();

        try {
            $proposalMaster = ProposalMaster::findOrFail($id);

            $proposalMaster->referenceStatuses()->delete();

            $proposalGeneralInfo = $proposalMaster->generalInfo;
            $proposalGeneralInfo->details()->delete();
            $proposalGeneralInfo->delete();

            $proposalMaster->forecasts()->delete();

            $proposalMaster->delete();

            DB::commit();

            return response()->json(['success' => 'Record deleted successfully!']);
        } catch (\Throwable $th) {
            DB::rollback();
            return back();
        }
    }

    public function requestForApproval(Request $request)
    {
        if ($request->ajax()) {

            $query = ProposalMaster::with([
                'referenceStatuses',
                'generalInfo.details',
                'forecasts'
            ])
                ->where('PresentDesk', auth()->user()->UserID)
                ->where('CreatedBy', '!=', auth()->user()->UserID) // Ensure correct casing in method name
                ->get();

            return DataTables::of($query)
                ->addColumn('ProductCategory', function ($row) {
                    return $row->ProductCategory ?? '-';
                })
                ->addColumn('GenericName', function ($row) {

                    return $row->generalInfo->GenericName ?? '-';
                })
                ->addColumn('TherapeuticClass', function ($row) {
                    return $row->generalInfo->TherapeuticClass ?? '-';
                })
                ->addColumn('Indication', function ($row) {
                    return $row->generalInfo->Indication ?? '-';
                })
                ->addColumn('LocalCompetitors', function ($row) {
                    return $row->generalInfo->LocalCompetitors ?? '-';
                })
                ->addColumn('OriginatorBrand', function ($row) {
                    return $row->generalInfo->OriginatorBrand ?? '-';
                })
                ->addColumn('action', function ($row) {
                    $routeShow = route('proposal.request_approval_show', $row->ProposalID);

                    $btn = '<a href="' . $routeShow . '" class="btn btn-primary btn-sm" title="View">
                               <i class="tf-icons bx bxs-show"></i>
                            </a>';


                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.proposal.request_for_approval');
    }

    public function approved_submission_list(Request $request)
    {
        if ($request->ajax()) {
            $query = ProposalMaster::where('PresentDesk', auth()->user()->UserID)
                ->Where('CreatedBy', auth()->user()->UserID)
                ->orderByDesc('ProposalID') // Ordering should come after filtering
                ->get();
            return DataTables::of($query)
                ->addColumn('ProductCategory', function ($row) {
                    return $row->ProductCategory ?? '-';
                })
                ->addColumn('GenericName', function ($row) {

                    return $row->generalInfo->GenericName ?? '-';
                })
                ->addColumn('TherapeuticClass', function ($row) {
                    return $row->generalInfo->TherapeuticClass ?? '-';
                })
                ->addColumn('Indication', function ($row) {
                    return $row->generalInfo->Indication ?? '-';
                })
                ->addColumn('LocalCompetitors', function ($row) {
                    return $row->generalInfo->LocalCompetitors ?? '-';
                })
                ->addColumn('OriginatorBrand', function ($row) {
                    return $row->generalInfo->OriginatorBrand ?? '-';
                })
                ->addColumn('action', function ($row) {
                    $routeShow = route('ng_factory_pd.show', $row->ProposalID);
                    $routeEdit = route('ng_factory_pd.edit', $row->ProposalID);
                    $routeDelete = route('ng_factory_pd.destroy', $row->ProposalID);

                    $btn = '<a href="' . $routeShow . '" class="btn btn-primary btn-sm" title="View">
                               <i class="tf-icons bx bxs-show"></i>
                            </a>';

                    // $btn .= ' <a href="' . $routeEdit . '" class="btn btn-warning btn-sm" title="Edit">
                    //             <i class="tf-icons bx bxs-edit"></i>
                    //           </a>';

                    //         $btn .= ' <button type="button" class="btn btn-danger btn-sm delete-btn"
                    //       data-id="' . $row->ProposalID . '" title="Delete">
                    //       <i class="tf-icons bx bxs-trash"></i>
                    //   </button>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.proposal.request_for_approval_list');
    }
}
