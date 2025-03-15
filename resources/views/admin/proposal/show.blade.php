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
                                            <td class="text-center">{{ $forecast->LaunchingMonth }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
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
                                                    <p><strong>{{ $title }}</strong></p>

                                                    @if ($data['user'] && $data['user']->SignaturePath)
                                                    <img src="{{ asset('storage/' . $data['user']->SignaturePath) }}"
                                                    alt="Signature"
                                                    style="width: 120px; height: 40px; object-fit: contain;">
                                                    @else

                                                    <div  style="width: 120px; height: 40px; object-fit: contain;">

                                                    </div>

                                                    @endif

                                                    <p class="border-bottom"
                                                        style="width: 80%; margin: 0 auto; padding-bottom: 5px;">&nbsp;
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
                                        <td class="empty-state text-center">&nbsp;</td>
                                        <td class="empty-state text-center">&nbsp;</td>
                                        <td class="empty-state text-center"><img src="http://127.0.0.1:8000/storage/signatures/DALkMhEBxMWLVkS6sKN8yMleQUozKbD7Ub4MpoAY.png" alt="Signature" style="width: 120px; height: 40px; object-fit: contain;"></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong>Director</strong><br>
                                            <span class="department">Quality Assurance</span>
                                        </td>
                                        <td class="empty-state text-center">&nbsp;</td>
                                        <td class="empty-state text-center">&nbsp;</td>
                                        <td class="empty-state text-center"><img src="http://127.0.0.1:8000/storage/signatures/DALkMhEBxMWLVkS6sKN8yMleQUozKbD7Ub4MpoAY.png" alt="Signature" style="width: 120px; height: 40px; object-fit: contain;"></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong>Director</strong><br>
                                            <span class="department">Operations</span>
                                        </td>
                                        <td class="empty-state text-center">&nbsp;</td>
                                        <td class="empty-state text-center">&nbsp;</td>
                                        <td class="empty-state text-center"><img src="http://127.0.0.1:8000/storage/signatures/DALkMhEBxMWLVkS6sKN8yMleQUozKbD7Ub4MpoAY.png" alt="Signature" style="width: 120px; height: 40px; object-fit: contain;"></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong>Deputy Director</strong><br>
                                            <span class="department">Supply Chain</span>
                                        </td>
                                        <td class="empty-state text-center">&nbsp;</td>
                                        <td class="empty-state text-center">&nbsp;</td>
                                        <td class="empty-state text-center"><img src="http://127.0.0.1:8000/storage/signatures/DALkMhEBxMWLVkS6sKN8yMleQUozKbD7Ub4MpoAY.png" alt="Signature" style="width: 120px; height: 40px; object-fit: contain;"></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong>Director</strong><br>
                                            <span class="department">Marketing Operations</span>
                                        </td>
                                        <td class="empty-state text-center">&nbsp;</td>
                                        <td class="empty-state text-center">&nbsp;</td>
                                        <td class="empty-state text-center"><img src="http://127.0.0.1:8000/storage/signatures/DALkMhEBxMWLVkS6sKN8yMleQUozKbD7Ub4MpoAY.png" alt="Signature" style="width: 120px; height: 40px; object-fit: contain;"></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong>Chief Operating Officer</strong>
                                        </td>
                                        <td class="empty-state text-center">&nbsp;</td>
                                        <td class="empty-state text-center">&nbsp;</td>
                                        <td class="empty-state text-center"><img src="http://127.0.0.1:8000/storage/signatures/DALkMhEBxMWLVkS6sKN8yMleQUozKbD7Ub4MpoAY.png" alt="Signature" style="width: 120px; height: 40px; object-fit: contain;"></td>
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
