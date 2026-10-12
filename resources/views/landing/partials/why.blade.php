<section class="why-section" id="courses">
    @if ($whyItems->isNotEmpty())
        <div class="container">
            <div class="section-center">
                <span class="section-label">{{ $settings->why_label }}</span>
                <h2 class="section-title">{{ $settings->why_title }}</h2>
                @if (filled($settings->why_subtitle))
                    <div class="section-sub">{!! $settings->why_subtitle !!}</div>
                @endif
            </div>

            <div class="why-grid">
                @foreach ($whyItems as $item)
                    <div class="why-card">
                        <div class="why-card-icon {{ str_starts_with(trim((string) $item->icon), 'fa-') ? 'is-fa' : '' }}">
                            @if (str_starts_with(trim((string) $item->icon), 'fa-'))
                                <i class="{{ $item->icon }}"></i>
                            @elseif (filled($item->icon))
                                {{ $item->icon }}
                            @else
                                <i class="fa-solid fa-circle-check"></i>
                            @endif
                        </div>
                        <h3 class="why-card-title">{{ $item->title }}</h3>
                        @if (filled($item->description))
                            <p class="why-card-desc">{!! $item->description !!}</p>
                        @endif
                    </div>
                @endforeach
            </div>

            @if (filled($settings->why_cta_title))
                <div class="why-cta">
                    <button class="btn-primary" data-scroll-to-form>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        {{ $settings->why_cta_title }}
                    </button>
                </div>
            @endif
        </div>
    @endif
</section>
