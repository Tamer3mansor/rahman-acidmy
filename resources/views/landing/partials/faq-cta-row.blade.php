<div class="faq-cta-row">
    @foreach ($ctas as $index => $cta)
        @php
            $ctaUrl = (string) $cta['url'];
            $isAnchor = str_starts_with($ctaUrl, '#');
            $resolvedUrl = \App\Support\CtaUrl::resolve($ctaUrl, $activePage ?? 'home');
        @endphp
        @if ($isAnchor && ($activePage ?? 'home') === 'home')
            <span class="faq-cta-inline {{ $index === 0 ? 'is-primary' : '' }}" data-scroll-to-form>
                {{ $cta['text'] }}
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </span>
        @else
            <a href="{{ $resolvedUrl }}" class="faq-cta-inline {{ $index === 0 ? 'is-primary' : '' }}">
                {{ $cta['text'] }}
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </a>
        @endif
    @endforeach
</div>