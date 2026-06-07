@if ($paginator->hasPages())
<nav class="pagination" aria-label="Pagination">
    {{-- Previous Page Link --}}
    @if ($paginator->onFirstPage())
        <span class="pagination__link pagination__link--disabled">&laquo; Prev</span>
    @else
        <a href="{{ $paginator->previousPageUrl() }}" class="pagination__link">&laquo; Prev</a>
    @endif

    {{-- Pagination Elements --}}
    @foreach ($elements as $element)
        @if (is_string($element))
            <span class="pagination__link pagination__link--disabled">{{ $element }}</span>
        @endif
        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <span class="pagination__link pagination__link--active">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" class="pagination__link">{{ $page }}</a>
                @endif
            @endforeach
        @endif
    @endforeach

    {{-- Next Page Link --}}
    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" class="pagination__link">Next &raquo;</a>
    @else
        <span class="pagination__link pagination__link--disabled">Next &raquo;</span>
    @endif
</nav>
@endif
