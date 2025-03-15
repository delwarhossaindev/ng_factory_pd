<x-app-component>
    <!-- Page Title -->
    <x-page.page-title data="My Submitted List" />

    <!-- Styles -->
    <x-slot name="style">
        <link rel="stylesheet" href="{{ asset('css/datatable.css') }}" />
        <link rel="stylesheet" href="{{ asset('css/plugins.css') }}" />
    </x-slot>

    <!-- Content -->
    <x-slot name="content">
        <div class="card">
            <div class="card-body">
                <!-- Add a wrapper for responsive table -->
                <div class="table-responsive">
                    <!-- DataTable Structure -->
                    <table class="table table-bordered data-table">
                        <thead>
                            <tr>
                                <th>Code No</th>
                                <th>C. Code</th>
                                <th>C. Name</th>
                                <th>Invoice No</th>
                                <th>Delivery Date</th>
                                <th>Territory</th>
                                <th>Area</th>
                                <th>Region</th>
                                <th>Status</th>
                                <th width="100px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div> <!-- End table-responsive -->
            </div>
        </div>
        <!-- Include Modal for Export -->
        @include('admin.modal._export', ['db_table' => 'CreditNoteApproval'])
    </x-slot>

    <!-- Scripts -->
    <x-slot name="script">
        <script src="{{ asset('js/datatable.js') }}"></script>
        <script src="{{ asset('js/plugins.js') }}"></script>
        <script type="text/javascript">
            $(function () {
                var table = $('.data-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('credit_note_approval.approved_submission_list') }}",
                    columns: [
                        {data: 'CodeNo', name: 'CodeNo'},
                        {data: 'CustomerCode', name: 'CustomerCode'},
                        {data: 'CustomerName', name: 'CustomerName'},
                        {data: 'InvoiceNo', name: 'InvoiceNo'},
                        {data: 'DeliveryDate', name: 'DeliveryDate'},
                        {data: 'Territory', name: 'Territory'},
                        {data: 'Area', name: 'Area'},
                        {data: 'Region', name: 'Region'},
                        {data: 'status', name: 'status'},
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        }
                    ]
                });
            });
        </script>
    </x-slot>
</x-app-component>







