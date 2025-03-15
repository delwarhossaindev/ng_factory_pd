<div class="mb-3">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h4 class="fw-bold mb-2">
              {{ $currentPageText }}
            </h4>
            <p class="mb-0 text-muted">
              All the <span class="bg-red">*</span> mark fields indicate mandatory fields
            </p>
        </div>
        <div>
            <nav class="text-muted" aria-label="breadcrumb m-0">
                <ol class="breadcrumb breadcrumb-style1 m-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route($secondLabelRoute) }}">{{ $secondLable }}</a>
                    </li>
                    <li class="breadcrumb-item fw-semi-bold text-muted">{{ $currentPageText }}</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
