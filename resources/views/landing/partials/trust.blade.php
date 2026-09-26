<section class="trust-section" id="trust">
    <div class="container">
        <div class="section-center">
            <span class="section-label">{{ $settings->trust_label }}</span>
            <h2 class="section-title">{{ $settings->trust_title }}</h2>
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
        @endphp

        <div class="trust-grid">
            <div class="trust-screenshots trust-marquee {{ $whatsappTestimonials->count() < 2 ? 'trust-marquee--static' : '' }}" data-direction="up">
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

            <div class="trust-videos-wrap">
                <div class="trust-videos" data-trust-videos>
                    @forelse ($videoTestimonials as $index => $testimonial)
                        @include('landing.partials.testimonial-card', [
                            'testimonial' => $testimonial,
                            'videoPreload' => $index === 0 ? 'metadata' : 'none',
                        ])
                    @empty
                        <div class="trust-video-card" style="aspect-ratio:16/9">
                            <div class="trust-video-placeholder">
                                <div class="play-sm">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="#C9963A"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                                </div>
                                <span>Test vidéo · Parents</span>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="trust-screenshots trust-marquee {{ $googleTestimonials->count() < 2 ? 'trust-marquee--static' : '' }}" data-direction="down">
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
