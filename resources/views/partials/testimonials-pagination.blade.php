@if ($paginator->hasPages())
    <nav class="testimonials-pagination" aria-label="{{ __('Pagination Navigation') }}">
        @if ($paginator->onFirstPage())
            <span class="testimonials-page is-disabled" aria-disabled="true">السابق</span>
        @else
            <a class="testimonials-page" href="{{ $paginator->previousPageUrl() }}" rel="prev">السابق</a>
        @endif

        <span class="testimonials-pages">
            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="testimonials-page is-disabled">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="testimonials-page is-active" aria-current="page">{{ $page }}</span>
                        @else
                            <a class="testimonials-page" href="{{ $url }}">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </span>

        @if ($paginator->hasMorePages())
            <a class="testimonials-page" href="{{ $paginator->nextPageUrl() }}" rel="next">التالي</a>
        @else
            <span class="testimonials-page is-disabled" aria-disabled="true">التالي</span>
        @endif
    </nav>
@endif