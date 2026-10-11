<div class="testimonials-section-panel" data-testimonials-section>
    <div class="{{ $wrapperClass }}">
        @foreach ($testimonials as $testimonial)
            @include('landing.partials.testimonial-card', ['testimonial' => $testimonial, 'settings' => $settings])
        @endforeach
    </div>
    {{ $testimonials->links('partials.testimonials-pagination') }}
</div>
