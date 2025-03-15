<div id="dialog-form" title="Update Permission" tabindex="-1" style="display: none;">
    <small class="py-0"><span class="bg-red"> *</span> Indicates mandatory fields</small>
    <form action="{{ route('permission.update', $permission->id) }}" method="post" class="needs-validation"
        role="form" novalidate>
        @csrf
        @method('patch')
        @include('admin.permission.modal._input')
    </form>
</div>
