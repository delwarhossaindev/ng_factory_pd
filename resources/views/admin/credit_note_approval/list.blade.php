<style>
    @media print {
        .table-responsive {
            overflow: visible !important;
        }
    }
</style>
@php
    $level2 = \DB::select("select Distinct UserID,UserName From UserManager Where Level='Level2'");
@endphp
<x-app-component>
    <x-page.page-title data="Credit Note Information" />
    <x-slot name="style">
        <link rel="stylesheet" href="{{ asset('css/print.css') }}">
    </x-slot>
    <x-slot name="content">
        <div class="card">
            <div class="card-body">

                <div class="row">
                    <div class="col-2">
                        <div class="d-flex align-items-center">
                            <label class="col-form-label me-2" for="fromDate">From</label>
                            <input type="date" class="form-control fromDate" name="fromDate"
                                style="background: #ffffff;">
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="d-flex align-items-center">
                            <label class="col-form-label me-2" for="toDate">To</label>
                            <input type="date" class="form-control toDate" name="toDate"
                                style="background: #ffffff;">
                        </div>
                    </div>
                    <div class="col-2 d-flex align-items-center">
                        <label class="col-form-label me-2" for="level2">Showroom</label>
                        <select class="form-control w-100 level2" name="level2" style="background: #ffffff;" required>
                            <option value="">Select Showroom</option>
                            @foreach ($level2 as $obj)
                                <option value="{{ $obj->UserID }}">{{ $obj->UserName }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6">
                        <button id="submitButton" class="btn btn-info btn-outline-info btn-md">Submit</button>
                        <button id="printButton" class="btn btn-info btn-outline-info btn-md">Print</button>
                    </div>
                </div>


                <div id="contentToPrint">
                </div>
            </div>
        </div>
    </x-slot>
</x-app-component>

<script>
    // Function to print specific div content
    function printDivContent(divId) {
        var divContent = document.getElementById(divId).innerHTML;
        var originalContent = document.body.innerHTML;

        document.body.innerHTML = divContent;
        window.print();
        document.body.innerHTML = originalContent;
        location.reload();
    }

    // Add event listener to the button to call printDivContent function on click
    document.getElementById('printButton').addEventListener('click', function() {
        printDivContent('contentToPrint');
    });

    document.getElementById('submitButton').addEventListener('click', function() {
        loadData();
    });

    function loadData() {
        var fromDate = document.querySelector('.fromDate').value;
        var toDate = document.querySelector('.toDate').value;
        var level2 = document.querySelector('.level2').value;

        if (fromDate === "") {
            alert("Please select a From Date.");
            return;
        }

        if (toDate === "") {
            alert("Please select a To Date.");
            return;
        }

        if (level2 === "") {
            alert("Please select a showroom.");
            return;
        }


        var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        var datastring = `Level2=${level2}&ToDate=${toDate}&FromDate=${fromDate}&_token=${CSRF_TOKEN}`;
        console.log(datastring);


        // Make your AJAX call or any other processing with datastring
        $.ajax({
            type: 'GET',
            url: "{{ route('credit_note_approval.list') }}",
            data: datastring,
            success: function(response) {

                console.log(response);
                $('#contentToPrint').html(response);

            },
        });
    }
</script>
