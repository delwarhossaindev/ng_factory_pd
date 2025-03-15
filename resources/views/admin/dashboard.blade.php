<x-app-component>
    <x-page.page-title data="Dashboard" />
    <x-slot name="style">
        <link rel="stylesheet" href="{{ asset('css/plugins.css') }}" />
        <style>
            #overlay{position:fixed;top:0;left:0;z-index:100000;width:100%;height:100%;display:none;background:rgba(0,0,0,.6)}.cv-spinner{height:100%;display:flex;justify-content:center;align-items:center}.spinner{width:40px;height:40px;border:4px solid #ddd;border-top:4px solid #2e93e6;border-radius:50%;animation:.8s linear infinite sp-anime}@keyframes sp-anime{100%{transform:rotate(360deg)}}.is-hide{display:none}
        </style>
    </x-slot>
    <x-slot name="content">
        <div
            class="d-flex flex-column flex-md-row justify-content-md-between align-items-md-center py-2 text-center text-md-start">
            <div class="flex-grow-1 mb-2">
                <h1 class="h3 fw-bold mb-2">Dashboard</h1>
                <h2 class="h6 fw-medium fw-medium text-muted mb-0"> Welcome {{ auth()->user()->UserName }}, everything looks great. </h2>
            </div>
            {{-- <form action="" id="filter-form">
                <div class="filter-data float-end mt-2 d-flex">
                    <input name="date" type="text" id="reportrange" class="filter-date-ranger">
                </div>
            </form> --}}
        </div>
        {{-- <div class="row data-row">
            @include('admin.dashboard._html')
        </div>
        <div id="overlay">
            <div class="cv-spinner">
              <span class="spinner"></span>
            </div>
        </div> --}}
    </x-slot>
    <x-slot name="script">
        <script src="{{ asset('js/plugins.js') }}"></script>
        <script>
            $('body').on('change', '#reportrange', e => {
                const data = $('#filter-form').serialize();
                const base_url = window.location.href;
                $.ajax({
                    type: 'GET',
                    url: base_url,
                    data:{'filterColumn' : data},
                    beforeSend: function() {$("#overlay").fadeIn();},
                    success: function(response) {
                        $('.data-row').html(response);
                    },
                    complete: function(response) {$("#overlay").fadeOut();}
                });
            });
        </script>
    </x-slot>
</x-app-component>
