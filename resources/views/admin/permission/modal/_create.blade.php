<div id="dialog-form" title="Add New Permission" tabindex="-1" style="display: none;">
    <small class="py-0"><span class="bg-red"> *</span> Indicates mandatory fields</small>
    <form action="{{ route('permission.store') }}" method="post" class="needs-validation" role="form" novalidate>
        @csrf
        @include('admin.permission.modal._input')
    </form>
</div>
