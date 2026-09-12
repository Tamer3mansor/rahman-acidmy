<section class="faq-section" id="faq">
    <div class="container">
        <div class="section-center">
            <span class="section-label">{{ $settings->faq_label }}</span>
            <h2 class="section-title">{{ $settings->faq_title }}</h2>
            <p class="section-sub">{!! $settings->faq_subtitle !!}</p>
        </div>

        <div class="faq-list">
            @foreach ($faqs as $faq)
                <div class="faq-item">
                    <div class="faq-question" data-faq-toggle>
                        <span>{{ $faq->question }}</span>
                        <div class="faq-arrow"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg></div>
                    </div>
                    <div class="faq-answer">
                        <div class="faq-answer-inner">
                            {!! $faq->answer !!}
                            @if ($faq->show_cta && $faq->cta_url)
                                @if (str_starts_with($faq->cta_url, '#'))
                                    <span class="faq-cta-inline" data-scroll-to-form>
                                        {{ $faq->cta_text }}
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                                    </span>
                                @else
                                    <a href="{{ $faq->cta_url }}" class="faq-cta-inline" target="_blank" rel="noopener">
                                        {{ $faq->cta_text }}
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                                    </a>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="faq-bottom-cta">
            <p style="color:var(--text-mid);margin-bottom:20px;font-size:0.95rem;">Vous avez une autre question ?</p>
            <div style="display:flex;gap:14px;justify-content:center;flex-wrap:wrap;">
                <a href="{{ $settings->hero_btn2_url }}" class="btn-outline" target="_blank" rel="noopener">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    Contactez-nous
                </a>
                <button class="btn-primary" data-scroll-to-form>{{ $settings->hero_btn1_title }}</button>
            </div>
        </div>
    </div>
</section>

<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@@type": "FAQPage",
    "mainEntity": [
        @foreach ($faqs as $faq)
        {
            "@type": "Question",
            "name": @json($faq->question),
            "acceptedAnswer": {
                "@type": "Answer",
                "text": @json(strip_tags($faq->answer))
            }
        }@if (! $loop->last),@endif
        @endforeach
    ]
}
</script>