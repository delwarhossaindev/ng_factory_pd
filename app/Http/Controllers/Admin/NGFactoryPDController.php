<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProposalMaster;
use App\Models\User;
use Auth;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            $query = ProposalMaster::with(['referenceStatuses', 'generalInfo.details', 'forecasts']);

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
                'PresentDesk' => $request->ForwardTo ?? auth()->id(),
                'EvaluatedBy' => $request->ForwardTo ?? null,
                'CreatedBy' => auth()->id(),
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

           if(isset($request->ServicesOneStrength)){

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
          


            if(isset($request->ServicesTwoStrength)){
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

          

            DB::commit();

            return back()->withMessage('Data saved successfully');
        } catch (\Throwable $th) {
            DB::rollback();
            dd($th->getMessage());
            return back()->withError('Error: ' . $th->getMessage());
        }
    }

    public function show($id)
    {
        $proposal = ProposalMaster::with(['referenceStatuses', 'generalInfo.details', 'forecasts'])->findOrFail($id);

        return view('admin.proposal.show', compact('proposal'));
    }

    public function requestForApprovalShow($id)
    {
        $proposal = ProposalMaster::with(['referenceStatuses', 'generalInfo.details', 'forecasts'])->findOrFail($id);

        return view('admin.proposal.request_approval_show', compact('proposal'));
    }

    public function requestForApprovalStore(Request $request)
    {


        DB::beginTransaction();

        try {

    

            $status = $request->Status;
            $proposalMaster = ProposalMaster::findOrFail($request->ProposalID);


            if ($status == 'Approved') {
                if ($proposalMaster->RecommendedBy == auth()->id()) {
                    $proposalMaster->update([
                       
                        'RecommendedStatus' => $status,
                        'StatusID' => 1,
                    ]);
                }

                if ($proposalMaster->EvaluatedBy == auth()->id()) {
                    $proposalMaster->update([
                        'PresentDesk' => $request->ForwardTo ?? auth()->id(),
                        'EvaluatedStatus' => $status,
                        'RecommendedBy' => $request->ForwardTo ?? null,
                    ]);
                }


            }
            
            if ($status == 'Declined') {

                if ($proposalMaster->EvaluatedBy == auth()->id()) {
                    $proposalMaster->update([
                        'PresentDesk' => $proposalMaster->CreatedBy ?? auth()->id(),
                        'RecommendedBy' => null,
                        'EvaluatedBy' => null,
                        'EvaluatedStatus' => $status,
                        'StatusID' => 2,

                    ]);
                }

                if ($proposalMaster->RecommendedBy == auth()->id()) {
                    $proposalMaster->update([
                        'PresentDesk' => $proposalMaster->CreatedBy ?? auth()->id(),
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
            $proposalMaster->update([
                'ProductCategory' => $request->ProductCategory,
                'EvaluatedBy' => $request->ForwardTo ?? null,
                'EditedBy' => auth()->id(),
                'EditedDate' => now()->toDateString(),
            ]);

            foreach ($request->ReferenceStatus as $key => $value) {
                $proposalMaster->referenceStatuses[$key]->update([
                    'ReferenceStatus' => $value,
                ]);
            }

            $proposalGeneralInfo = $proposalMaster->generalInfo;
            $proposalGeneralInfo->update([
                'GenericName' => $request->GenericName ?? '',
                'TherapeuticClass' => $request->TherapeuticClass ?? '',
                'Indication' => $request->Indication ?? '',
                'LocalCompetitors' => $request->LocalCompetitors ?? '',
                'OriginatorBrand' => $request->OriginatorBrand ?? '',
            ]);

            foreach ($request->ServicesOneStrength as $key => $value) {
                $proposalGeneralInfo->details()->updateOrCreate(
                    ['GeneralInfoDetailsID' => $proposalGeneralInfo->details[$key]->GeneralInfoDetailsID ?? null],
                    [
                        'ProposalID' => $id,
                        'StrengthDosageForm' => $value,
                        'PackSize' => $request->PackSize[$key],
                        'PrimaryPack' => $request->PrimaryPack[$key],
                        'MRPUnit' => $request->MRPUnit[$key],
                        'MRPPack' => $request->MRPPack[$key],
                        'TP' => $request->TP[$key],
                        'DCCNumber' => $request->DCCNumber[$key],
                        'Availability' => $request->Availability[$key],
                    ]
                );
            }

            foreach ($request->ServicesTwoStrength as $key => $value) {
                $proposalMaster->forecasts()->updateOrCreate(
                    ['ForecastID' => $proposalMaster->forecasts[$key]->ForecastID ?? null],
                    [
                        'ProposalID' => $id,
                        'StrengthDosageForm' => $value,
                        'Year1Unit' => $request->Year1Unit[$key],
                        'Year1Value' => $request->Year1Value[$key],
                        'Year2Unit' => $request->Year2Unit[$key],
                        'Year2Value' => $request->Year2Value[$key],
                        'Year3Unit' => $request->Year3Unit[$key],
                        'Year3Value' => $request->Year3Value[$key],
                        'LaunchingMonth' => $request->LaunchingMonth[$key],
                    ]
                );
            }

            DB::commit();

            return back()->withMessage('Data updated successfully');
        } catch (\Throwable $th) {
            DB::rollback();
            dd($th->getMessage());
            return back()->withError('Error: ' . $th->getMessage());
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
            ])->where('PresentDesk', auth()->id());
            // ->where(function ($q) {
            //     $q->where('PresentDesk', auth()->id())
            //       ->orWhere('EvaluatedBy', auth()->id())
            //       ->orWhere('RecommendedBy', auth()->id());
            // });

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

}
