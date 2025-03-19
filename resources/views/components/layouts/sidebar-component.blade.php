@auth
    <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme bold">
        @php
            $route = Route::current()->getName();
            $userId = auth()->user()->UserID;
            $userMeuns = \DB::table('user_menus')->where('user_id', $userId)->get();
        @endphp
        <ul class="menu-inner py-1">
            <!-- toggle -->
            <li class="menu-item first_menu">
                <div class="d-flex justify-content-between menu-link">
                    <div class="div mt-2">
                        <div class="d-flex">
                            <div>
                                <img src="{{ auth()->user()->hasImage() ? storage_asset_path(auth()->user()->image?->image) : asset('admin/assets/img/avatars/1.png') }}"
                                    class="img-fluid rounded-circle me-2" alt="" style="width:40px;height:40px">
                            </div>
                            <div>
                                <h6 class="m-0 text-white fw-bold mt-1">{{ auth()->user()->UserName }}</h6>
                                <!-- <p class="text-info">Level: <small>{{ auth()->user()->Level }}</small></p> -->
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            <li class="menu-item {{ $route == 'dashboard' ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bxs-dashboard"></i>
                    <div data-i18n="Analytics">Dashboard</div>
                </a>
            </li>

            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">System Module</span>
            </li>

            <li class="menu-item @if (request()->is('ng_factory_pd') || request()->is('ng_factory_pd/*') || request()->is('proposal') || request()->is('proposal/*')) {{ 'active open' }} @endif">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bxs-edit"></i>
                    <div data-i18n="Account Settings">Proposal </div>
                </a>
                <ul class="menu-sub">
                    @if (collect($userMeuns)->where('menu_id', 1)->count() > 0)
                        <li class="menu-item {{ $route == 'ng_factory_pd.create' ? 'active' : '' }}">
                            <a href="{{ route('ng_factory_pd.create') }}" class="menu-link">
                                <div data-i18n="Account">Proposal Form </div>
                            </a>
                        </li>
                    @endif
                    @if (collect($userMeuns)->where('menu_id', 2)->count() > 0)
                        <li class="menu-item {{ $route == 'ng_factory_pd.index' ? 'active' : '' }}">
                            <a href="{{ route('ng_factory_pd.index') }}" class="menu-link">
                                <div data-i18n="Account">My Proposal Submission</div>
                            </a>
                        </li>
                    @endif

                    @if (collect($userMeuns)->where('menu_id', 5)->count() > 0)
                        <li class="menu-item {{ $route == 'proposal.request_approval_list' ? 'active' : '' }}">
                            <a href="{{ route('proposal.request_approval_list') }}" class="menu-link">
                                <div data-i18n="Account">Request For Approval</div>
                            </a>
                        </li>
                    @endif
                    <!-- @if (collect($userMeuns)->where('menu_id', 3)->count() > 0)
                        <li class="menu-item {{ $route == 'credit_note_approval.my_submitted_list' ? 'active' : '' }}">
                            <a href="{{ route('credit_note_approval.my_submitted_list') }}" class="menu-link">
                                <div data-i18n="Account">My Submission </div>
                            </a>
                        </li>
                    @endif
                    @if (collect($userMeuns)->where('menu_id', 4)->count() > 0)
                        <li
                            class="menu-item {{ $route == 'credit_note_approval.approved_submission_list' ? 'active' : '' }}">
                            <a href="{{ route('credit_note_approval.approved_submission_list') }}" class="menu-link">
                                <div data-i18n="Account">Approved Submission</div>
                            </a>
                        </li>
                    @endif
                    -->

                    @if (collect($userMeuns)->where('menu_id', 4)->count() > 0)
                    <li
                        class="menu-item {{ $route == 'ng_factory_pd.approved_submission_list' ? 'active' : '' }}">
                        <a href="{{ route('ng_factory_pd.approved_submission_list') }}" class="menu-link">
                            <div data-i18n="Account">Approved Submission</div>
                        </a>
                    </li>
                  @endif



                    <!-- @if (collect($userMeuns)->where('menu_id', 6)->count() > 0)
                        <li class="menu-item {{ $route == 'credit_note_approval.list' ? 'active' : '' }}">
                            <a href="{{ route('credit_note_approval.list') }}" class="menu-link">
                                <div data-i18n="Account">Proposal Report</div>
                            </a>
                        </li>
                    @endif -->
                </ul>
            </li>

            @if (collect($userMeuns)->where('menu_id', 7)->count() > 0)
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">User Manager</span>
            </li>
            @endif

            <li class="menu-item {{ $route == 'user.index' || request()->is('user/*') ? 'active' : '' }}">
                @if (collect($userMeuns)->where('menu_id', 7)->count() > 0)
                    <a href="{{ route('user.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-group"></i>
                        <div data-i18n="Analytics">Users</div>
                    </a>

            </li>
            @endif
        </ul>
    </aside>
@endauth
