<div class="d-flex mb-0 align-items-center">
    <div class="mb-3 me-2">
        <a href="{{ url()->previous() }}"><i class='bx bxs-left-arrow-circle'></i></a>
    </div>
    <div class="mb-3 me-2">
        <span class="h3 fw-bold">{{ $title }} </span>
    </div>
    <div class="mb-3 me-2">
        @if (can_do($permission))
        <a class="ui-button ui-corner-all ui-widget text-primary" href="{{ route($permalink) }}">
            {{ $buttonText }}
        </a>
    @endif
    </div>
</div>
