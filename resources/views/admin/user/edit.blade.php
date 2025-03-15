<x-app-component>
    <x-page.page-title data="Update User" />
    <x-slot name="style">
        <link rel="stylesheet" href="{{ asset('css/plugins.css') }}">
        <link rel="stylesheet" href="{{ asset('css/datatable.css') }}">
    </x-slot>
    <x-slot name="content">
        <x-breadcrumb.breadcrumb-component firstLabel='Dashboard' firstLabelRoute='dashboard' secondLable='User'
            secondLabelRoute='user.index' currentPageText="Update user" />
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <form action="{{ route('user.update',$user->UserID) }}" method="post" class="needs-validation"
                    role="form" enctype="multipart/form-data" novalidate>
                    @csrf
                    @method('patch')
                    <div class="nav-align-top mb-4">
                        <div class="tab-content">
                            <div class="tab-pane fade active show" id="navs-justified-home" role="tabpanel">
                                @include('admin.user.tab.personal')
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-3"></div>
        </div>
    </x-slot>
    <x-slot name="script">
        <script src="{{ asset('js/plugins.js') }}"></script>
        <script src="{{ asset('js/datatable.js') }}"></script>
    </x-slot>
</x-app-component>
