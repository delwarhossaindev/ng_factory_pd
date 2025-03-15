<div id="dialog-form" title="Add New Role" tabindex="-1" style="display: none;">
    <small class="py-0"><span class="bg-red"> *</span> Indicates mandatory fields</small>
    <form action="{{ route('role.store') }}" method="post" class="needs-validation" role="form" novalidate>
        @csrf
        @include('admin.role.modal._input')
    </form>
</div>