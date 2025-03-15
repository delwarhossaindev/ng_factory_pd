<x-app-component>
    <x-page.page-title data="NG Factory PD List" />
    <x-slot name="style">
        <link rel="stylesheet" href="{{ asset('css/datatable.css') }}" />
        <link rel="stylesheet" href="{{ asset('css/plugins.css') }}" />
    </x-slot>
    <x-slot name="content">
        <x-button.create-new-anchor title="Approval" buttonText="Add New" permalink="credit_note_approval.create" permission="HQ" />
        <form action="" class="filter-form">
            <div class="row">
                <div class="col">
                    <ul class="d-inline-block mb-0">
                        <li>All
                            <b class="text-black">({{ $cnp->all }})</b>&nbsp;|
                        </li>
                        <li class="text-primary">Today
                            <b class="text-black">({{ $cnp->today }})</b>
                        </li>
                        <li class="text-primary">Yesterday
                            <b class="text-black">({{ $cnp->yesterday }})</b>
                        </li>
                    </ul>
                    <div class="filter-data float-end d-flex">
                        <input name="date" type="text" id="reportrange" class="filter-date-ranger me-1">
                        <button type="button"
                            class="ui-button ui-corner-all ui-widget text-primary filter-row">Filter</button>
                    </div>
                </div>
            </div>
        </form>
        <div class="card">
            <div class="card-body">
                {{ generate_table_columns(['Code No', 'Raised By', 'Customer Code','Customer Name', 'Invoice No','Delivery Date','Capture Date','Rotavator Model','Territory','Area','Region','Remarks','action']) }}
            </div>
        </div>
        @include('admin.modal._export', ['db_table' => 'CreditNoteApproval'])
    </x-slot>
    <x-slot name="script">
        <script src="{{ asset('js/datatable.js') }}"></script>
        <script src="{{ asset('js/plugins.js') }}"></script>
        <script type="text/javascript">
            const columns = ['CodeNo','CodeNo', 'CreatedBy', 'CustomerCode', 'CustomerName', 'InvoiceNo','DeliveryDate','CaptureDate','RotavatorModel','Territory','Area','Region','Remarks'];
            const route = "{{ route('credit_note_approval.index') }}";
            const order = "asc";
            const button = true;
            const table = 'CreditNoteApproval';
            const deleteButtonText = "Delete";
            generate_datatable(route, columns, order, button, deleteButtonText, table );
        </script>
    </x-slot>
</x-app-component>
