<section class="journey-section" id="journey">
    <div class="container">
        <div class="section-center">
            <span class="section-label">{{ $settings->journey_label }}</span>
            <h2 class="section-title">{{ $settings->journey_title }}</h2>
            <p class="section-sub" style="color:rgba(255,255,255,0.7);">{!! $settings->journey_subtitle !!}</p>
        </div>

        <div class="steps-grid">
            @foreach ($journeySteps as $step)
                <div class="step-item">
                    <div class="step-num-wrap {{ $loop->odd ? 'gold' : 'dark-green' }}">
                        {{ $step->icon }}
                    </div>
                    <p class="step-number">{{ str_pad($step->step_number, 2, '0', STR_PAD_LEFT) }}</p>
                    <p class="step-title">{{ $step->title }}</p>
                    <p class="step-desc">{!! $step->description !!}</p>
                </div>
            @endforeach
        </div>

        <div class="journey-cta-wrap">
            <button class="btn-primary" data-scroll-to-form>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                {{ $settings->journey_cta_title }}
            </button>
        </div>
    </div>
</section>