<x-app-component>
    <x-page.page-title data="User List" />
    <x-slot name="style">
        <link rel="stylesheet" href="{{ asset('css/datatable.css') }}" />
        <link rel="stylesheet" href="{{ asset('css/plugins.css') }}" />
    </x-slot>
    <x-slot name="content">
        <x-button.create-new-anchor title="User" buttonText="Add New" permalink="user.create" permission="HQ" />
        <form action="" class="filter-form">
            <div class="row">
                <div class="col">
                    <ul class="d-inline-block mb-0">
                        <li>All
                            <b class="text-black">({{ $vuser->all_user }})</b>&nbsp;|
                        </li>
                        <li class="text-primary">MO
                            <b class="text-black">({{ $vuser->user_active }})</b>
                        </li>
                        <li class="text-primary">RSM
                            <b class="text-black">({{ $vuser->user_inactive }})</b>&nbsp;|
                        </li>
                        <li>AH<b class="text-black">({{ $vuser->trash_user }})</b>&nbsp;</li>
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
                {{ generate_table_columns(['User ID', 'Username', 'Supervisor', 'Level', 'action']) }}
            </div>
        </div>
        @include('admin.modal._export', ['db_table' => 'UserManager'])
    </x-slot>
    <x-slot name="script">
        <script src="{{ asset('js/datatable.js') }}"></script>
        <script src="{{ asset('js/plugins.js') }}"></script>
        <script type="text/javascript">
            const columns = ['UserID', 'UserID', 'UserName', 'SupervisorID', 'Level'];
            const route = "{{ route('user.index') }}";
            const order = "asc";
            const button = true;
            const table = 'User';
            const deleteButtonText = "Delete";
            generate_datatable(route, columns, order, button, deleteButtonText, table );
        </script>
    </x-slot>
</x-app-component>
