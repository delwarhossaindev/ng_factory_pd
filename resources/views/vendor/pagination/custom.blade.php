@if ($paginator->hasPages())
<ul class="pagination">
    @if ($paginator->onFirstPage())
        <li class="paginate_button page-item previous disabled"><span>← Previous</span></li>
    @else
        <li><a href="{{ $paginator->previousPageUrl() }}" rel="prev">← Previous</a></li>
    @endif
    @foreach ($elements as $element)
        @if (is_string($element))
            <li class="paginate_button page-item previous disabled"><span>{{ $element }}</span></li>
        @endif
        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <li class="paginate_button page-item active"><span>{{ $page }}</span></li>
                @else
                    <li><a href="{{ $url }}">{{ $page }}</a></li>
                @endif
            @endforeach
        @endif
    @endforeach
    @if ($paginator->hasMorePages())
        <li><a href="{{ $paginator->nextPageUrl() }}" rel="next">Next →</a></li>
    @else
        <li class="paginate_button page-item next disabled"><span>Next →</span></li>
    @endif
</ul>
@endif 