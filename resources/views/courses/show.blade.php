@php
    $backUrl = $course->audience === \App\Enums\CourseAudience::Kids
        ? route('kids.index')
        : route('adults.index');
    $backLabel = $course->audience === \App\Enums\CourseAudience::Kids
        ? 'Cours des enfants'
        : 'Cours des adultes';
    $activePage = $course->audience === \App\Enums\CourseAudience::Kids ? 'kids' : 'adults';
@endphp

@extends('layouts.landing')

@section('title', $course->title . ' | ' . $settings->footer_brand_name)

@section('meta_description', $course->short_description)

@section('bodyClass', '')

@section('styles')
    @vite(['resources/css/courses.css'])
@endsection

{{-- Structured data (SEO) --}}
@section('head')
    <link rel="canonical" href="{{ route('courses.show', $course->slug) }}">
    <meta property="og:type" content="article">
    <meta property="og:title" content="{{ $course->title }}">
    <meta property="og:description" content="{{ $course->short_description }}">
    <meta property="og:url" content="{{ route('courses.show', $course->slug) }}">
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@type": "Course",
        "name": @json($course->title),
        "description": @json($course->short_description),
        "provider": { "@type": "Organization", "name": @json($settings->footer_brand_name) }
    }
    </script>
@endsection

@section('content')

    @include('landing.partials.nav', [
        'activePage' => $activePage,
        'homeUrl' => route('home'),
    ])

    <section class="details-hero">
        <div class="container">
            <span class="section-label">
                {{ $course->icon }} {{ $course->audience === \App\Enums\CourseAudience::Kids
                    ? 'Programme dédié aux enfants et aux jeunes'
                    : 'Programme dédié aux adultes et aux grands' }}
            </span>
            <h1 class="details-hero-title">{{ $course->title }}</h1>
            <p class="details-hero-sub">{{ $course->short_description }}</p>

            <div class="details-hero-btns">
                <a href="{{ route('home') . '#trial-form' }}" class="btn-primary">
                    <i class="fa-solid fa-calendar-check"></i> Réserver une séance d'essai
                </a>
                <a href="{{ $settings->header_btn1_url }}" class="btn-outline" target="_blank" rel="noopener">
                    <i class="fa-brands fa-whatsapp"></i> Discuter avec nous sur WhatsApp
                </a>
            </div>
        </div>
    </section>

    <div class="container">
        <div class="breadcrumbs">
            <a href="{{ route('home') }}">Accueil</a> /
            <a href="{{ $backUrl }}">{{ $backLabel }}</a> /
            <span>{{ $course->title }}</span>
        </div>
    </div>

    <main class="container details-layout" style="padding: 56px 24px;">

        @if (!empty($course->suitability_checks))
            <section class="detail-section">
                <div class="catalog-head section-center" style="margin-bottom: 32px;">
                    <h2 class="section-title" style="font-size: 1.7rem;">🎯 Ce cours est-il fait pour vous ?</h2>
                </div>
                <div class="suitability-grid">
                    @foreach ($course->suitability_checks as $suitability)
                        <div class="suitability-item">
                            <span class="check"><i class="fa-solid fa-check"></i></span>
                            <p>{{ $suitability }}</p>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

        @if (!empty($course->curriculum_items))
            <section class="detail-section">
                <div class="catalog-head section-center" style="margin-bottom: 32px;">
                    <h2 class="section-title" style="font-size: 1.7rem;">📚 Que vas-tu apprendre dans ce programme ?</h2>
                </div>
                <div class="curriculum-grid">
                    @foreach ($course->curriculum_items as $item)
                        <div class="curriculum-card">
                            <div class="icon">{{ $item['icon'] }}</div>
                            <h3>{{ $item['title'] }}</h3>
                            <p>{{ $item['description'] }}</p>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

        @if (!empty($course->session_features))
            <section class="detail-section">
                <div class="session-features">
                    <h2>💡 😊 Comment se déroule le cours ?</h2>
                    <p>Nous garantissons une expérience interactive, sûre et motivante à chaque séance :</p>
                    <div class="session-grid">
                        @foreach ($course->session_features as $feature)
                            <div class="session-card">
                                <div class="session-card-title">{{ $feature['title'] }}</div>
                                <p>{{ $feature['description'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        @if (!empty($course->journey_steps))
            <section class="detail-section">
                <div class="catalog-head section-center" style="margin-bottom: 32px;">
                    <h2 class="section-title" style="font-size: 1.7rem;">🚀 Votre parcours et votre progression</h2>
                </div>
                <div class="journey-steps">
                    @foreach ($course->journey_steps as $step)
                        <div class="step-card">
                            <div class="journey-step-num {{ $step['htmlClass'] ?? 'gold' }}">{{ $step['number'] ?? $loop->iteration }}</div>
                            <h4>{{ $step['title'] }}</h4>
                            <p>{{ $step['description'] }}</p>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

        @if (!empty($course->faqs))
            <section class="detail-section">
                <div class="catalog-head section-center" style="margin-bottom: 32px;">
                    <h2 class="section-title" style="font-size: 1.7rem;">❓ Questions fréquentes</h2>
                </div>
                <div class="faq-list" style="margin: 0 auto;">
                    @foreach ($course->faqs as $faq)
                        <div class="faq-item">
                            <div class="faq-question" data-faq-toggle>
                                <span>{{ $faq['question'] }}</span>
                                <div class="faq-arrow"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg></div>
                            </div>
                            <div class="faq-answer">
                                <div class="faq-answer-inner">
                                    {{ $faq['answer'] }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

        <section class="booking-cta" id="bookingForm">
            <h2>{{ $pageSettings->details_booking_title }}</h2>
            <p>{{ $pageSettings->details_booking_subtitle }}</p>
            @if ($pageSettings->details_booking_note)
                <p class="note">{{ $pageSettings->details_booking_note }}</p>
            @endif
            <div class="booking-btn">
                <a href="{{ route('home') . '#trial-form' }}" class="btn-primary">{{ $pageSettings->details_cta_title }}</a>
            </div>
        </section>

    </main>

    @include('landing.partials.footer', ['homeUrl' => route('home')])
    @include('landing.partials.floating')

@endsection