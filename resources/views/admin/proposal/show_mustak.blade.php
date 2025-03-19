<x-app-component>
    <x-page.page-title data="Credit Note Information" />
    
    <x-slot name="style">
        <link rel="stylesheet" href="{{ asset('css/print.css') }}">
        <style>
               .local-compettotors table td{
                    padding: 2px 8px !important;
                }
                .table-1 b, .table-2 b{
                  text-transform: capitalize;
                }
                .table>:not(caption)>*>* {
                 padding: 2px 8px;
              }
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
                    padding: 2px 8px;
                    text-align: left;
                    vertical-align: middle; /* Ensure vertical alignment in the middle */
                }

                h5 {
                    font-size: 10pt; /* Slightly larger for headings */
                    font-weight: bold;
                }
             

                /* Hide elements that should not be printed */
                #printButton {
                    display: none;
                }

                /* Ensure the signature area is centered */
                .signature-table td {
                    vertical-align: middle;
                }

                .signature-table p {
                    margin: 0;
                }

                .signature-section {
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    flex-direction: column;
                    height: 100%;
                }

                .signature-table {
                    margin: 0 auto; /* Center the table */
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
                        <button id="printButton" class="btn btn-info btn-outline-info btn-md mb-2">Print</button>
                    </div>
                </div>

                <!-- start here -->
                    <div id="contentToPrint">
                        <!-- page header start -->
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <img src="{{ asset('aci-logo.png') }}" alt="ACI Logo" class="me-2" style="height: 40px;">
                                <h5 class="mt-2">
                                    <strong>Advanced Chemical Industries Limited</strong>
                                </h5>
                            </div>
                            <!-- <h4>FORM FOR PRODUCT PROPOSAL</h4> -->
                        </div>
                        <!-- page header end -->

                        <table class="table border-0 table-1">
                               <tr>
                                    <td class="form-label py-0" style="width:200px"><b>New Product Category</b></td>
                                    <td class="px-2 py-0" style="width:10px"><b>:</b></td>
                                    <td class="py-0">{{ $proposal->ProductCategory }}</td>
                                </tr>
                                <tr>
                                    <td class="form-label py-0"><b>Reference Status</b></td>
                                    <td class="px-2 py-0"><b>:</b></td>
                                    <td class="py-0">{{ implode(', ', $saveStatus) }}</td>
                                </tr> 
                        </table>


                        <h6 class="fw-bold mt-2 mb-1" style="font-size:14px">A. GENERAL INFORMATION</h6>
                            <table class="table border-0 table-2">
                                <tr>
                                    <td class="form-label py-0" style="width:200px"><b>Generic Name</b></td>
                                    <td class="px-2 py-0" style="width:200px"><b>:</b></td>
                                    <td class="py-0"></td>
                                    <td class="form-label py-0" style="width:200px"><b>Therapeutic Class</b></td>
                                    <td class="px-2 py-0" style="width:200px"><b>:</b></td>
                                    <td class="py-0"></td>
                                </tr>
                                <tr>
                                    <td class="form-label py-0"><b>Indication</b></td>
                                    <td class="px-2 py-0"><b>:</b></td>
                                    <td class="py-0" colspan="4"></td>
                                </tr>
                                <tr>
                                    <td class="form-label py-0"><b>Local Competitors</b></td>
                                    <td class="px-2 py-0"><b>:</b></td>
                                    <td class="py-0"></td>
                                    <td class="form-label py-0"><b>Originator’s Brand</b></td>
                                    <td class="px-2 py-0"><b>:</b></td>
                                    <td class="py-0"></td>
                                </tr>
                            </table>

                            <table class="table table-sm table-bordered local-compettotors">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="background-color: #f8f9fa; font-weight: bold; padding: 2px 8px; text-transform: capitalize; width: 200px;">Strength & Dosage Form</th>
                                        <th class="text-center" style="background-color: #f8f9fa; font-weight: bold; padding: 2px 8px; text-transform: capitalize;">Pack Size</th>
                                        <th class="text-center" style="background-color: #f8f9fa; font-weight: bold; padding: 2px 8px; text-transform: capitalize; width: 150px; ">Primary Pack</th>
                                        <th class="text-center" style="background-color: #f8f9fa; font-weight: bold; padding: 2px 8px; text-transform: capitalize;">IP or MRP/Unit (Tk)</th>
                                        <th class="text-center" style="background-color: #f8f9fa; font-weight: bold; padding: 2px 8px; text-transform: capitalize;">IP or MRP/Pack (Tk.)</th>
                                        <th class="text-center" style="background-color: #f8f9fa; font-weight: bold; padding: 2px 8px; text-transform: capitalize;">TP/Pack (Tk.)</th>
                                        <th class="text-center" style="background-color: #f8f9fa; font-weight: bold; padding: 2px 8px; text-transform: capitalize;">DCC Number</th>
                                        <th class="text-center" style="background-color: #f8f9fa; font-weight: bold; padding: 2px 8px; text-transform: capitalize;">Availability in BD</th>
                                    </tr>
                                </thead>
                                <tbody id="services">
                                    @foreach ($proposal->generalInfo->details as $service)
                                        <tr>
                                            <td>{{ $service->StrengthDosageForm }}</td>
                                            <td class="text-center" style="padding: 2px 8px;"></td>
                                            <td class="text-right" style="padding: 2px 8px;"></td>
                                            <td class="text-right" style="padding: 2px 8px;"></td>
                                            <td class="text-right" style="padding: 2px 8px;"></td>
                                            <td class="text-right" style="padding: 2px 8px;"></td>
                                            <td class="text-center" style="padding: 2px 8px;"></td>
                                            <td class="text-center" style="padding: 2px 8px;"></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        <div class="mb-2">
                            <h6 class="col-sm-12 mt-3 mb-1 fw-bold">B. FORECAST</h6>
                            <table class="table table-sm table-bordered">
                                    <thead>
                                        <tr>
                                            <th rowspan="2" class="text-center text-capitalize">Strength & Dosage Form</th>
                                            <th colspan="2" class="text-center text-capitalize">Year-1</th>
                                            <th colspan="2" class="text-center text-capitalize">Year-2</th>
                                            <th colspan="2" class="text-center text-capitalize">Year-3</th>
                                            <th rowspan="2" class="text-center text-capitalize">Launching Month</th>
                                        </tr>
                                        <tr>
                                            <th class="text-center text-capitalize">Unit</th>
                                            <th class="text-center text-capitalize">Value</th>
                                            <th class="text-center text-capitalize">Unit</th>
                                            <th class="text-center text-capitalize">Value</th>
                                            <th class="text-center text-capitalize">Unit</th>
                                            <th class="text-center text-capitalize">Value</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($proposal->forecasts as $forecast)
                                            <tr>
                                                <td style="padding: 2px 4px;">{{ $forecast->StrengthDosageForm }}</td>
                                                <td class="text-center" style="padding: 2px 8px;">{{ $forecast->Year1Unit }}</td>
                                                <td class="text-right" style="padding: 2px 8px;">{{ $forecast->Year1Value }}</td>
                                                <td class="text-center" style="padding: 2px 8px;">{{ $forecast->Year2Unit }}</td>
                                                <td class="text-right" style="padding: 2px 8px;">{{ $forecast->Year2Value }}</td>
                                                <td class="text-center" style="padding: 2px 8px;">{{ $forecast->Year3Unit }}</td>
                                                <td class="text-right" style="padding: 2px 8px;">{{ $forecast->Year3Value }}</td>
                                                <td class="text-center" style="padding: 2px 8px;">{{ $forecast->LaunchingMonth }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td class=" text-capitalize" style="padding: 2px 4px;">Total</td>
                                            <td class="text-right" style="padding: 2px 8px;"></td>
                                            <td class="text-right" style="padding: 2px 8px;"></td>
                                            <td class="text-right" style="padding: 2px 8px;"></td>
                                            <td class="text-right" style="padding: 2px 8px;"></td>
                                            <td class="text-right" style="padding: 2px 8px;"></td>
                                            <td class="text-right" style="padding: 2px 8px;"></td>
                                            <td class="text-right" style="padding: 2px 8px;"></td>
                                        </tr>
                                    </tfoot>
                                </table>
                        </div>
                    <!-- signature -->
                        <div class="row justify-content-center signature-section">
                            <div class="col-sm-12 m-auto">
                                <table class="table table-sm table-borderless text-center signature-table m-auto">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="text-center">
                                                    <p class="mb-1"><strong>Proposed by</strong></p>

                                                    <img src="{{ asset('storage/signatures/DALkMhEBxMWLVkS6sKN8yMleQUozKbD7Ub4MpoAY.png') }}"
                                                    alt="Signature"
                                                    style="width: 120px; height: 40px; object-fit: contain;">

                                                    <p>................................</p>
                                                    <p>Marketing (Level-1)</p>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="text-center">
                                                    <p class="mb-1"><strong>Evaluated by</strong></p>
                                                    <img src="{{ asset('storage/signatures/DALkMhEBxMWLVkS6sKN8yMleQUozKbD7Ub4MpoAY.png') }}"
                                                    alt="Signature"
                                                    style="width: 120px; height: 40px; object-fit: contain;">
                                                    <p>................................</p>
                                                    <p>Marketing (Level-2)</p>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="text-center">
                                                    <p class="mb-1"><strong>Recommended by</strong></p>
                                                    <img src="{{ asset('storage/signatures/DALkMhEBxMWLVkS6sKN8yMleQUozKbD7Ub4MpoAY.png') }}"
                                                    alt="Signature"
                                                    style="width: 120px; height: 40px; object-fit: contain;">
                                                    <p>................................</p>
                                                    <p>Marketing (Level-3)</p>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div>
                            <table class="table table-sm table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-center">Designation</th>
                                        <th class="text-center">Comments</th>
                                        <th class="text-center">Action</th>
                                        <th class="text-center">Signature with date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="padding: 2px 8px;">
                                           <p class="fw-bold m-0">Assistant General Manager</p>
                                           <p style="font-size:11px;margin:0">Product Development</p>
                                        </td>
                                        <td style="padding: 2px 8px;"></td>
                                        <td style="padding: 2px 8px;"></td>
                                        <td class="text-center" style="padding: 2px 8px;">  <img src="{{ asset('storage/signatures/DALkMhEBxMWLVkS6sKN8yMleQUozKbD7Ub4MpoAY.png') }}"
                                                    alt="Signature"
                                                    style="width: 120px; height: 40px; object-fit: contain;"></td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 2px 8px;">
                                           <p class="fw-bold m-0">Assistant General Manager</p>
                                           <p style="font-size:11px;margin:0">Product Development</p>
                                        </td>
                                        <td style="padding: 2px 8px;"></td>
                                        <td style="padding: 2px 8px;"></td>
                                        <td class="text-center" style="padding: 2px 8px;">  <img src="{{ asset('storage/signatures/DALkMhEBxMWLVkS6sKN8yMleQUozKbD7Ub4MpoAY.png') }}"
                                                    alt="Signature"
                                                    style="width: 120px; height: 40px; object-fit: contain;"></td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 2px 8px;">
                                           <p class="fw-bold m-0">Assistant General Manager</p>
                                           <p style="font-size:11px;margin:0">Product Development</p>
                                        </td>
                                        <td style="padding: 2px 8px;"></td>
                                        <td style="padding: 2px 8px;"></td>
                                        <td class="text-center" style="padding: 2px 8px;">  <img src="{{ asset('storage/signatures/DALkMhEBxMWLVkS6sKN8yMleQUozKbD7Ub4MpoAY.png') }}"
                                                    alt="Signature"
                                                    style="width: 120px; height: 40px; object-fit: contain;"></td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 2px 8px;">
                                             <p class="fw-bold m-0">Assistant General Manager</p>
                                           <p style="font-size:11px;margin:0">Product Development</p>
                                        </td>
                                        <td style="padding: 2px 8px;"></td>
                                        <td style="padding: 2px 8px;"></td>
                                        <td class="text-center" style="padding: 2px 8px;">  <img src="{{ asset('storage/signatures/DALkMhEBxMWLVkS6sKN8yMleQUozKbD7Ub4MpoAY.png') }}"
                                                    alt="Signature"
                                                    style="width: 120px; height: 40px; object-fit: contain;"></td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 2px 8px;">
                                             <p class="fw-bold m-0">Assistant General Manager</p>
                                           <p style="font-size:11px;margin:0">Product Development</p>
                                        </td>
                                        <td style="padding: 2px 8px;"></td>
                                        <td style="padding: 2px 8px;"></td>
                                        <td class="text-center" style="padding: 2px 8px;">  <img src="{{ asset('storage/signatures/DALkMhEBxMWLVkS6sKN8yMleQUozKbD7Ub4MpoAY.png') }}"
                                                    alt="Signature"
                                                    style="width: 120px; height: 40px; object-fit: contain;"></td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 2px 8px;">
                                             <p class="fw-bold m-0">Assistant General Manager</p>
                                           <p style="font-size:11px;margin:0">Product Development</p>
                                        </td>
                                        <td style="padding: 2px 8px;"></td>
                                        <td style="padding: 2px 8px;"></td>
                                        <td class="text-center" style="padding: 2px 8px;">
                                        <img src="{{ asset('storage/signatures/DALkMhEBxMWLVkS6sKN8yMleQUozKbD7Ub4MpoAY.png') }}"
                                                    alt="Signature"
                                                    style="width: 120px; height: 40px; object-fit: contain;">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                <!-- end here -->
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