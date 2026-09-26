@if ($paginator->hasPages())
    <nav class="pagination" aria-label="Pagination">
        @if ($paginator->onFirstPage())
            <span class="page-link is-disabled" aria-hidden="true"><i class="fa-solid fa-angle-left"></i></span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="page-link" rel="prev" aria-label="Page précédente">
                <i class="fa-solid fa-angle-left" aria-hidden="true"></i>
            </a>
        @endif

        @foreach ($paginator->getUrlRange(1, $paginator->lastPage(), 1) as $page => $url)
            <a href="{{ $url }}" class="page-link {{ $page === $paginator->currentPage() ? 'active' : '' }}"
               @if ($page === $paginator->currentPage()) aria-current="page" @endif>{{ $page }}</a>
        @endforeach

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="page-link" rel="next" aria-label="Page suivante">
                <i class="fa-solid fa-angle-right" aria-hidden="true"></i>
            </a>
        @else
            <span class="page-link is-disabled" aria-hidden="true"><i class="fa-solid fa-angle-right"></i></span>
        @endif
    </nav>
@endif
