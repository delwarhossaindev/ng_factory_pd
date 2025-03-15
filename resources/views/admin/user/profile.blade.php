<x-app-component>
    <x-page.page-title data="Profile" />
    <x-slot name="style">
        <link rel="stylesheet" href="{{ asset('css/plugins.css') }}">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/css/intlTelInput.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/css/bootstrap-select.min.css">
    </x-slot>
    <x-slot name="content">
        <h4 class="fw-bold">Profile</h4>
        <div class="row">
            <div class="col">
                <div class="card mb-4">
                    <div class="user-profile-header d-flex flex-column flex-sm-row text-sm-start text-center mb-4">
                        <div class="flex-shrink-0 mt-n2 mx-sm-0 mx-auto">
                            @if (auth()->user()->image)
                                <img src="{{ storage_asset_path(auth()->user()->image?->image) }}" alt="user image"
                                    class="d-block h-auto ms-0 ms-sm-4 rounded user-profile-img"
                                    style="width: 150px; height:150px; border-radius:50%; margin-top:25px;">
                            @else
                                <img src="{{ asset('admin/assets/img/avatars/1.png') }}" alt="user image"
                                    class="d-block h-auto ms-0 ms-sm-4 rounded user-profile-img"
                                    style="width: 150px; height:150px; border-radius:50%; margin-top:25px;">
                            @endif
                        </div>
                        <div class="flex-grow-1 mt-3 mt-sm-5">
                            <div
                                class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-4 flex-md-row flex-column gap-4">
                                <div class="user-profile-info">
                                    <h4>{{ auth()->user()->name }}</h4>
                                    <ul
                                        class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-2">
                                        <li class="list-inline-item fw-semibold">
                                            <i class="bx bx-pen"></i>
                                            @forelse (auth()->user()->roles()->get() as $role)
                                                <small class="badge bg-label-success">
                                                    {{ ucfirst($role->name) }}
                                                </small>
                                            @empty
                                                <small class="text-muted">
                                                    {{ trans('sentence.no_role') }}
                                                </small>
                                            @endforelse
                                        </li>
                                        <li class="list-inline-item fw-semibold">
                                            <i class="bx bx-map"></i>
                                            {{ auth()->user()->hasAddress()
                                                ? auth()->user()->address->city
                                                : 'N/A' }}
                                        </li>
                                        <li class="list-inline-item fw-semibold">
                                            <i class="bx bx-calendar-alt"></i> Joined
                                            {{ auth()->user()->created_at->toFormattedDateString() }}
                                        </li>
                                    </ul>
                                    @if (auth()->user()->hasTwoFactorEnabled())
                                    <p class="fw-semibold mb-3 mt-3">Your two factor(2-FA) authentication is enabled.</p>
                                    @else 
                                    <p class="fw-semibold mb-3 mt-3">Two factor authentication is not enabled yet.</p>
                                    @endif
                                    <p class="w-75">Two-factor authentication adds an additional layer of security to
                                        your account by requiring more than just a password to log in.
                                    </p>
                                    @if (auth()->user()->hasTwoFactorEnabled())
                                    <form action="{{ route('2fa.deactivate') }}" method="get">
                                        @csrf
                                        <div class="has-error">
                                            <label class="switch">
                                                <input type="checkbox" class="switch-input is-invalid" checked="" disabled>
                                                <span class="switch-toggle-slider">
                                                    <span class="switch-on"></span>
                                                    <span class="switch-off"></span>
                                                </span>
                                                <span class="switch-label">Disable 2-FA</span>
                                            </label>
                                            <button type="submit"
                                                class="btn btn-primary btn-xs btn-sm py-0">Deactivate</button>
                                        </div>
                                    </form>
                                    @else
                                    <form action="{{ route('2fa') }}" method="get">
                                        @csrf
                                        <div class="has-error">
                                            <label class="switch">
                                                <input type="checkbox" class="switch-input is-invalid" disabled>
                                                <span class="switch-toggle-slider">
                                                    <span class="switch-on"></span>
                                                    <span class="switch-off"></span>
                                                </span>
                                                <span class="switch-label">Enable 2-FA</span>
                                            </label>
                                            <button type="submit"
                                                class="btn btn-primary btn-xs btn-sm py-0">Activate</button>
                                        </div>
                                    </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-xl-4 col-lg-5 col-md-5">
                <div class="card mb-4">
                    <div class="card-body">
                        <small class="text-muted text-uppercase">About</small>
                        <ul class="list-unstyled mb-4 mt-3">
                            <li class="d-flex align-items-center mb-3"><i class="bx bx-user"></i><span
                                    class="fw-semibold mx-2">Full Name:</span> <span>{{ auth()->user()->name }}</span>
                            </li>
                            <li class="d-flex align-items-center mb-3"><i class="bx bx-check"></i><span
                                    class="fw-semibold mx-2">Status:</span> <span>
                                    @if (auth()->user()->status == 1)
                                        <span class='badge bg-label-success'>Active</span>
                                    @elseif(auth()->user()->status == 2)
                                        <span class='badge bg-label-warning'>Inactive</span>
                                    @else
                                        <span class='badge bg-label-secondary'>Pending</span>
                                    @endif
                                </span></li>
                            <li class="d-flex align-items-center mb-3"><i class="bx bx-star"></i><span
                                    class="fw-semibold mx-2">Role:</span> <span>
                                    @forelse (auth()->user()->roles()->get() as $role)
                                        <small class="badge bg-label-success">
                                            {{ ucfirst($role->name) }}
                                        </small>
                                    @empty
                                        <small class="text-muted">
                                            {{ trans('sentence.no_role') }}
                                        </small>
                                    @endforelse
                                </span></li>
                            <li class="d-flex align-items-center mb-3"><i class="bx bx-flag"></i><span
                                    class="fw-semibold mx-2">Address:</span> <span>{{ auth()->user()->hasAddress()
                                        ? auth()->user()->address->address_line_1
                                        : 'N/A' }}</span></li>
                        </ul>
                        <small class="text-muted text-uppercase">Contacts</small>
                        <ul class="list-unstyled mb-4 mt-3">
                            <li class="d-flex align-items-center mb-3"><i class="bx bx-phone"></i><span
                                    class="fw-semibold mx-2">Contact:</span>
                                <span>{{ auth()->user()->hasAddress()
                                    ? auth()->user()->address->phone
                                    : 'N/A' }}</span>
                            </li>
                            <li class="d-flex align-items-center mb-3"><i class="bx bx-envelope"></i><span
                                    class="fw-semibold mx-2">Email:</span> <span>{{ auth()->user()->email }}</span>
                            </li>
                        </ul>
                        <small class="text-muted text-uppercase">Last login</small>
                        <ul class="list-unstyled mt-3 mb-0">
                            <li class="d-flex align-items-center mb-3"><i
                                    class="bx bx-window-open text-primary me-2"></i>
                                <div class="d-flex flex-wrap"><span class="fw-semibold me-2">Last
                                        login</span><span>{{ \Carbon\Carbon::parse(auth()->user()->last_login)->toDayDateTimeString() }}</span>
                                </div>
                            </li>
                            <li class="d-flex align-items-center"><i class="bx bx-power-off text-info me-2"></i>
                                <div class="d-flex flex-wrap"><span class="fw-semibold me-2">Last
                                        logout</span><span>{{ \Carbon\Carbon::parse(auth()->user()->last_logout)->toDayDateTimeString() }}</span>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-xl-8 col-lg-7 col-md-7">
                <div class="card">
                    <div class="card-body align-items-center">
                        <form id="formAccountSettings" method="POST"
                            action="{{ route('profile.update', auth()->id()) }}" enctype="multipart/form-data"
                            class="needs-validation" role="form" novalidate>
                            @csrf
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label for="name" class="form-label">Profile Pic</label>
                                    <input type="file" class="form-control w-100" name="image">
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" name="name" value="{{ auth()->user()->name }}"
                                        class="form-control w-100" required>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="email" class="form-label">Email</label>
                                    <input class="form-control w-100" type="text" id="email" name="email"
                                        value="{{ auth()->user()->email }}">
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="language" class="form-label">Address Type</label>
                                    <select class="selectpicker form-control" name="address_type" data-container="body" data-live-search="true" data-live-search-style="begins" data-actions-box="true" data-max-options="1" required>
                                        <option value="Primary"
                                            @if (auth()->user()->hasAddress()) {{ auth()->user()->address->address_type == 'Primary' ? 'selected' : '' }} @endif>
                                            Primary</option>
                                        <option value="Permanent"
                                            @if (auth()->user()->hasAddress()) {{ auth()->user()->address->address_type == 'Permanent' ? 'selected' : '' }} @endif>
                                            Permanent</option>
                                    </select>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label" for="phoneNumber">Phone</label><br />
                                    <input type="text" name="phone" class="form-control w-100"
                                        value="{{ auth()->user()->hasAddress()? auth()->user()->address->phone: '' }}" id="mobile_number">
                                </div>
                                <input type="hidden" name="iso2" class="form-control w-100" id="iso2"/>
                                <div class="mb-3 col-md-6">
                                    <label for="address" class="form-label">Address Line 1</label><br />
                                    <input type="text" class="form-control w-100"
                                        name="address_line_1"
                                        value="{{ auth()->user()->hasAddress()
                                            ? auth()->user()->address->address_line_1
                                            : '' }}">
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="state" class="form-label">Address Line 2</label>
                                    <input class="form-control w-100" type="text" id="state" name="address_line_2"
                                        value="{{ auth()->user()->hasAddress()
                                            ? auth()->user()->address->address_line_2
                                            : '' }}">
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="state" class="form-label">{{ trans('sentence.city') }}</label>
                                    <input class="form-control w-100" type="text" id="state" name="city"
                                        value="{{ auth()->user()->hasAddress()
                                            ? auth()->user()->address->city
                                            : '' }}">
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="zipCode" class="form-label">{{ trans('sentence.zip_code') }}</label>
                                    <input type="text" class="form-control w-100" id="zipCode" name="zip_code"
                                        maxlength="6"
                                        value="{{ auth()->user()->hasAddress()
                                            ? auth()->user()->address->zip_code
                                            : '' }}">
                                </div>
                                <div class="mt-2">
                                    <button type="submit"
                                        class="publish-post me-2">{{ trans('sentence.save_changes') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>
    <x-slot name="script">
        <script src="{{ asset('js/plugins.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/intlTelInput.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/js/bootstrap-select.min.js"></script>
        <script>
            $('select').selectpicker();
            var input = document.querySelector("#mobile_number");
            var countryData = window.intlTelInputGlobals.getCountryData();
            window.intlTelInput(input, {
                utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/utils.js",
                initialCountry: "{{ auth()->user()->hasAddress() ? auth()->user()->address?->iso2 : 'bd' }}",
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
