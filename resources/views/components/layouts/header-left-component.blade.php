@auth
    <ul class="navbar-nav flex-row align-items-center ms-auto">
        <div class="">
            <a class="btn p-0 ps-0" type="button" id="menudd"
                href="{{ route('theme.update', ['theme' => session('theme') === 'light' ? 'dark' : 'light']) }}">
                <i class='bx bx-sm {{ session('theme') == 'light' ? 'bx-moon' : 'bx-sun' }}'></i>
            </a>
        </div>
        <li class="nav-item navbar-dropdown dropdown-user dropdown">
            <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                @if (auth()->user()->hasImage())
                    <div class="avatar avatar-online">
                        <img src="{{ storage_asset_path(auth()->user()->image?->image) }}" alt="user profile image"
                            style="border-radius:50%">
                    </div>
                @else
                    <div class="avatar avatar-online">
                        <img src="{{ asset('admin/assets/img/avatars/1.png') }}" alt="user profile image"
                            style="border-radius:50%">
                    </div>
                @endif
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
                <li>
                    <a class="dropdown-item" href="{{ route('profile') }}">
                        <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                                @if (auth()->user()->hasImage())
                                    <div class="avatar avatar-online">
                                        <img src="{{ storage_asset_path(auth()->user()->image?->image) }}"
                                            alt="user profile image"
                                            class="flag-icon flag-icon-us flag-icon-squared rounded-circle me-1 fs-3">
                                    </div>
                                @else
                                    <div class="avatar avatar-online">
                                        <img src="{{ asset('admin/assets/img/avatars/1.png') }}" alt="user profile image"
                                            class="w-px-40 h-auto rounded-circle">
                                    </div>
                                @endif
                            </div>
                            <div class="flex-grow-1">
                                <span class="fw-semibold d-block">{{ auth()->user()->UserName }}</span>
                                <small class="badge bg-label-success">
                                    {{ auth()->user()->Level }}
                                </small>
                            </div>
                        </div>
                    </a>
                </li>
                <li>
                    <div class="dropdown-divider"></div>
                </li>
                {{-- <li>
                    <a class="dropdown-item" href="{{ route('profile') }}">
                        <i class="bx bx-user me-2"></i>
                        <span class="align-middle">{{ trans('sentence.my_profile') }}</span>
                    </a>
                </li> --}}
                <li>
                    <a class="dropdown-item" href="{{ route('update.password') }}">
                        <i class="bx bx-lock me-2"></i>
                        <span class="align-middle">{{ trans('sentence.change_password') }}</span>
                    </a>
                </li>
                <li>
                    <div class="dropdown-divider"></div>
                </li>
                @impersonate
                    <li>
                        <a class="dropdown-item" href="{{ route('impersonate.destroy') }}">
                            <i class="bx bx-power-off me-2"></i>
                            <span class="align-middle text-primary">Stop Impersonate</span>
                        </a>
                    </li>
                @else
                    <li>
                        <a class="dropdown-item" href="{{ route('logout') }}">
                            <i class="bx bx-power-off me-2"></i>
                            <span class="align-middle">{{ trans('sentence.logout') }}</span>
                        </a>
                    </li>
                @endimpersonate
            </ul>
        </li>
    </ul>
@endauth
