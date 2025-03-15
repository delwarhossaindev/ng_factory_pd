<!DOCTYPE html>
<html class="light-style layout-menu-fixed">
<head>
    <x-layouts.header-component />
    {{ $style ?? '' }}
</head>
<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <div class="layout-page">
                <div class="container-fluid">
                    <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
                        id="layout-navbar">
                        <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                            <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0"
                                id="layout-menu-toggle">
                                <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                                    <i class="bx bx-menu bx-sm"></i>
                                </a>
                            </div>
                            <div class="app-brand demo">
                                <a href="{{ route('dashboard') }}" class="app-brand-link">
                                    <span class="app-brand-logo demo"></span>
                                    <span
                                        class="app-brand-text menu-text fw-bolder ms-2">NG Factory PD</span>
                                </a>
                                <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
                                    <i class="bx bx-chevron-left bx-sm align-middle"></i>
                                </a>
                            </div>
                            <x-layouts.header-left-component />
                        </div>
                    </nav>
                </div>
                <div class="content-wrapper">
                    <x-layouts.sidebar-component />
                    <div class="container-xxl flex-grow-1 container-p-y content-wrapper-all">
                        <x-alert.alert-component />
                        {{ $content ?? '' }}
                    </div>
                    <div class="content-backdrop fade"></div>
                </div>
            </div>
        </div>
    </div>
    <div id="dialog-confirm" title="Do you want to proceed?" style="display:none;">
        <p><span class="bx bxs-error" style="float:left; margin:12px 12px 20px 0;"></span>These items will be
            permanently deleted or may be moved to trash. Are you sure?</p>
    </div>
    <div class="edit-modal"></div>
    <x-layouts.footer-component />
    {{ $script ?? '' }}
    @if ((new \Jenssegers\Agent\Agent())->isMobile())
        <script>
            $('#layout-menu-toggle').click(function() {
                $('#layout-menu').toggle();
            });
        </script>
    @endif
</body>
</html>
