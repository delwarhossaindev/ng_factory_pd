<x-app-component>
    <x-page.page-title data="Credit Note Information" />

    <x-slot name="style">
        <link rel="stylesheet" href="{{ asset('css/print.css') }}">
        <style>
            @media print {
                @page {
                    size: A4;
                    margin: 10mm;
                }

                body {
                    font-size: 7pt;
                    /* Standard readable font size */
                    font-family: Arial, sans-serif;
                    /* Clean, professional font */
                }

                table {
                    width: 100%;
                    font-size: 7pt;
                    /* Consistent table text size */
                    padding: 1px;
                }

                .table>:not(caption)>*>* {
                    padding: 2px;
                }

                th,
                td {
                    font-size: 7pt;
                    padding: 5px;

                }

                h5 {
                    font-size: 10pt;
                    /* Slightly larger for headings */
                    font-weight: bold;
                }

                .table th {
                    text-transform: uppercase;
                    font-size: 7pt;
                    letter-spacing: 1px;
                }

                /* Hide elements that should not be printed */
                #printButton {
                    display: none;
                }
            }
        </style>
    </x-slot>

    <x-slot name="content">
        @php
            $saveStatus = collect($proposal->referenceStatuses ?? [])
                ->pluck('ReferenceStatus')
                ->toArray();
            $TopManagement = DB::table('ProposalApprove')->where('ProposalID', $proposal->ProposalID)->get();

            $TopManagement1 = $TopManagement->where('ApprovedBy', '02032')->first() ?? null;
            $TopManagement2 = $TopManagement->where('ApprovedBy', '11412')->first() ?? null;
            $TopManagement3 = $TopManagement->where('ApprovedBy', '49540')->first() ?? null;
            $TopManagement4 = $TopManagement->where('ApprovedBy', '34387')->first() ?? null;
            $TopManagement5 = $TopManagement->where('ApprovedBy', '00925')->first() ?? null;
            $TopManagement6 = $TopManagement->where('ApprovedBy', '01645')->first() ?? null;

        @endphp
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <button id="printButton" class="btn btn-info btn-outline-info btn-md">Print</button>
                    </div>
                </div>

                <div id="contentToPrint">
                    <h5 class="mt-4 d-flex align-items-center">
                        <img src="{{ asset('aci-logo.png') }}" alt="ACI Logo" class="me-2" style="height: 40px;">
                        <strong>Advanced Chemical Industries Limited</strong>
                    </h5>

                    <div>
                        <p class="mb-2"><b>New Product Category : </b>{{ $proposal->ProductCategory }} </p>
                        <p class="mb-0"><b>Reference Status : </b> {{ implode(', ', $saveStatus) }}</p>
                    </div>

                    <br>
                    <h5>A. GENERAL INFORMATION</h5>
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-sm table-borderless">
                                <tbody>
                                    <tr>
                                        <td> <b>Generic Name :</b> {{ $proposal->generalInfo->GenericName ?? 'N/A' }}
                                        </td>
                                        <td class="text-right"> <b>Therapeutic Class :</b>
                                            {{ $proposal->generalInfo->TherapeuticClass ?? 'N/A' }} </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"> <b>Indication :</b>
                                            {{ $proposal->generalInfo->Indication ?? 'N/A' }} </td>
                                    </tr>
                                    <tr>
                                        <td> <b>Therapeutic Class :</b>
                                            {{ $proposal->generalInfo->LocalCompetitors ?? 'N/A' }}</td>
                                        <td class="text-right"> <b>Originator’s Brand:</b>
                                            {{ $proposal->generalInfo->OriginatorBrand ?? 'N/A' }} </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-sm-12  table-responsive">
                            <table class="table table-sm table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-center">Strength & Dosage Form</th>
                                        <th class="text-center">Pack <br> Size</th>
                                        <th class="text-center">Primary Pack</th>
                                        <th class="text-center">IP or MRP <br>/Unit (Tk.)</th>
                                        <th class="text-center">IP or MRP <br>/Pack (Tk.)</th>
                                        <th class="text-center">TP/Pack<br>(Tk.)</th>
                                        <th class="text-center">DCC <br> Number</th>
                                        <th class="text-center">Availability in <br> BD</th>
                                    </tr>
                                </thead>
                                <tbody id="services">
                                    @foreach ($proposal->generalInfo->details as $service)
                                        <tr>
                                            <td>{{ $service->StrengthDosageForm }}</td>
                                            <td class="text-center">{{ $service->PackSize }}</td>
                                            <td class="text-center">{{ $service->PrimaryPack }}</td>
                                            <td class="text-center">{{ $service->MRPUnit }}</td>
                                            <td class="text-center">{{ $service->MRPPack }}</td>
                                            <td class="text-center">{{ $service->TP }}</td>
                                            <td class="text-center">{{ $service->DCCNumber }}</td>
                                            <td class="text-center">{{ $service->Availability }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    @php
                        $Year1Unit = 0;
                        $Year1Value = 0;
                        $Year2Unit = 0;
                        $Year2Value = 0;
                        $Year3Unit = 0;
                        $Year3Value = 0;
                    @endphp

                    <div class="row">
                        <h5 class="col-sm-12 mt-3">B. FORECAST</h5>
                        <div class="col-sm-12 table-responsive">
                            <table class="table table-sm table-bordered">
                                <thead>
                                    <tr>
                                        <th rowspan="2" class="text-center">Strength & Dosage Form</th>
                                        <th colspan="2" class="text-center">Year-1</th>
                                        <th colspan="2" class="text-center">Year-2</th>
                                        <th colspan="2" class="text-center">Year-3</th>
                                        <th rowspan="2" class="text-center">Launching <br> Month</th>
                                    </tr>
                                    <tr>
                                        <th class="text-center">Unit</th>
                                        <th class="text-center">Value (M)</th>
                                        <th class="text-center">Unit</th>
                                        <th class="text-center">Value (M)</th>
                                        <th class="text-center">Unit</th>
                                        <th class="text-center">Value (M)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($proposal->forecasts as $forecast)
                                        <tr>
                                            <td>{{ $forecast->StrengthDosageForm }}</td>
                                            <td class="text-center">{{ $forecast->Year1Unit }}</td>
                                            <td class="text-center">{{ $forecast->Year1Value }}</td>
                                            <td class="text-center">{{ $forecast->Year2Unit }}</td>
                                            <td class="text-center">{{ $forecast->Year2Value }}</td>
                                            <td class="text-center">{{ $forecast->Year3Unit }}</td>
                                            <td class="text-center">{{ $forecast->Year3Value }}</td>
                                            <td class="text-center">
                                                {{ date('M, Y', strtotime($forecast->LaunchingMonth)) }}</td>
                                        </tr>
                                        @php
                                            $Year1Unit += $forecast->Year1Unit;
                                            $Year1Value += $forecast->Year1Value;
                                            $Year2Unit += $forecast->Year2Unit;
                                            $Year2Value += $forecast->Year2Value;
                                            $Year3Unit += $forecast->Year3Unit;
                                            $Year3Unit += $forecast->Year3Unit;
                                        @endphp
                                    @endforeach

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td class="text-center"> <b>Total</b> </td>
                                        <td class="text-center">{{ $Year1Unit }}</td>
                                        <td class="text-center">{{ $Year1Value }}</td>
                                        <td class="text-center">{{ $Year2Unit }}</td>
                                        <td class="text-center">{{ $Year2Value }}</td>
                                        <td class="text-center">{{ $Year3Unit }}</td>
                                        <td class="text-center">{{ $Year3Value }}</td>
                                        <td class="text-center"></td>
                                    </tr>

                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-sm-12">
                            <table class="table table-sm table-borderless text-center">
                                <tbody>
                                    <tr>
                                        @foreach ([
        'Proposed by' => ['user' => $ProposedBy, 'role' => 'Marketing (Level-1)'],
        'Evaluated by' => ['user' => $EvaluatedBy, 'role' => 'Marketing (Level-2)'],
        'Recommended by' => ['user' => $RecommendedBy, 'role' => 'Marketing (Level-3)'],
    ] as $title => $data)
                                            <td>
                                                <div class="text-center">
                                                    <span><strong>{{ $title }}</strong></span><br>
                                                    @if (isset($data['user']->UserName))
                                                        <span>{{ $data['user']->UserName ?? '' }}</span><br>
                                                        <span>{{ $data['user']->Designation ?? '' }}</span>
                                                    @else
                                                        <span>&nbsp;</span><br>
                                                        <span>&nbsp;</span>
                                                    @endif


                                                    <p class="border-bottom" style="width: 80%; margin: 0 auto; ">&nbsp;
                                                    </p>
                                                    <p>{{ $data['role'] }}</p>
                                                </div>
                                            </td>
                                        @endforeach
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12  table-responsive">
                            <table class="table table-sm table-bordered align-middle">

                                <thead class="table-light">
                                    <tr>
                                        <th scope="col" class="text-center" style="width: 20%">Designation</th>
                                        <th scope="col" class="text-center" style="width: 35%">Comments</th>
                                        <th scope="col" class="text-center" style="width: 15%">Action</th>
                                        <th scope="col" class="text-center signature-header" style="width: 35%">
                                            Signature with Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <strong>Assistant General Manager</strong><br>
                                            <span class="department">Product Development</span>
                                        </td>
                                        <td class="empty-state text-center">
                                            {{  $TopManagement1 ? $TopManagement1->Comment : ' ' }}</td>
                                        <td class="empty-state text-center">
                                           @if ($TopManagement1)

                                           {{  $TopManagement1->StatusID == 1 ? 'Recommended' : 'Not Recommended' }}

                                           @else

                                           @endif
                                        </td>
                                        <td class="empty-state text-center">
                                            {{ $TopManagement1 && $TopManagement1->ApprovedDate ? date('Y-m-d', strtotime($TopManagement1->ApprovedDate)) : ' ' }}

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong>Director</strong><br>
                                            <span class="department">Quality Assurance</span>
                                        </td>
                                        <td class="empty-state text-center">
                                            {{  $TopManagement2 ? $TopManagement2->Comment : ' ' }}</td>
                                        <td class="empty-state text-center">
                                           @if ($TopManagement2)

                                           {{  $TopManagement2->StatusID == 1 ? 'Recommended' : 'Not Recommended' }}

                                           @else

                                           @endif
                                        </td>
                                        <td class="empty-state text-center">
                                            {{ $TopManagement1 && $TopManagement1->ApprovedDate ? date('Y-m-d', strtotime($TopManagement1->ApprovedDate)) : ' ' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong>Director</strong><br>
                                            <span class="department">Operations</span>
                                        </td>
                                        <td class="empty-state text-center">
                                            {{  $TopManagement3 ? $TopManagement3->Comment : ' ' }}</td>
                                        <td class="empty-state text-center">
                                           @if ($TopManagement3)

                                           {{  $TopManagement3->StatusID == 1 ? 'Recommended' : 'Not Recommended' }}

                                           @else

                                           @endif
                                        </td>
                                        <td class="empty-state text-center">
                                            {{ $TopManagement1 && $TopManagement1->ApprovedDate ? date('Y-m-d', strtotime($TopManagement1->ApprovedDate)) : ' ' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong>Deputy Director</strong><br>
                                            <span class="department">Supply Chain</span>
                                        </td>
                                        <td class="empty-state text-center">
                                            {{  $TopManagement4 ? $TopManagement4->Comment : ' ' }}</td>
                                        <td class="empty-state text-center">
                                           @if ($TopManagement4)

                                           {{  $TopManagement4->StatusID == 1 ? 'Recommended' : 'Not Recommended' }}

                                           @else

                                           @endif
                                        </td>
                                        <td class="empty-state text-center">

                                            {{ $TopManagement1 && $TopManagement1->ApprovedDate ? date('Y-m-d', strtotime($TopManagement1->ApprovedDate)) : ' ' }}

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong>Director</strong><br>
                                            <span class="department">Marketing Operations</span>
                                        </td>
                                        <td class="empty-state text-center">
                                            {{  $TopManagement5 ? $TopManagement5->Comment : ' ' }}</td>
                                        <td class="empty-state text-center">
                                           @if ($TopManagement5)

                                           {{  $TopManagement5->StatusID == 1 ? 'Recommended' : 'Not Recommended' }}

                                           @else


                                           @endif
                                        </td>
                                        <td class="empty-state text-center">
                                            {{ $TopManagement5 && $TopManagement5->ApprovedDate ? date('Y-m-d', strtotime($TopManagement5->ApprovedDate)) : ' ' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong>Chief Operating Officer</strong>
                                        </td>
                                        <td class="empty-state text-center">
                                            {{  $TopManagement6 ? $TopManagement6->Comment : ' ' }}</td>
                                        <td class="empty-state text-center">
                                           @if ($TopManagement6)

                                           {{  $TopManagement6->StatusID == 1 ? 'Approved' : 'Not Approved' }}

                                           @else

                                           @endif
                                        </td>
                                        <td class="empty-state text-center">
                                            {{ $TopManagement6 && $TopManagement6->ApprovedDate ? date('Y-m-d', strtotime($TopManagement6->ApprovedDate)) : ' ' }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </x-slot>
</x-app-component>

<script>
    function printDivContent(divId) {
        var divContent = document.getElementById(divId).innerHTML;
        var originalContent = document.body.innerHTML;

        document.body.innerHTML = divContent;
        window.print();
        document.body.innerHTML = originalContent;
        location.reload();
    }

    document.getElementById('printButton').addEventListener('click', function() {
        printDivContent('contentToPrint');
    });
</script>
