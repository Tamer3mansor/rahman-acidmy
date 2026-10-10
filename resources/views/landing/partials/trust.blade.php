<section class="trust-section" id="trust">
    <div class="container">
        <div class="section-center">
            <span class="section-label">{{ $settings->trust_label }}</span>
            <h2 class="section-title">{{ $settings->trust_title }}</h2>
            @if (filled($settings->trust_subtitle))
                <div class="section-sub">{!! $settings->trust_subtitle !!}</div>
            @endif
        </div>

        @php
            $whatsappTestimonials = $testimonials
                ->filter(fn ($testimonial) => $testimonial->type?->value === 'whatsapp')
                ->values();
            $googleTestimonials = $testimonials
                ->filter(fn ($testimonial) => $testimonial->type?->value === 'google')
                ->values();
            $videoTestimonials = $testimonials
                ->filter(fn ($testimonial) => $testimonial->type?->value === 'video' && filled($testimonial->media_path))
                ->values();
            $defaultTab = $videoTestimonials->isNotEmpty() ? 'videos' : ($whatsappTestimonials->isNotEmpty() ? 'whatsapp' : 'google');
        @endphp

        <div class="trust-mobile-tabs" data-trust-tabs role="tablist" aria-label="{{ __('Catégories de témoignages') }}">
            @if ($videoTestimonials->isNotEmpty())
                <button type="button" class="trust-tab-btn {{ $defaultTab === 'videos' ? 'is-active' : '' }}" data-tab="videos" role="tab" aria-selected="{{ $defaultTab === 'videos' ? 'true' : 'false' }}">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                    <span>{{ __('Vidéos') }}</span>
                </button>
            @endif
            @if ($whatsappTestimonials->isNotEmpty())
                <button type="button" class="trust-tab-btn {{ $defaultTab === 'whatsapp' ? 'is-active' : '' }}" data-tab="whatsapp" role="tab" aria-selected="{{ $defaultTab === 'whatsapp' ? 'true' : 'false' }}">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
                    <span>WhatsApp</span>
                </button>
            @endif
            @if ($googleTestimonials->isNotEmpty())
                <button type="button" class="trust-tab-btn {{ $defaultTab === 'google' ? 'is-active' : '' }}" data-tab="google" role="tab" aria-selected="{{ $defaultTab === 'google' ? 'true' : 'false' }}">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l2.6 7.1L22 9.3l-5.9 4.6 1.9 7.4L12 16.9 6 21.3l1.9-7.4L2 9.3l7.4-.2L12 2z"/></svg>
                    <span>{{ __('Avis Google') }}</span>
                </button>
            @endif
        </div>

        <div class="trust-grid" data-active-tab="{{ $defaultTab }}">
            <div class="trust-screenshots trust-marquee {{ $whatsappTestimonials->count() < 2 ? 'trust-marquee--static' : '' }} {{ $defaultTab === 'whatsapp' ? 'is-tab-active' : '' }}" data-trust-pane="whatsapp" data-direction="up">
                @if ($whatsappTestimonials->isNotEmpty())
                    <div class="trust-marquee-track">
                        <div class="trust-marquee-group">
                            @foreach ($whatsappTestimonials as $testimonial)
                                @include('landing.partials.testimonial-card', ['testimonial' => $testimonial])
                            @endforeach
                        </div>
                        @if ($whatsappTestimonials->count() > 1)
                            <div class="trust-marquee-group" aria-hidden="true">
                                @foreach ($whatsappTestimonials as $testimonial)
                                    @include('landing.partials.testimonial-card', ['testimonial' => $testimonial])
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endif
            </div>

            <div class="trust-video-marquee trust-marquee {{ $videoTestimonials->count() < 2 ? 'trust-marquee--static' : '' }} {{ $defaultTab === 'videos' ? 'is-tab-active' : '' }}" data-trust-pane="videos" data-direction="up" data-video-marquee>
                @if ($videoTestimonials->isNotEmpty())
                    <div class="trust-marquee-track">
                        <div class="trust-marquee-group">
                            @foreach ($videoTestimonials as $index => $testimonial)
                                @include('landing.partials.testimonial-card', [
                                    'testimonial' => $testimonial,
                                    'videoPreload' => $index === 0 ? 'metadata' : 'none',
                                ])
                            @endforeach
                        </div>
                        @if ($videoTestimonials->count() > 1)
                            <div class="trust-marquee-group" aria-hidden="true">
                                @foreach ($videoTestimonials as $testimonial)
                                    @include('landing.partials.testimonial-card', [
                                        'testimonial' => $testimonial,
                                        'videoPreload' => 'none',
                                    ])
                                @endforeach
                            </div>
                        @endif
                    </div>
                @else
                    <div class="trust-video-card" style="aspect-ratio:16/9">
                        <div class="trust-video-placeholder">
                            <div class="play-sm">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="#C9963A"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                            </div>
                            <span>Test vidéo · Parents</span>
                        </div>
                    </div>
                @endif
            </div>

            <div class="trust-screenshots trust-marquee {{ $googleTestimonials->count() < 2 ? 'trust-marquee--static' : '' }} {{ $defaultTab === 'google' ? 'is-tab-active' : '' }}" data-trust-pane="google" data-direction="up">
                @if ($googleTestimonials->isNotEmpty())
                    <div class="trust-marquee-track">
                        <div class="trust-marquee-group">
                            @foreach ($googleTestimonials as $testimonial)
                                @include('landing.partials.testimonial-card', ['testimonial' => $testimonial])
                            @endforeach
                        </div>
                        @if ($googleTestimonials->count() > 1)
                            <div class="trust-marquee-group" aria-hidden="true">
                                @foreach ($googleTestimonials as $testimonial)
                                    @include('landing.partials.testimonial-card', ['testimonial' => $testimonial])
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        <div class="trust-cta-wrap">
            <button class="btn-primary" data-scroll-to-form>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                {{ $settings->trust_cta_title }}
            </button>
        </div>
    </div>
</section>
