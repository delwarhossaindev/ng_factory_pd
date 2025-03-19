
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
                                <th>ProductCategory</th>
                                <th>GenericName</th>
                                <th>TherapeuticClass</th>
                                <th>Indication</th>
                                <th>LocalCompetitors</th>
                                <th>OriginatorBrand</th>

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
        @include('admin.modal._export', ['db_table' => 'NGFactoryPDNew'])
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
        ajax: "{{ route('ng_factory_pd.approved_submission_list') }}",
        columns: [
            {data: 'ProductCategory', name: 'ProductCategory'},
            {data: 'GenericName', name: 'GenericName'},
            {data: 'TherapeuticClass', name: 'TherapeuticClass'},
            {data: 'Indication', name: 'Indication'},
            {data: 'LocalCompetitors', name: 'LocalCompetitors'},
            {data: 'OriginatorBrand', name: 'OriginatorBrand'},
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }
        ]
    });
});

$(document).on('click', '.delete-btn', function () {
    let id = $(this).data('id');

    if (confirm('Are you sure you want to delete this record?')) {
        $.ajax({
            url: "{{ route('ng_factory_pd.destroy', '') }}/" + id, // ✅ Corrected route
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                alert('Record deleted successfully!');
                $('.data-table').DataTable().ajax.reload(); // ✅ Reload DataTable
            },
            error: function (xhr) {
                alert('Something went wrong!');
            }
        });
    }
});

        </script>
    </x-slot>
</x-app-component>

