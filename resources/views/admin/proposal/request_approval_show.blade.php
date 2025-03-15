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
                    font-size: 7px;
                }
                .card {
                    page-break-inside: avoid;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                }
                th, td {
                    border: 1px solid #000;
                    padding: 5px;
                    text-align: center;
                }
                h5 {
                    font-size: 16px;
                    font-weight: bold;
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
                <div id="contentToPrint">
                    <h5 class="mt-4 d-flex align-items-center">
                        <img src="{{ asset('aci-logo.png') }}" alt="ACI Logo" class="me-2" style="height: 40px;">
                        <strong>Advanced Chemical Industries Limited</strong>
                    </h5>

                    <div>
                        <p class="mb-2"><b>New Product Category : </b>{{ $proposal->ProductCategory }} </p>
                        <p class="mb-0"><b>Reference Status : </b> {{ implode(', ',  $saveStatus) }}</p>
                    </div>

                    <br>
                    <h5>A. GENERAL INFORMATION</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-2"><b>Generic Name : </b> {{ $proposal->generalInfo->GenericName }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-2"><b>Therapeutic Class : </b> {{ $proposal->generalInfo->TherapeuticClass }}</p>
                        </div>
                        <div class="col-md-12">
                            <p class="mb-2"><b>Indication : </b> {{ $proposal->generalInfo->Indication }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-2"><b>Local Competitors : </b> {{ $proposal->generalInfo->LocalCompetitors }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-2"><b>Originator’s Brand : </b> {{ $proposal->generalInfo->OriginatorBrand }}</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 card-body table-responsive">
                            <table class="table table-sm table-bordered motors_table">
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
                            <table class="table table-sm table-bordered motors_table">
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
                                                    <td >{{ $forecast->StrengthDosageForm }}</td>
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

                    <form action="{{ route('proposal.request_approval_store') }}" method="post" class="needs-validation mt-3" role="form" novalidate>
                      @csrf
                                <div class="row">
                                <input type="hidden" name="ProposalID" value="{{ $proposal->ProposalID }}">


                                @if (!($proposal->RecommendedBy == auth()->id()))
                                <label class="col-sm-2 col-form-label mt-3" for="ForwardTo">Forward To<span class="bg-red"> *</span></label>
                                <div class="col-sm-4 mt-3">
                                    <select class="form-select" id="ForwardTo" name="ForwardTo" required>
                                         <option value="" disabled selected>Select Forward To </option>
                                         @foreach (\App\Models\User::all() as $item)
                                             <option value="{{ $item->UserID }}"  >{{ $item->UserName }}</option>
                                         @endforeach
                                     </select>
                                 </div>
                                @else

                                <label class="col-sm-2 col-form-label mt-3" for="ForwardTo">Recommended By<span class="bg-red"> *</span></label>

                                <div class="col-sm-4 mt-3">{{ auth()->user()->UserName }}</div>

                                @endif

                                <div class="col-sm-6"></div>

                                <label class="col-sm-2 col-form-label mt-3" for="Status">Status<span class="bg-red"> *</span></label>
                                <div class="col-sm-4 mt-3">
                                   <select class="form-select" id="Status" name="Status" required>
                                        <option value="Approved" >Approved</option>
                                        <option value="Declined" >Declined</option>
                                    </select>
                                </div>
                                <div class="col-sm-6">

                                </div>
                                </div>
                                 <div class="row ">
                                    <div class="col-sm-12 mt-3">
                                        <button type="submit" class="publish-post me-1" style="background: #f0c40f; color:#000">Submit</button>
                                    </div>
                                </div>
                    </form>

                </div>
            </div>
        </div>
    </x-slot>
</x-app-component>

<script>



</script>
