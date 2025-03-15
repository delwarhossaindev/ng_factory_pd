<x-app-component>
    <x-page.page-title data="Add User" />
    <x-slot name="style">
        <link rel="stylesheet" href="{{ asset('css/plugins.css') }}">
        <link rel="stylesheet" href="{{ asset('css/datatable.css') }}">
    </x-slot>
    <x-slot name="content">        
        <x-breadcrumb.breadcrumb-component firstLabel='Dashboard' firstLabelRoute='dashboard' secondLable='User'
            secondLabelRoute='user.index' currentPageText="Add user" />
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <form action="{{ route('user.store') }}" method="post" class="needs-validation" role="form"
                    enctype="multipart/form-data" novalidate>
                    @csrf
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
        <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/intlTelInput.min.js"></script>
        <script>
            $(".radio").checkboxradio();
            var input = document.querySelector("#mobile_number");
            var countryData = window.intlTelInputGlobals.getCountryData();
            window.intlTelInput(input, {
                utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/utils.js",
                initialCountry: "bd",
                separateDialCode: true,
                customPlaceholder: function(selectedCountryPlaceholder, selectedCountryData) {
                    $('#iso2').val(selectedCountryData.iso2);
                    $('#dial_code').val(selectedCountryData.dialCode);
                    return selectedCountryPlaceholder;
                }
            });
        </script>
    </x-slot>
</x-app-component>
