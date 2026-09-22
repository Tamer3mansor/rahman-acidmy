<div class="faq-cta-row">
    @foreach ($ctas as $index => $cta)
        @if (str_starts_with((string) $cta['url'], '#'))
            <span class="faq-cta-inline {{ $index === 0 ? 'is-primary' : '' }}" data-scroll-to-form>
                {{ $cta['text'] }}
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </span>
        @else
            <a href="{{ $cta['url'] }}" class="faq-cta-inline {{ $index === 0 ? 'is-primary' : '' }}" target="_blank" rel="noopener">
                {{ $cta['text'] }}
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </a>
        @endif
    @endforeach
</div>