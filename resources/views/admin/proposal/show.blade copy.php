<x-app-component>
    <x-page.page-title data="Credit Note Information" />
    
    <x-slot name="style">
        <link rel="stylesheet" href="{{ asset('css/print.css') }}">
        <style>
            @media print {
                @page {
                    size: A4;
                    margin: 10mm; /* Standard A4 margin */
                }

                body {
                    font-size: 8pt; /* Standard readable font size */
                    font-family: Arial, sans-serif; /* Clean, professional font */
                }

                table {
                    width: 100%;
                    font-size: 8pt; /* Consistent table text size */
                }

                th, td {
                    font-size: 8pt;
                    padding: 5px;
                    text-align: left;
                }

                h5 {
                    font-size: 10pt; /* Slightly larger for headings */
                    font-weight: bold;
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
            $saveStatus = collect($proposal->referenceStatuses ?? [])->pluck('ReferenceStatus')->toArray();
        @endphp

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <button id="printButton" class="btn btn-info btn-outline-info btn-md">Print</button>
                    </div>
                </div>

                <!--  -->
                <div id="contentToPrint">
                    <h5 class="mt-4 d-flex align-items-center">
                        <img src="{{ asset('aci-logo.png') }}" alt="ACI Logo" class="me-2" style="height: 40px;">
                        <strong>Advanced Chemical Industries Limited</strong>
                    </h5>

                    <div>
                        <p class="mb-2"><b>New Product Category:</b> {{ $proposal->ProductCategory }}</p>
                        <p class="mb-0"><b>Reference Status:</b> {{ implode(', ',  $saveStatus) }}</p>
                    </div>
                    
                    <br>
                    <h5>A. GENERAL INFORMATION</h5>
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-sm table-borderless">
                                <tbody>
                                    <tr>
                                        <td><b>Generic Name:</b> {{ $proposal->generalInfo->GenericName }}</td>
                                        <td class="text-right"><b>Therapeutic Class:</b> {{ $proposal->generalInfo->TherapeuticClass }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><b>Indication:</b> {{ $proposal->generalInfo->Indication }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Local Competitors:</b> {{ $proposal->generalInfo->LocalCompetitors }}</td>
                                        <td class="text-right"><b>Originator’s Brand:</b> {{ $proposal->generalInfo->OriginatorBrand }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 card-body table-responsive">
                            <table class="table table-sm table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-center">Strength & Dosage Form</th>
                                        <th class="text-center">Pack Size</th>
                                        <th class="text-center">Primary Pack</th>
                                        <th class="text-center">MRP/Unit (Tk.)</th>
                                        <th class="text-center">MRP/Pack (Tk.)</th>
                                        <th class="text-center">TP/Pack (Tk.)</th>
                                        <th class="text-center">DCC Number</th>
                                        <th class="text-center">Availability in BD</th>
                                    </tr>
                                </thead>
                                <tbody id="services">
                                    @foreach ($proposal->generalInfo->details as $service)
                                        <tr>
                                            <td>{{ $service->StrengthDosageForm }}</td>
                                            <td class="text-center">{{ $service->PackSize }}</td>
                                            <td class="text-right">{{ $service->PrimaryPack }}</td>
                                            <td class="text-right">{{ $service->MRPUnit }}</td>
                                            <td class="text-right">{{ $service->MRPPack }}</td>
                                            <td class="text-right">{{ $service->TP }}</td>
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
                        <div class="col-sm-12 card-body table-responsive">
                            <table class="table table-sm table-bordered">
                                <thead>
                                    <tr>
                                        <th rowspan="2" class="text-center">Strength & Dosage Form</th>
                                        <th colspan="2" class="text-center">Year-1</th>
                                        <th colspan="2" class="text-center">Year-2</th>
                                        <th colspan="2" class="text-center">Year-3</th>
                                        <th rowspan="2" class="text-center">Launching Month</th>
                                    </tr>
                                    <tr>
                                        <th class="text-center">Unit</th>
                                        <th class="text-center">Value</th>
                                        <th class="text-center">Unit</th>
                                        <th class="text-center">Value</th>
                                        <th class="text-center">Unit</th>
                                        <th class="text-center">Value</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($proposal->forecasts as $forecast)
                                        <tr>
                                            <td>{{ $forecast->StrengthDosageForm }}</td>
                                            <td class="text-center">{{ $forecast->Year1Unit }}</td>
                                            <td class="text-right">{{ $forecast->Year1Value }}</td>
                                            <td class="text-center">{{ $forecast->Year2Unit }}</td>
                                            <td class="text-right">{{ $forecast->Year2Value }}</td>
                                            <td class="text-center">{{ $forecast->Year3Unit }}</td>
                                            <td class="text-right">{{ $forecast->Year3Value }}</td>
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
                                    <td>
                                        <div>
                                            <p><strong>Proposed by</strong></p>
                                            <p>................................</p>
                                            <p>Marketing (Level-1)</p>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <p><strong>Evaluated by</strong></p>
                                            <p>................................</p>
                                            <p>Marketing (Level-2)</p>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <p><strong>Recommended by</strong></p>
                                            <p>................................</p>
                                            <p>Marketing (Level-3)</p>
                                        </div>
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
