<x-app-component>
    <x-page.page-title data="Edit Proposal" />

    <x-slot name="style">
        <link rel="stylesheet" href="{{ asset('css/plugins.css') }}">
        <link rel="stylesheet" href="{{ asset('css/datatable.css') }}">
        <style>
            .typeahead-content {
                background-color: #fff;
                cursor: pointer;
                width: 100%;
                will-change: width, height;
            }

            input.form-control {
                background: #f8f9fa;
            }
        </style>
    </x-slot>

    <x-slot name="content">
    <x-breadcrumb.breadcrumb-component firstLabel='Dashboard' firstLabelRoute='dashboard' secondLable='Proposal' secondLabelRoute='ng_factory_pd.index' currentPageText="Edit Proposal" />

  
        <form action="{{ route('ng_factory_pd.update', $proposal->ProposalID) }}" method="POST" class="needs-validation mt-3" novalidate>
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-3 mt-3">
                                <!-- Product Category -->
                                <label class="col-sm-2 col-form-label">
                                    New Product Category <span class="bg-red">*</span>
                                </label>

                                <div class="col-sm-2">
                                <div class="form-check form-check-flat form-check-primary">
                                        <input type="radio" class="form-check-input" name="ProductCategory" value="New Molecule" 
                                            {{ $proposal->ProductCategory === 'New Molecule' ? 'checked' : '' }}>
                                        <label class="form-check-label">New Molecule</label>
                                    </div>
                                    
                                </div>
                                <div class="col-sm-2">
                                <div class="form-check form-check-flat form-check-primary">
                                        <input type="radio" class="form-check-input" name="ProductCategory" value="Line Extension" 
                                            {{ $proposal->ProductCategory === 'Line Extension' ? 'checked' : '' }}>
                                        <label class="form-check-label">Line Extension</label>
                                    </div>
                                </div>

                                <div class="col-sm-6"></div>

                                <!-- Reference Status -->
                                <label class="col-sm-2 col-form-label mt-3">
                                    Reference Status <span class="bg-red">*</span>
                                </label>
                                <div class="col-sm-10 mt-3">
                                    <div class="row">
                                        @php
                                            $referenceStatuses = ['FDA', 'BNF', 'UKMHRA', 'TGA', 'PMDA', 'EMA', 'Others'];
                                           
                                            $saveStatus = collect($proposal->referenceStatuses ?? [])->pluck('ReferenceStatus')->toArray();
                                        @endphp

                                        @foreach ($referenceStatuses as $status)
                                            <div class="col-sm-2">
                                                <input type="checkbox" class="form-check-input" name="ReferenceStatus[]" value="{{ $status }}" 
                                                    {{ in_array($status, $saveStatus) ? 'checked' : '' }}>
                                                <label class="form-check-label">{{ $status }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <h5 class="col-sm-12 mt-3">A. GENERAL INFORMATION</h5>


                                <label class="col-sm-2 mt-3 col-form-label">Generic Name<span class="bg-red"> *</span></label>
                                <div class="col-sm-4 mt-3">
                                    <input type="text" class="form-control w-100 GenericName" name="GenericName" value="{{ $proposal->generalInfo->GenericName }}" >
                                </div>
                                
                                <label class="col-sm-2 mt-3 col-form-label text-sm-end">Therapeutic Class<span class="bg-red"> *</span></label>
                                <div class="col-sm-4 mt-3">
                                    <input type="text" class="form-control w-100 TherapeuticClass" name="TherapeuticClass" value="{{ $proposal->generalInfo->TherapeuticClass }}" >
                                </div>

                                <label class="col-sm-2 col-form-label mt-3" for="Indication">Indication<span class="bg-red"> *</span></label>
                                <div class="col-sm-10 mt-3">
                                    <input type="text" class="form-control w-100 Indication" name="Indication" value="{{ $proposal->generalInfo->Indication }}"  >
                                </div>
                                <label class="col-sm-2 col-form-label mt-3" for="LocalCompetitors">Local Competitors<span class="bg-red"> *</span></label>
                                <div class="col-sm-4 mt-3">
                                    <input type="text" class="form-control w-100 LocalCompetitors" name="LocalCompetitors" value="{{ $proposal->generalInfo->LocalCompetitors }}" >
                                </div>
                                <label class="col-sm-2 mt-3 col-form-label text-sm-end" for="OriginatorBrand">Originator’s Brand<span class="bg-red"> *</span></label>
                                <div class="col-sm-4 mt-3">
                                    <input type="text" class="form-control w-100 OriginatorBrand" name="OriginatorBrand" value="{{ $proposal->generalInfo->OriginatorBrand }}" >
                                </div>



                                <div class="col-sm-12 card-body table-responsive">
                                    <table class="table table-sm table-bordered table-striped mt-3" style="width: 100%; table-layout: fixed;">
                                    <colgroup>
                                        <col style="width: 18%;">
                                        <col style="width: 6%;">
                                        <col style="width: 12%;">
                                        <col style="width: 10%;">
                                        <col style="width: 12%;">
                                        <col style="width: 12%;">
                                        <col style="width: 12%;">
                                        <col style="width: 12%;">
                                        <col style="width: 6%;">
                                    </colgroup>
                                    <thead>
                                            <tr style="background: #e9ecef;">
                                                <th class="text-center">Strength & Dosage Form</th>
                                                <th class="text-center">Pack Size</th>
                                                <th class="text-center">Primary Pack</th>
                                                <th class="text-center">MRP/Unit (Tk.)</th>
                                                <th class="text-center">MRP/Pack (Tk.)</th>
                                                <th class="text-center">TP/Pack(Tk.)</th>
                                                <th class="text-center">DCC Number</th>
                                                <th class="text-center">Availability in BD</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="services2">
                                            @foreach ($proposal->generalInfo->details as $service)
                                                <tr>
                                                    <td><input type="text" class="form-control" name="ServicesOneStrength[]" value="{{ $service->StrengthDosageForm }}"></td>
                                                    <td><input type="number" class="form-control" name="PackSize[]" value="{{ $service->PackSize }}"></td>
                                                    <td><input type="number" class="form-control" name="PrimaryPack[]" value="{{ $service->PrimaryPack }}"></td>
                                                    <td><input type="number" class="form-control" name="MRPUnit[]" value="{{ $service->MRPUnit }}"></td>
                                                    <td><input type="number" class="form-control" name="MRPPack[]" value="{{ $service->MRPPack }}"></td>
                                                    <td><input type="number" class="form-control" name="TP[]" value="{{ $service->TP }}"></td>
                                                    <td><input type="text" class="form-control" name="DCCNumber[]" value="{{ $service->DCCNumber }}"></td>
                                                    <td><input type="text" class="form-control" name="Availability[]" value="{{ $service->Availability }}"></td>
                                                    <td><button type="button" class="btn btn-danger btn-sm removeRow">X</button></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        
                                    </table>
                                    <button id="addRow2" class="btn btn-sm btn-primary mt-2">Add More</button>
                                </div>


                                <h5 class="col-sm-12 mt-3">B. FORECAST</h5>

                                <!-- Editable Forecast Table -->
                                <div class="col-sm-12 card-body table-responsive">
                                    <table class="table table-sm table-bordered table-striped">
                                        <thead>
                                            <tr style="background: #e9ecef;">
                                                <th class="text-center">Strength & Dosage Form</th>
                                                <th class="text-center">Year-1 Unit</th>
                                                <th class="text-center">Year-1 Value</th>
                                                <th class="text-center">Year-2 Unit</th>
                                                <th class="text-center">Year-2 Value</th>
                                                <th class="text-center">Year-3 Unit</th>
                                                <th class="text-center">Year-3 Value</th>
                                                <th class="text-center">Launching Month</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="forecastTable">
                                            @foreach ($proposal->forecasts as $forecast)
                                                <tr>
                                                    <td><input type="text" class="form-control" name="ServicesTwoStrength[]" value="{{ $forecast->StrengthDosageForm }}"></td>
                                                    <td><input type="number" class="form-control" name="Year1Unit[]" value="{{ $forecast->Year1Unit }}"></td>
                                                    <td><input type="number" class="form-control" name="Year1Value[]" value="{{ $forecast->Year1Value }}"></td>
                                                    <td><input type="number" class="form-control" name="Year2Unit[]" value="{{ $forecast->Year2Unit }}"></td>
                                                    <td><input type="number" class="form-control" name="Year2Value[]" value="{{ $forecast->Year2Value }}"></td>
                                                    <td><input type="number" class="form-control" name="Year3Unit[]" value="{{ $forecast->Year3Unit }}"></td>
                                                    <td><input type="number" class="form-control" name="Year3Value[]" value="{{ $forecast->Year3Value }}"></td>
                                                    <td><input type="month" class="form-control" name="LaunchingMonth[]" value="{{ $forecast->LaunchingMonth }}"></td>
                                                    <td><button type="button" class="btn btn-danger btn-sm removeRow">X</button></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <button id="addRow" class="btn btn-sm btn-primary mt-2">Add More</button>
                                </div>

                                <br>

                           

                                @if ($proposal->PresentDesk==auth()->user()->UserID)
                                   
                                <div class="row">
                                    <label class="col-sm-2 col-form-label mt-3" for="ForwardTo">Forward To<span class="bg-red"> *</span></label>
                                    <div class="col-sm-4 mt-3">
                                    <select class="form-select" id="ForwardTo" name="ForwardTo" required>
                                        <option value="" disabled selected>Select Forward To</option>
                                        @foreach (\App\Models\User::all() as $item)
                                            <option value="{{ $item->UserID }}" {{ $proposal->EvaluatedBy == $item->UserID ? 'selected' : '' }}>
                                                {{ $item->UserName }}
                                            </option>
                                        @endforeach
                                    </select>
                                    </div>
                                    <div class="col-sm-6">
                                        
                                    </div>
                                    </div>
                                @endif

                               

                                <div class="row">
                                    <div class="col-sm-12 mt-3">
                                        <button type="submit" class="publish-post me-1" style="background: #f0c40f; color:#000">Update</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </x-slot>

    <x-slot name="script">
        <script src="{{ asset('js/plugins.js') }}"></script>
        <script src="{{ asset('js/datatable.js') }}"></script>
        <script>
            $(document).ready(function () {
                $("#addRow").click(function (event) {
                    event.preventDefault();
                    $("#forecastTable").append(`
                        <tr>
                            <td><input type="text" class="form-control" name="ServicesTwoStrength[]"></td>
                            <td><input type="number" class="form-control" name="Year1Unit[]"></td>
                            <td><input type="number" class="form-control" name="Year1Value[]"></td>
                            <td><input type="number" class="form-control" name="Year2Unit[]"></td>
                            <td><input type="number" class="form-control" name="Year2Value[]"></td>
                            <td><input type="number" class="form-control" name="Year3Unit[]"></td>
                            <td><input type="number" class="form-control" name="Year3Value[]"></td>
                            <td><input type="month" class="form-control" name="LaunchingMonth[]"></td>
                            <td><button type="button" class="btn btn-danger btn-sm removeRow">X</button></td>
                        </tr>`);
                });

                $(document).on("click", ".removeRow", function () {
                    $(this).closest("tr").remove();
                });

                $("#addRow2").click(function (event) {
                    event.preventDefault();
                    var newRow = `<tr>
                        <td><input type="text" class="form-control" name="ServicesOneStrength[]"></td>
                        <td><input type="text" class="form-control" name="PackSize[]"></td>
                        <td><input type="text" class="form-control" name="PrimaryPack[]"></td>
                        <td><input type="number" class="form-control" name="MRPUnit[]"></td>
                        <td><input type="number" class="form-control" name="MRPPack[]"></td>
                        <td><input type="number" class="form-control" name="TP[]"></td>
                        <td><input type="text" class="form-control" name="DCCNumber[]"></td>
                        <td><input type="text" class="form-control" name="Availability[]"></td>
                        <td><button type="button" class="btn btn-danger btn-sm removeRow">X</button></td>
                    </tr>`;
                    $("#services2").append(newRow);
                });

                $(document).on("click", ".removeRow2", function () {
                    $(this).closest("tr").remove();
                });



            });
        </script>
    </x-slot>
</x-app-component>
