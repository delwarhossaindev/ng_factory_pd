<x-app-component>
    <x-page.page-title data="Add Proposal" />
    <x-slot name="style">
        <link rel="stylesheet" href="{{ asset('css/plugins.css') }}">
        <link rel="stylesheet" href="{{ asset('css/datatable.css') }}">
        <style>
            .typeahead-content {
                background-color: #fff;
                cursor: pointer;
                width: 100%;
                will-change: width, height
            }
            input.form-control {
                background: #f8f9fa;
            }
        </style>
    </x-slot>
    <x-slot name="content">
    <x-breadcrumb.breadcrumb-component firstLabel='Dashboard' firstLabelRoute='dashboard' secondLable='Proposal' secondLabelRoute='ng_factory_pd.index' currentPageText="Add Proposal" />
        <form action="{{ route('ng_factory_pd.store') }}" method="post" class="needs-validation mt-3" role="form" novalidate>
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-3 mt-3">
                                <label class="col-sm-2 col-form-label">New Product Category<span class="bg-red"> *</span></label>
                                <div class="col-sm-2">
                                    <div class="form-check form-check-flat form-check-primary">
                                        <input type="radio" class="form-check-input" name="ProductCategory" value="New Molecule" required>
                                        <label class="form-check-label">New Molecule</label>
                                    </div>

                                </div>
                                <div class="col-sm-2">

                                    <div class="form-check form-check-flat form-check-primary">
                                        <input type="radio" class="form-check-input" name="ProductCategory" value="Line Extension" required>
                                        <label class="form-check-label">Line Extension</label>
                                    </div>
                                </div>
                                <div class="col-sm-6"></div>


                                <label class="col-sm-2 col-form-label mt-3">Reference Status<span class="bg-red"> *</span></label>
                                <div class="col-sm-10 mt-3">
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <input type="checkbox" class="form-check-input" name="ReferenceStatus[]" value="FDA" >
                                            <label class="form-check-label">FDA</label>
                                        </div>
                                        <div class="col-sm-2">
                                            <input type="checkbox" class="form-check-input" name="ReferenceStatus[]" value="BNF">
                                            <label class="form-check-label">BNF</label>
                                        </div>
                                        <div class="col-sm-2">
                                            <input type="checkbox" class="form-check-input" name="ReferenceStatus[]" value="UKMHRA">
                                            <label class="form-check-label">UKMHRA</label>
                                        </div>

                                        <div class="col-sm-2">
                                            <input type="checkbox" class="form-check-input" name="ReferenceStatus[]" value="TGA">
                                            <label class="form-check-label">TGA</label>
                                        </div>

                                        <div class="col-sm-2">
                                            <input type="checkbox" class="form-check-input" name="ReferenceStatus[]" value="PMDA">
                                            <label class="form-check-label">PMDA</label>
                                        </div>

                                        <div class="col-sm-2">
                                            <input type="checkbox" class="form-check-input" name="ReferenceStatus[]" value="EMA">
                                            <label class="form-check-label">EMA</label>
                                        </div>

                                        <div class="col-sm-2">
                                            <input type="checkbox" class="form-check-input" name="ReferenceStatus[]" value="Others">
                                            <label class="form-check-label">Others</label>
                                        </div>

                                    </div>
                                </div>

                                <h5 class="col-sm-12 mt-3">A. GENERAL INFORMATION</h5>

                                <label class="col-sm-2 mt-3 col-form-label">Generic Name<span class="bg-red"> *</span></label>
                                <div class="col-sm-4 mt-3">
                                    <input type="text" class="form-control w-100 GenericName" name="GenericName" required>
                                </div>

                                <label class="col-sm-2 mt-3 col-form-label text-sm-end">Therapeutic Class<span class="bg-red"> *</span></label>
                                <div class="col-sm-4 mt-3">
                                    <input type="text" class="form-control w-100 TherapeuticClass" name="TherapeuticClass" required>
                                </div>

                                <label class="col-sm-2 col-form-label mt-3" for="Indication">Indication<span class="bg-red"> *</span></label>
                                <div class="col-sm-10 mt-3">
                                    <input type="text" class="form-control w-100 Indication" name="Indication" required>
                                </div>

                                <label class="col-sm-2 col-form-label mt-3" for="LocalCompetitors">Local Competitors<span class="bg-red"> *</span></label>
                                <div class="col-sm-4 mt-3">
                                    <input type="text" class="form-control w-100 LocalCompetitors" name="LocalCompetitors" required>
                                </div>

                                <label class="col-sm-2 mt-3 col-form-label text-sm-end" for="OriginatorBrand">Originator’s Brand<span class="bg-red"> *</span></label>
                                <div class="col-sm-4 mt-3">
                                    <input type="text" class="form-control w-100 OriginatorBrand" name="OriginatorBrand" required>
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
                                                <th class="text-center">Pack <br> Size</th>
                                                <th class="text-center">Primary Pack</th>
                                                <th class="text-center">IP or MRP <br>/Unit (Tk.)</th>
                                                <th class="text-center">IP or MRP <br>/Pack (Tk.)</th>
                                                <th class="text-center">TP/Pack<br>(Tk.)</th>
                                                <th class="text-center">DCC <br> Number</th>
                                                <th class="text-center">Availability in <br> BD</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="services"></tbody>
                                    </table>
                                    <button id="addRow" class="btn btn-sm btn-primary mt-2">Add More</button>
                                    <button id="addSync" class="btn btn-sm btn-success mt-2">Sync</button>
                                </div>

                                <h5 class="col-sm-12 mt-3">B.FORECAST</h5>

                                <div class="col-sm-12 card-body table-responsive">
                                    <table class="table table-sm table-bordered table-striped " style="width: 100%; table-layout: fixed;">
                                    <colgroup>
                                        <col style="width: 15%;"> <!-- Strength & Dosage Form -->
                                        <col style="width: 10%;"> <!-- Year-1 Unit -->
                                        <col style="width: 10%;"> <!-- Year-1 Value -->
                                        <col style="width: 10%;"> <!-- Year-2 Unit -->
                                        <col style="width: 10%;"> <!-- Year-2 Value -->
                                        <col style="width: 10%;"> <!-- Year-3 Unit -->
                                        <col style="width: 10%;"> <!-- Year-3 Value -->
                                        <col style="width: 10%;"> <!-- Launching Month -->
                                        <col style="width: 5%;">  <!-- Action -->
                                    </colgroup>
                                    <thead>
                                        <tr style="background: #e9ecef;">
                                                <th rowspan="2" class="text-center">Strength & Dosage Form</th>
                                                <th colspan="2" class="text-center">Year-1</th>
                                                <th colspan="2" class="text-center">Year-2</th>
                                                <th colspan="2" class="text-center">Year-3</th>
                                                <th rowspan="2" class="text-center">Launching <br> Month</th>
                                                <th rowspan="2" class="text-center">Action</th>
                                            </tr>
                                            <tr style="background: #e9ecef;">
                                                <th class="text-center">Unit</th>
                                                <th class="text-center">Value (M)</th>
                                                <th class="text-center">Unit</th>
                                                <th class="text-center">Value (M)</th>
                                                <th class="text-center">Unit</th>
                                                <th class="text-center">Value (M)</th>
                                            </tr>

                                        </thead>
                                        <tbody id="services2"></tbody>
                                    </table>
                                    <button id="addRow2" class="btn btn-sm btn-primary mt-2">Add More</button>
                                </div>

                                <br>

                                <div class="row">
                                <label class="col-sm-2 col-form-label mt-3" for="ForwardTo">Forward To<span class="bg-red"> *</span></label>
                                <div class="col-sm-4 mt-3">
                                   <select class="form-select" id="ForwardTo" name="ForwardTo" required>
                                        <option value="" disabled selected>Select Forward To </option>
                                        @foreach (\App\Models\User::all() as $item)
                                            <option value="{{ $item->UserID }}"  >{{ $item->UserName }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-6">

                                </div>

                                </div>

                                <div class="row ">
                                    <div class="col-sm-12 mt-3">
                                        <button type="submit" class="publish-post me-1" style="background: #f0c40f; color:#000">Save changes</button>
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
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function () {

                $("#addRow").click(function (event) {
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
                    $("#services").append(newRow);
                });



                $(document).on("click", ".removeRow", function () {
                    $(this).closest("tr").remove();
                });

                $("#addRow2").click(function (event) {
                    event.preventDefault();
                    var newRow = `<tr>
                        <td><input type="text" class="form-control" name="ServicesTwoStrength[]"></td>
                        <td><input type="number" class="form-control" name="Year1Unit[]"></td>
                        <td><input type="number" class="form-control" name="Year1Value[]"></td>
                        <td><input type="number" class="form-control" name="Year2Unit[]"></td>
                        <td><input type="number" class="form-control" name="Year2Value[]"></td>
                        <td><input type="number" class="form-control" name="Year3Unit[]"></td>
                        <td><input type="number" class="form-control" name="Year3Value[]"></td>
                        <td><input type="Month" class="form-control" name="LaunchingMonth[]"></td>
                        <td><button type="button" class="btn btn-danger btn-sm removeRow2">X</button></td>
                    </tr>`;
                    $("#services2").append(newRow);
                });

                $(document).on("click", ".removeRow2", function () {
                    $(this).closest("tr").remove();
                });

                $("#addSync").click(function (event) {
                event.preventDefault();

                var strengths = [];
                $('#services tr').each(function() {
                    var strength = $(this).find('input[name="ServicesOneStrength[]"]').val();
                    if (strength) {
                        strengths.push(strength);
                    }
                });


                strengths.forEach(function(strength) {

                    var exists = false;
                    $('#services2 tr').each(function() {
                        var existingStrength = $(this).find('input[name="ServicesTwoStrength[]"]').val();
                        if (existingStrength === strength) {
                            exists = true;
                            return false;
                        }
                    });

                    if (!exists) {
                        var newRow = `<tr>
                            <td><input type="text" class="form-control" name="ServicesTwoStrength[]" value="${strength}"></td>
                            <td><input type="number" class="form-control" name="Year1Unit[]"></td>
                            <td><input type="number" class="form-control" name="Year1Value[]"></td>
                            <td><input type="number" class="form-control" name="Year2Unit[]"></td>
                            <td><input type="number" class="form-control" name="Year2Value[]"></td>
                            <td><input type="number" class="form-control" name="Year3Unit[]"></td>
                            <td><input type="number" class="form-control" name="Year3Value[]"></td>
                            <td><input type="month" class="form-control" name="LaunchingMonth[]"></td>
                            <td><button type="button" class="btn btn-danger btn-sm removeRow2">X</button></td>
                        </tr>`;
                        $("#services2").append(newRow);
                    }
                });
            });


            });
        </script>
    </x-slot>
</x-app-component>
