<div class="card card-action">
    <div class="card-header align-items-center mt-3">
        <h5 class="card-action-title mb-0">
            <i class="p-3"></i>
            Activity Timeline
        </h5>
        <a href="{{ route('log') . '?q=' . str_replace(' ', '+', $user->name) }}"
            class="btn btn-primary btn-xs py-0 float-end mr-15" style="margin-right:25px;">All Activity</a>
    </div>
    <div class="card-body table-responsive mt-3">
        <table class="invoice-list-table table">
            <thead>
                <tr>
                    <th>Event</th>
                    <th>URL</th>
                    <th>Time</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @forelse($user->activity as $activity)
                    <tr>
                        <td>
                            @if ($activity->event == 'created')
                                <span class="badge bg-label-success"> {{ $activity->event }} </span>
                            @elseif($activity->event == 'updated')
                                <span class="badge bg-label-primary rounded-pill text-uppercase"> {{ $activity->event }}
                                </span>
                            @elseif($activity->event == 'deleted')
                                <span class="badge bg-label-danger"> {{ $activity->event }} </span>
                            @else
                                <span class="badge bg-label-info rounded-pill text-uppercase"> {{ $activity->event }}
                                </span>
                            @endif
                        </td>
                        <td>{{ $activity->url }}</td>
                        <td>{{ $activity->created_at?->diffForHumans() }}</td>
                        <td>
                            <a href="{{ route('log') }}"
                                class="btn btn-primary btn-xs py-0">Details</a>
                        </td>
                    </tr>
                @empty
                @endforelse
            </tbody>
        </table>
    </div>
</div>
