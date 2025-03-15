<div id="dialog-form" title="Update Role" tabindex="-1" style="display: none;">
    <small class="py-0"><span class="bg-red"> *</span> Indicates mandatory fields</small>
    <form action="{{ route('role.update', $role->id) }}" method="post" class="needs-validation" role="form"
        novalidate>
        @csrf
        @method('patch')
        @include('admin.role.modal._input')
    </form>
</div>