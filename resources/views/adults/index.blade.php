@extends('layouts.landing')

@section('title', 'Cours des adultes - Coran, Tajwid et arabe | ' . $settings->footer_brand_name)

@section('meta_description', $pageSettings->adults_subtitle)

@section('bodyClass', '')

@section('styles')
    @vite(['resources/css/courses.css'])
@endsection

@section('content')

    @include('landing.partials.nav', [
        'activePage' => 'adults',
        'homeUrl' => route('home'),
    ])

    <section class="catalog-hero adults">
        <div class="container">
            <div>
                <span class="section-label">{{ $pageSettings->adults_label }}</span>
                <h1 class="catalog-hero-title">
                    {{ $pageSettings->adults_title }}
                    <span class="accent">{{ $pageSettings->adults_title_accent }}</span>
                </h1>
                <p class="catalog-hero-sub">{{ $pageSettings->adults_subtitle }}</p>

                <div class="catalog-hero-btns">
                    <a href="#catalog" class="btn-primary">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        {{ $pageSettings->adults_cta_title }}
                    </a>
                    <a href="{{ $pageSettings->adults_wa_url }}" class="btn-outline-white" target="_blank" rel="noopener">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        {{ $pageSettings->adults_wa_title }}
                    </a>
                </div>
            </div>

            <div class="hero-showcase">
                <div class="emojis">📖</div>
                <div class="hero-showcase-title">Flexibilité et maîtrise pour les adultes</div>
                <div class="hero-showcase-sub">Des plans d'étude adaptés à votre emploi du temps, avec un enseignant pour les hommes et une enseignante pour les femmes.</div>
            </div>
        </div>
    </section>

    <section class="section" id="catalog">
        <div class="container">
            <div class="catalog-head section-center">
                <span class="section-label">{{ $pageSettings->adults_label }}</span>
                <h2 class="section-title">Cours des adultes et des grands</h2>
                <p class="section-sub">Choisissez le cours adapté à votre niveau et à votre objectif, puis cliquez pour voir les détails complets et réserver la séance d'essai.</p>
            </div>

            @if ($courses->count())
                <div class="courses-grid">
                    @foreach ($courses as $course)
                        <article class="course-card">
                            <div class="course-card-head theme-{{ $course->card_theme }}">
                                <span class="icon">{{ $course->icon }}</span>
                                <h3>{{ $course->title }}</h3>
                            </div>
                            <div class="course-card-body">
                                <div class="course-meta">
                                    <span class="meta-badge">
                                        @if ($course->level_label)
                                            <i class="fa-solid fa-gauge-high"></i> Niveau : {{ $course->level_label }}
                                        @elseif ($course->ageBandLabel())
                                            <i class="fa-solid fa-child"></i> Âge : {{ $course->ageBandLabel() }}
                                        @endif
                                    </span>
                                    <span class="meta-time"><i class="fa-regular fa-clock"></i> {{ $course->session_minutes }} min/séance</span>
                                </div>
                                <p class="course-desc">{{ $course->short_description }}</p>
                                <a href="{{ route('courses.show', $course->slug) }}" class="course-cta">
                                    Voir les détails et réserver <i class="fa-solid fa-arrow-right"></i>
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>
            @else
                <p class="section-center" style="color: var(--text-mid); padding: 40px 0;">Aucun cours disponible pour le moment.</p>
            @endif
        </div>
    </section>

    @include('landing.partials.footer', ['homeUrl' => route('home')])
    @include('landing.partials.floating')

@endsection