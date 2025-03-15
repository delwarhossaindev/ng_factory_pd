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
                                <th><input type="checkbox" id="select-all"></th>
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
                        <tbody></tbody>
                    </table>
                </div> <!-- End table-responsive -->

                <!-- Submit Button -->
                <button id="submitselected" class="btn btn-primary mt-3">Submit Selected</button>
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
            $(function() {
                var table = $('.data-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('credit_note_approval.request_for_approval') }}",
                    columns: [
                        {
                            data: 'CodeNo',
                            name: 'CodeNo',
                            orderable: false,
                            searchable: false,
                            render: function(data) {
                                return '<input type="checkbox" class="row-select" value="' + data + '">';
                            }
                        },
                        { data: 'CodeNo', name: 'CodeNo' },
                        { data: 'CustomerCode', name: 'CustomerCode' },
                        { data: 'CustomerName', name: 'CustomerName' },
                        { data: 'InvoiceNo', name: 'InvoiceNo' },
                        { data: 'DeliveryDate', name: 'DeliveryDate' },
                        { data: 'Territory', name: 'Territory' },
                        { data: 'Area', name: 'Area' },
                        { data: 'Region', name: 'Region' },
                        { data: 'status', name: 'status' },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        }
                    ]
                });

                // Select all checkbox
                $('#select-all').on('click', function() {
                    $('.row-select').prop('checked', this.checked);
                });

                // Handle submit button click
                $('#submitselected').on('click', function() {
                    var selectedIds = [];
                    $('.row-select:checked').each(function() {
                        selectedIds.push($(this).val());
                    });

                    // Debugging check for selected IDs
                    console.log(selectedIds);

                    if (selectedIds.length > 0) {
                        $.ajax({
                            url: "{{ route('credit_note_approval.submit_selected') }}",
                            method: 'POST',
                            data: {
                                ids: selectedIds,
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                alert('Data submitted successfully!');
                                table.ajax.reload(); // Reload DataTable
                            },
                            error: function(error) {
                                alert('An error occurred. Please try again.');
                            }
                        });
                    } else {
                        alert('Please select at least one row.');
                    }
                });
            });
        </script>
    </x-slot>
</x-app-component>
