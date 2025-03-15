<style>
    @media print {
        .table-responsive {
            overflow: visible !important;
        }
    }
</style>

<x-app-component>
    <x-page.page-title data="Credit Note Information" />
    <x-slot name="style">
        <link rel="stylesheet" href="{{ asset('css/print.css') }}">
    </x-slot>
    <x-slot name="content">
        <div class="card">
            <div class="card-body">

                <div class="row">
                    <div class="col-12">
                       
                        <button id="printButton" class="btn btn-info btn-outline-info btn-md">Print</button>
                    </div>
                </div>


                <div id="contentToPrint">

                

 <h5 class="text-center mb-1 mt-4"><strong>ACI Motors Limited</strong></h5>
    <p class="text-center">Credit Note Information</p>
    <div>
        <p class="mb-2"><b>Territory:</b> </p>
        <p class="mb-0"><b>Region:</b> </p>
    </div>
    <div class="table-responsive mt-3">
        <table class="table table-sm table-bordered motors_table">
            <thead class="text-center">
                <tr>
                    <th rowspan="2">Code No</th>
                    <th rowspan="2">Customer Full Name</th>
                    <th rowspan="2">Invoice Number</th>
                    <th rowspan="2">Invoice Date</th>
                    <th rowspan="2">Captured Date</th>
                    <th colspan="4">Credit Note Type/Information</th>
                </tr>
                <tr>
                    <th>Product Name</th>
                    <th>Qty(Units)</th>
                    <th>Unit Price(TK)</th>
                    <th>Value (TK)</th>
                </tr>
            </thead>
          
            <tbody>
               

            <tfoot>
                <tr>
                    <td colspan="7"></td>
                    <th colspan="2" class="text-center">Total Credit Amount</td>
                    <td class="text-end"></td>
                </tr>
            </tfoot>
        </table>
    </div>
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

</script>
