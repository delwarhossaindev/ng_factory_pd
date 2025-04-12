<x-app-component>
    <x-page.page-title data="Proposal Report" />

    <x-slot name="style">
        <link rel="stylesheet" href="{{ asset('css/print.css') }}">
        <style>
            @media print {
                @page {
                    size: A4;
                    margin: 20mm;

                }

                .footer {
                    position: fixed;
                    bottom: 0;
                    left: 0;
                    right: 0;
                    width: 100%;
                    text-align: center;
                    font-size: 7pt;
                    padding: 5px 0;
                }

                /* Ensure content doesn't overlap with footer */
                #contentToPrint {
                    margin-bottom: 20mm;
                }


                body {
                    font-size: 7pt;
                    /* Standard readable font size */
                    font-family: Arial, sans-serif;
                    /* Clean, professional font */
                }

                .header table td {
                    vertical-align: top;
                    padding: 4px 8px;
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

            .table th {
                letter-spacing: 0px;
                vertical-align: middle;
                text-transform: capitalize;
            }

            .table td {
                padding-left: 10px;
            }

            .table-sm th {
                vertical-align: middle;
            }

            /* .footer{
                    padding: 15px 20px 0px 20px
                } */
        </style>
    </x-slot>

    <x-slot name="content">
        @php
            $referenceStatuses = ['FDA', 'BNF', 'UKMHRA', 'TGA', 'PMDA', 'EMA', 'Others'];
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
                    <div class="d-flex justify-content-between align-items-center ">
                        <div class="mt-4">
                            <img src="{{ asset('aci-logo.png') }}" alt="ACI Logo" class="me-2" style="height: 40px;">
                            <p class="fw-bold mt-1">Advanced Chemical Industries Limited</p>
                        </div>
                        <div>
                            <h6 class="fw-bold">FORM FOR PRODUCT PROPOSAL</h6>
                        </div>
                    </div>



                    <div class="header">
                        <table class="table borderless">
                            <tr>
                                <td>
                                    <p class="m-0 d-flex justify-content-between">New Product Category <span
                                            class="pe-5">:</span></p>
                                </td>
                                <td>
                                    <input type="checkbox"
                                        {{ $proposal->ProductCategory === 'New Molecule' ? 'checked' : '' }}> New
                                    Molecule &nbsp;
                                    <input type="checkbox"
                                        {{ $proposal->ProductCategory === 'Line Extension' ? 'checked' : '' }}> Line
                                    Extension
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p class="m-0 d-flex justify-content-between">Reference Status <span
                                            class="pe-5">:</span></p>
                                </td>
                                <td colspan="3">
                                    @foreach ($referenceStatuses as $status)
                                        <input type="checkbox" {{ in_array($status, $saveStatus) ? 'checked' : '' }}>
                                        {{ $status }} &nbsp;
                                    @endforeach
                                </td>
                            </tr>

                            <tr>
                                <td colspan="4" class="pt-3">
                                    <span class="section-title fw-bold">A. GENERAL INFORMATION</span>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <p class="m-0 d-flex justify-content-between">Generic Name<span
                                            class="pe-5">:</span></p>
                                </td>
                                <td>{{ $proposal->generalInfo->GenericName ?? 'N/A' }}</td>
                                <td>Therapeutic Class :</td>
                                <td>{{ $proposal->generalInfo->TherapeuticClass ?? 'N/A' }}</td>
                            </tr>

                            <tr>
                                <td>
                                    <p class="m-0 d-flex justify-content-between">Indication <span
                                            class="pe-5">:</span></p>
                                </td>
                                <td colspan="3">{{ $proposal->generalInfo->Indication ?? 'N/A' }}</td>
                            </tr>

                            <tr>
                                <td>
                                    <p class="m-0 d-flex justify-content-between">Local Competitors <span
                                            class="pe-5">:</span></p>
                                </td>
                                <td>{{ $proposal->generalInfo->LocalCompetitors ?? 'N/A' }}</td>
                                <td>Originator’s Brand :</td>
                                <td>{{ $proposal->generalInfo->OriginatorBrand ?? 'N/A' }} </td>
                            </tr>
                        </table>
                    </div>




                    <div class="row">
                        <div class="col-sm-12  table-responsive">
                            <table class="table table-sm table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-center text-capitalize" style=" border: 1px solid #000;">
                                            Strength & Dosage Form</th>
                                        <th class="text-center text-capitalize" style=" border: 1px solid #000;">Pack
                                            <br> Size</th>
                                        <th class="text-center text-capitalize" style=" border: 1px solid #000;">Primary
                                            Pack</th>
                                        <th class="text-center " style=" border: 1px solid #000; ">IP or MRP <br>/Unit
                                            (Tk.)</th>
                                        <th class="text-center" style=" border: 1px solid #000;">IP or MRP <br>/Pack
                                            (Tk.)</th>
                                        <th class="text-center text-capitalize" style=" border: 1px solid #000;">
                                            TP/Pack<br>(Tk.)</th>
                                        <th class="text-center text-capitalize" style=" border: 1px solid #000;">DCC
                                            <br> Number</th>
                                        <th class="text-center text-capitalize" style=" border: 1px solid #000;">
                                            Availability in <br> BD</th>
                                    </tr>
                                </thead>
                                <tbody id="services">
                                    @foreach ($proposal->generalInfo->details as $service)
                                        <tr>
                                            <td style=" border: 1px solid #000;">{{ $service->StrengthDosageForm }}
                                            </td>
                                            <td class="text-center" style=" border: 1px solid #000;">
                                                {{ $service->PackSize }}</td>
                                            <td class="text-center" style=" border: 1px solid #000;">
                                                {{ $service->PrimaryPack }}</td>
                                            <td class="text-center" style=" border: 1px solid #000;">
                                                {{ $service->MRPUnit }}</td>
                                            <td class="text-center" style=" border: 1px solid #000;">
                                                {{ $service->MRPPack }}</td>
                                            <td class="text-center" style=" border: 1px solid #000;">
                                                {{ $service->TP }}</td>
                                            <td class="text-center" style=" border: 1px solid #000;">
                                                {{ $service->DCCNumber }}</td>
                                            <td class="text-center" style=" border: 1px solid #000;">
                                                {{ $service->Availability }}</td>
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
                                        <th rowspan="2" class="text-center" style=" border: 1px solid #000;">Strength
                                            & Dosage Form</th>
                                        <th colspan="2" class="text-center" style=" border: 1px solid #000;">Year-1
                                        </th>
                                        <th colspan="2" class="text-center" style=" border: 1px solid #000;">Year-2
                                        </th>
                                        <th colspan="2" class="text-center" style=" border: 1px solid #000;">Year-3
                                        </th>
                                        <th rowspan="2" class="text-center" style=" border: 1px solid #000;">
                                            Launching <br> Month</th>
                                    </tr>
                                    <tr>
                                        <th class="text-center" style=" border: 1px solid #000;">Unit</th>
                                        <th class="text-center" style=" border: 1px solid #000;">Value (M)</th>
                                        <th class="text-center" style=" border: 1px solid #000;">Unit</th>
                                        <th class="text-center" style=" border: 1px solid #000;">Value (M)</th>
                                        <th class="text-center" style=" border: 1px solid #000;">Unit</th>
                                        <th class="text-center" style=" border: 1px solid #000;">Value (M)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($proposal->forecasts as $forecast)
                                        <tr>
                                            <td style=" border: 1px solid #000;">{{ $forecast->StrengthDosageForm }}
                                            </td>
                                            <td class="text-center" style=" border: 1px solid #000;">
                                                {{ $forecast->Year1Unit }}</td>
                                            <td class="text-center" style=" border: 1px solid #000;">
                                                {{ $forecast->Year1Value }}</td>
                                            <td class="text-center" style=" border: 1px solid #000;">
                                                {{ $forecast->Year2Unit }}</td>
                                            <td class="text-center" style=" border: 1px solid #000;">
                                                {{ $forecast->Year2Value }}</td>
                                            <td class="text-center" style=" border: 1px solid #000;">
                                                {{ $forecast->Year3Unit }}</td>
                                            <td class="text-center" style=" border: 1px solid #000;">
                                                {{ $forecast->Year3Value }}</td>
                                            <td class="text-center" style=" border: 1px solid #000;">
                                                {{ date('M, Y', strtotime($forecast->LaunchingMonth)) }}</td>
                                        </tr>
                                        @php
                                            $Year1Unit += $forecast->Year1Unit;
                                            $Year1Value += $forecast->Year1Value;
                                            $Year2Unit += $forecast->Year2Unit;
                                            $Year2Value += $forecast->Year2Value;
                                            $Year3Unit += $forecast->Year3Unit;
                                            $Year3Value += $forecast->Year3Value;
                                        @endphp
                                    @endforeach

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td class="text-center" style=" border: 1px solid #000;"> <b>Total</b> </td>
                                        <td class="text-center" style=" border: 1px solid #000;">{{ $Year1Unit }}
                                        </td>
                                        <td class="text-center" style=" border: 1px solid #000;">{{ $Year1Value }}
                                        </td>
                                        <td class="text-center" style=" border: 1px solid #000;">{{ $Year2Unit }}
                                        </td>
                                        <td class="text-center" style=" border: 1px solid #000;">{{ $Year2Value }}
                                        </td>
                                        <td class="text-center" style=" border: 1px solid #000;">{{ $Year3Unit }}
                                        </td>
                                        <td class="text-center" style=" border: 1px solid #000;">{{ $Year3Value }}
                                        </td>
                                        <td class="text-center" style=" border: 1px solid #000;"></td>
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
                                                        <span>{{ $data['user']->Designation ?? '' }}</span><br>
                                                        <span>{{ $data['user']->SignatureDate ?? '' }}</span>
                                                    @else
                                                        <span>&nbsp;</span><br>
                                                        <span>&nbsp;</span>
                                                    @endif


                                                    <p
                                                        style="width: 80%; margin: 0 auto; border-bottom: 1px solid rgb(0, 0, 0);">
                                                        &nbsp;</p>
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

                                <thead class=" border-b">
                                    <tr>
                                        <th scope="col" class="text-center border-b bg-transparent"
                                            style="width: 20%;  border: 1px solid #000;">Designation</th>
                                        <th scope="col" class="text-center border-b bg-transparent"
                                            style="width: 35%;  border: 1px solid #000;">Comments</th>
                                        <th scope="col" class="text-center border-b bg-transparent"
                                            style="width: 15%;  border: 1px solid #000; width:20%">Action</th>
                                        <th scope="col"
                                            class="text-center border-b bg-transparent signature-header"
                                            style="width: 35%; border: 1px solid #000; ">
                                            Signature with Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style=" border: 1px solid #000;">
                                            <strong>Assistant General Manager</strong><br>
                                            <span class="department">Product Development</span>
                                        </td>
                                        <td class="empty-state text-center" style=" border: 1px solid #000;">
                                            {{ $TopManagement1 ? $TopManagement1->Comment : ' ' }}</td>
                                        <td class="empty-state " style=" border: 1px solid #000;">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox"
                                                    {{ $TopManagement1 && $TopManagement1->StatusID == 1 ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="recommendedCheck">Recommended</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox"
                                                    {{ $TopManagement1 && $TopManagement1->StatusID == 2 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="notRecommendedCheck">Not
                                                    recommended</label>
                                            </div>
                                        </td>
                                        <td class="empty-state text-center" style=" border: 1px solid #000;">
                                            {{ $TopManagement1 && $TopManagement1->ApprovedDate ? date('Y-m-d', strtotime($TopManagement1->ApprovedDate)) : ' ' }}

                                        </td>
                                    </tr>
                                    <tr>
                                        <td style=" border: 1px solid #000;">
                                            <strong>Director</strong><br>
                                            <span class="department">Quality Assurance</span>
                                        </td>
                                        <td class="empty-state text-center" style=" border: 1px solid #000;">
                                            {{ $TopManagement2 ? $TopManagement2->Comment : ' ' }}</td>
                                        <td class="empty-state" style=" border: 1px solid #000;">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox"
                                                    {{ $TopManagement2 && $TopManagement2->StatusID == 1 ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="recommendedCheck">Recommended</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox"
                                                    {{ $TopManagement2 && $TopManagement2->StatusID == 2 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="notRecommendedCheck">Not
                                                    recommended</label>
                                            </div>
                                        </td>
                                        <td class="empty-state text-center" style=" border: 1px solid #000;">
                                            {{ $TopManagement2 && $TopManagement2->ApprovedDate ? date('Y-m-d', strtotime($TopManagement2->ApprovedDate)) : ' ' }}
                                        </td>
                                    </tr>
                                    <tr style=" border: 1px solid #000;">
                                        <td style=" border: 1px solid #000;">
                                            <strong>Director</strong><br>
                                            <span class="department">Operations</span>
                                        </td>
                                        <td class="empty-state text-center" style=" border: 1px solid #000;">
                                            {{ $TopManagement3 ? $TopManagement3->Comment : ' ' }}</td>
                                        <td class="empty-state ">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox"
                                                    {{ $TopManagement3 && $TopManagement3->StatusID == 1 ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="recommendedCheck">Recommended</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox"
                                                    {{ $TopManagement3 && $TopManagement3->StatusID == 2 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="notRecommendedCheck">Not
                                                    recommended</label>
                                            </div>
                                        </td>
                                        <td class="empty-state text-center" style=" border: 1px solid #000;">
                                            {{ $TopManagement3 && $TopManagement3->ApprovedDate ? date('Y-m-d', strtotime($TopManagement3->ApprovedDate)) : ' ' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style=" border: 1px solid #000;">
                                            <strong>Deputy Director</strong><br>
                                            <span class="department">Supply Chain</span>
                                        </td>
                                        <td class="empty-state text-center" style=" border: 1px solid #000;">
                                            {{ $TopManagement4 ? $TopManagement4->Comment : ' ' }}</td>
                                        <td class="empty-state" style=" border: 1px solid #000;">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox"
                                                    {{ $TopManagement4 && $TopManagement4->StatusID == 1 ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="recommendedCheck">Recommended</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox"
                                                    {{ $TopManagement4 && $TopManagement4->StatusID == 2 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="notRecommendedCheck">Not
                                                    recommended</label>
                                            </div>
                                        </td>
                                        <td class="empty-state text-center" style=" border: 1px solid #000;">

                                            {{ $TopManagement4 && $TopManagement4->ApprovedDate ? date('Y-m-d', strtotime($TopManagement4->ApprovedDate)) : ' ' }}

                                        </td>
                                    </tr>
                                    <tr>
                                        <td style=" border: 1px solid #000;">
                                            <strong>Director</strong><br>
                                            <span class="department">Marketing Operations</span>
                                        </td>
                                        <td class="empty-state text-center" style=" border: 1px solid #000;">
                                            {{ $TopManagement5 ? $TopManagement5->Comment : ' ' }}</td>
                                        <td class="empty-state" style=" border: 1px solid #000;">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox"
                                                    {{ $TopManagement5 && $TopManagement5->StatusID == 1 ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="recommendedCheck">Recommended</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox"
                                                    {{ $TopManagement5 && $TopManagement5->StatusID == 2 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="notRecommendedCheck">Not
                                                    recommended</label>
                                            </div>
                                        </td>
                                        <td class="empty-state text-center" style=" border: 1px solid #000;">
                                            {{ $TopManagement5 && $TopManagement5->ApprovedDate ? date('Y-m-d', strtotime($TopManagement5->ApprovedDate)) : ' ' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style=" border: 1px solid #000;">
                                            <strong>Chief Operating Officer</strong>
                                        </td>
                                        <td class="empty-state text-center" style=" border: 1px solid #000;">
                                            {{ $TopManagement6 ? $TopManagement6->Comment : ' ' }}</td>
                                        <td class="empty-state " style=" border: 1px solid #000;">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox"
                                                    {{ $TopManagement6 && $TopManagement6->StatusID == 1 ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="recommendedCheck">Recommended</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox"
                                                    {{ $TopManagement6 && $TopManagement6->StatusID == 2 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="notRecommendedCheck">Not
                                                    recommended</label>
                                            </div>
                                        </td>
                                        <td class="empty-state text-center" style=" border: 1px solid #000;">
                                            {{ $TopManagement6 && $TopManagement6->ApprovedDate ? date('Y-m-d', strtotime($TopManagement6->ApprovedDate)) : ' ' }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="footer">
                        <table style="width: 100%;">
                            <tr>
                                <td style="text-align: left; width: 50%; ">Form No.: PD-001-01/07</td>
                                <td style="text-align: right; width: 50%; ">Page <span class="pageNumber"></span> of
                                    <span class="totalPages"></span></td>
                            </tr>
                        </table>
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

        // Add page numbers before printing
        var pages = document.querySelectorAll('.pageNumber');
        var totalPages = document.querySelectorAll('.totalPages');
        var pageCount = 1;

        // Calculate total pages (this is an approximation)
        // var total = 1
        var total = Math.floor(document.body.scrollHeight / (window.innerHeight * 0.9));
        console.log('Total pages:', total);

        // Update all page number elements
        for (var i = 0; i < pages.length; i++) {
            pages[i].textContent = pageCount;
            totalPages[i].textContent = total;
        }

        window.print();
        document.body.innerHTML = originalContent;
        location.reload();
    }

    document.getElementById('printButton').addEventListener('click', function() {
        printDivContent('contentToPrint');
    });
</script>
