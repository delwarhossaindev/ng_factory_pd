<x-app-component>
    <x-page.page-title data="User Details" />
    <x-slot name="content">
        <h4 class="fw-bold">User Details</h4>
        <x-alert.alert-component />
        <div class="row">
            <div class="col">
                <div class="card mb-4">
                    <div class="user-profile-header d-flex flex-column flex-sm-row text-sm-start text-center mb-4">
                        <div class="flex-shrink-0 mt-n2 mx-sm-0 mx-auto">
                            @if ($user->image)
                                <img src="{{ $user->image->path }}" alt="user image"
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
                                    <h4>{{ $user->name }}</h4>
                                    <ul
                                        class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-2">
                                        <li class="list-inline-item fw-semibold">
                                            <i class="bx bx-pen"></i>
                                            @forelse ($user->roles()->get() as $role)
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
                                            {{ $user->hasAddress() ? $user->address->city : 'N/A' }}
                                        </li>
                                        <li class="list-inline-item fw-semibold">
                                            <i class="bx bx-calendar-alt"></i> Joined
                                            {{ $user->created_at->toFormattedDateString() }}
                                        </li>
                                    </ul>
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
                                    class="fw-semibold mx-2">Full Name:</span> <span>{{ $user->name }}</span></li>
                            <li class="d-flex align-items-center mb-3"><i class="bx bx-check"></i><span
                                    class="fw-semibold mx-2">Status:</span> <span>
                                    @if ($user->status == 1)
                                        <span class='badge bg-label-success'>Active</span>
                                    @elseif($user->status == 2)
                                        <span class='badge bg-label-warning'>Inactive</span>
                                    @else
                                        <span class='badge bg-label-secondary'>Pending</span>
                                    @endif
                                </span></li>
                            <li class="d-flex align-items-center mb-3"><i class="bx bx-star"></i><span
                                    class="fw-semibold mx-2">Role:</span> <span>
                                    @forelse ($user->roles()->get() as $role)
                                        <small class="badge bg-label-success">
                                            {{ ucfirst($role->name) }}
                                        </small>
                                    @empty
                                        <small class="text-muted">
                                            {{ trans('sentence.no_role') }}
                                        </small>
                                    @endforelse
                                </span></li>
                        </ul>
                        <small class="text-muted text-uppercase">Contacts</small>
                        <ul class="list-unstyled mb-4 mt-3">
                            <li class="d-flex align-items-center mb-3"><i class="bx bx-phone"></i><span
                                    class="fw-semibold mx-2">Contact:</span>
                                <span>{{ $user->hasAddress() ? $user->address->phone : 'N/A' }}</span>
                            </li>
                            <li class="d-flex align-items-center mb-3"><i class="bx bx-envelope"></i><span
                                    class="fw-semibold mx-2">Email:</span> <span>{{ $user->email }}</span></li>
                        </ul>
                        <small class="text-muted text-uppercase">Last login</small>
                        <ul class="list-unstyled mt-3 mb-0">
                            <li class="d-flex align-items-center mb-3"><i
                                    class="bx bx-window-open text-primary me-2"></i>
                                <div class="d-flex flex-wrap"><span class="fw-semibold me-2">Last
                                        login</span><span>{{ \Carbon\Carbon::parse($user->last_login)->toDayDateTimeString() }}</span>
                                </div>
                            </li>
                            <li class="d-flex align-items-center"><i class="bx bx-power-off text-info me-2"></i>
                                <div class="d-flex flex-wrap"><span class="fw-semibold me-2">Last
                                        logout</span><span>{{ \Carbon\Carbon::parse($user->last_logout)->toDayDateTimeString() }}</span>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-xl-8 col-lg-7 col-md-7">
                @include('admin.user.activity')
            </div>
        </div>
    </x-slot>
</x-app-component>
