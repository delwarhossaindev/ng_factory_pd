<x-app-component>
    <x-page.page-title data="Settings" />
    <x-slot name="style">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/css/bootstrap-select.min.css">
    </x-slot>
    <x-slot name="content">
        <h4 class="fw-bold">System Settings</h4>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="nav-align-top mb-4">
                    <ul class="nav nav-tabs nav-fill" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                data-bs-target="#navs-justified-home" aria-controls="navs-justified-home"
                                aria-selected="true"><i class="tf-icons bx bx-message me-1"></i>Mail</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                data-bs-target="#navs-justified-profile" aria-controls="navs-justified-profile"
                                aria-selected="false" tabindex="-1"><i class="tf-icons bx bx-cog me-1"></i>
                                Settings</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                data-bs-target="#navs-justified-messages" aria-controls="navs-justified-messages"
                                aria-selected="false" tabindex="-1"><i class="tf-icons bx bxs-data me-1"></i>
                                Backup</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                data-bs-target="#navs-justified-cache" aria-controls="navs-justified-cache"
                                aria-selected="false" tabindex="-1"><i class="tf-icons bx bxs-baby-carriage me-1"></i>
                                Cache</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                data-bs-target="#navs-justified-website" aria-controls="navs-justified-website"
                                aria-selected="false" tabindex="-1"><i class="tf-icons bx bxl-google-cloud me-1"></i>
                                Website</button>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="navs-justified-home" role="tabpanel">
                            @include('admin.settings.form.env')
                        </div>
                        <div class="tab-pane fade" id="navs-justified-profile" role="tabpanel">
                            @include('admin.settings.form.system')
                        </div>
                        <div class="tab-pane fade" id="navs-justified-messages" role="tabpanel">
                            @include('admin.settings.form.backup')
                        </div>
                        <div class="tab-pane fade" id="navs-justified-cache" role="tabpanel">
                            @include('admin.settings.form.cache')
                        </div>
                        <div class="tab-pane fade" id="navs-justified-website" role="tabpanel">
                            @include('admin.settings.form.website')
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
    </x-slot>
    <x-slot name="script">
       <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/js/bootstrap-select.min.js"></script>
        <script>
            $('select').selectpicker();
        </script>
    </x-slot>
</x-app-component>
