<div class="d-flex align-items-center mb-0">
    <div class="mb-3 me-2"><a href="{{ url()->previous() }}"><i class='bx bxs-left-arrow-circle'></i></a></div>
    <div class="mb-3 me-2"><span class="h3 fw-bold">{{ $title }} </span></div>
    <div class="mb-3 me-2">
        @if (can_do($permission))
            <li class="ui-button ui-corner-all ui-widget text-primary" id="create-new">{{ $buttonText }}</li>
        @endif
    </div>
</div>
