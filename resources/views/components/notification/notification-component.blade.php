<li class="nav-item dropdown-notifications navbar-dropdown dropdown me-3 me-xl-1 mt-1">
    <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown"
        data-bs-auto-close="outside" aria-expanded="false">
        <i class="bx bx-bell bx-sm"></i>
        <span
            class="badge bg-danger rounded-pill badge-notifications">{{ auth()->user()->unreadNotifications->count() }}</span>
    </a>
    <ul class="dropdown-menu dropdown-menu-end py-0">
        <li class="dropdown-menu-header border-bottom">
            <div class="dropdown-header d-flex align-items-center py-3">
                <h5 class="text-body mb-0 me-auto">Notification</h5>
                <a href="{{ route('mark.read') }}" class="dropdown-notifications-all text-body" data-bs-toggle="tooltip"
                    data-bs-placement="top" title="" data-bs-original-title="Mark all as read"
                    aria-label="Mark all as read"><i class="bx fs-4 bx-envelope-open"></i></a>
            </div>
        </li>
        <li class="dropdown-notifications-list scrollable-container ps">
            <ul class="list-group list-group-flush">
                @forelse ($notifications as $notification)
                    <li class="list-group-item list-group-item-action dropdown-notifications-item">
                        <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                                <div class="avatar">
                                @empty(!$notification->image_path)
                                    <img src="{{ $notification->image_path }}" class="avatar-initial rounded-circle" />
                                @else
                                    <img src="{{ asset('admin/assets/img/avatars/1.png') }}"
                                        class="avatar-initial rounded-circle" />
                @endif
                </div>
                </div>
                <div class="flex-grow-1">
                    <p class="mb-0">
                        <b>{{ $notification->user_who_does }}</b>
                        @if ($notification->event == 'created')
                            <span class="text-success">{{ $notification['data'] }}</span>
                        @elseif($notification->event == 'updated')
                            <span class="text-info">{{ $notification['data'] }}</span>
                        @elseif($notification->event == 'deleted')
                            <span class="text-danger">{{ $notification['data'] }}</span>
                        @else
                            <span class="text-black">{{ $notification['data'] }}</span>
                        @endif
                    </p>
                    <small class="text-muted">{{ $notification['created_at']->toDayDateTimeString() }}</small>
                </div>
                </div>
        </li>
    @empty
        @endforelse
    </ul>
</li>
<li class="dropdown-menu-footer border-top">
    <a href="{{ route('notify.all') }}" class="dropdown-item d-flex justify-content-center p-3">
        View all notifications
    </a>
</li>
</ul>
</li>
