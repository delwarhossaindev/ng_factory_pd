<x-app-component>
    <x-page.page-title data="Permission" />
    <x-slot name="style">
        <link rel="stylesheet" href="{{ mix('css/datatable.css') }}" />
    </x-slot>>
    <x-slot name="content">
        <x-button.create-new-modal title="Permission" buttonText="Add New" permalink="" permission="create-permission"/>
        <div class="card mt-3">
            <div class="card-body">
                {{ generate_table_columns(['name', 'display name', 'description', 'action']) }}
            </div>
        </div>
        @include('admin.permission.modal._create')
        @include('admin.modal._export', ['db_table' => 'permissions'])
    </x-slot>
    <x-slot name="script">
        <script src="{{ mix('js/datatable.js') }}"></script>
        <script>
            const columns = ['id', 'name', 'display_name', 'description'];
            const order = "asc";
            const route = "{{ route('permission.index') }}";
            const button = true;
            const table = 'Permission';
            const deleteButtonText = "Delete";
            generate_datatable(route, columns, order, button, deleteButtonText, table);
        </script>
    </x-slot>
</x-app-component>
