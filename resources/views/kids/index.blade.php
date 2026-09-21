@extends('layouts.landing')

@section('title', $pageSettings->meta_title ?: 'Cours de Coran pour enfants en ligne en France, Belgique et Canada | Ar-Rahman Academy')

@section('description', $pageSettings->meta_description ?: 'Cours de Coran et d\'arabe en ligne pour enfants de 4 à 16 ans en France, Belgique et Canada. Mémorisation, Tajwid, langue arabe avec des enseignants spécialisés Al-Azhar.')

@if ($pageSettings->og_image)
    @php
        $kidsOgImage = \Illuminate\Support\Str::startsWith($pageSettings->og_image, ['http://', 'https://'])
            ? $pageSettings->og_image
            : asset('storage/'.$pageSettings->og_image);
    @endphp
    @section('og_image', $kidsOgImage)
@endif

@section('bodyClass', '')

@section('styles')
    @vite(['resources/css/courses.css'])
@endsection

@section('head')
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@type": "BreadcrumbList",
        "itemListElement": [
            {
                "@type": "ListItem",
                "position": 1,
                "name": "Accueil",
                "item": "{{ config('seo.url') }}"
            },
            {
                "@type": "ListItem",
                "position": 2,
                "name": "Cours enfants",
                "item": "{{ config('seo.url') }}/enfants"
            }
        ]
    }
    </script>
@endsection

@section('content')

    @include('landing.partials.nav', [
        'activePage' => 'kids',
        'homeUrl' => route('home'),
    ])

    <section class="catalog-hero kids">
        <div class="container">
            <div>
                <span class="section-label">{{ $pageSettings->kids_label }}</span>
                <h1 class="catalog-hero-title">
                    {{ $pageSettings->kids_title }}
                    <span class="accent">{{ $pageSettings->kids_title_accent }}</span>
                </h1>
                <p class="catalog-hero-sub">{{ $pageSettings->kids_subtitle }}</p>

                <div class="catalog-hero-btns">
                    <a href="#catalog" class="btn-primary">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        {{ $pageSettings->kids_cta_title }}
                    </a>
                    <a href="{{ $pageSettings->kids_wa_url }}" class="btn-outline" target="_blank" rel="noopener">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        {{ $pageSettings->kids_wa_title }}
                    </a>
                </div>
            </div>

            <div class="hero-showcase">
                @if ($pageSettings->kids_showcase_image)
                    <img src="{{ asset('storage/'.$pageSettings->kids_showcase_image) }}" class="hero-showcase-img" alt="">
                @elseif ($pageSettings->kids_showcase_emoji)
                    <div class="emojis">{{ $pageSettings->kids_showcase_emoji }}</div>
                @endif
                <div class="hero-showcase-title">{{ $pageSettings->kids_showcase_title ?? "Un environnement d'apprentissage joyeux, conçu pour l'enfant" }}</div>
                <div class="hero-showcase-sub">{{ $pageSettings->kids_showcase_subtitle ?? 'Suivi précis avec des rapports périodiques pour les parents après chaque séance.' }}</div>
            </div>
        </div>
    </section>

    <section class="section" id="catalog">
        <div class="container">
            <div class="catalog-head section-center">
                <span class="section-label">{{ $pageSettings->kids_label }}</span>
                <h2 class="section-title">Cours des enfants disponibles</h2>
                <p class="section-sub">Choisissez le programme adapté à l'âge de votre enfant et cliquez pour voir les détails complets et réserver le cours d'essai.</p>
            </div>

            @if ($courses->count())
                <div class="courses-grid">
                    @foreach ($courses as $course)
                        <article class="course-card">
                            <div class="course-card-head theme-{{ $course->card_theme }}">
                                @if ($course->icon)
                                    <img src="{{ asset('storage/'.$course->icon) }}" class="course-card-icon" alt="">
                                @endif
                                <h3>{{ $course->title }}</h3>
                            </div>
                            <div class="course-card-body">
                                <div class="course-meta">
                                    <span class="meta-badge">
                                        @if ($course->minAgeLabel())
                                            <i class="fa-solid fa-child"></i> Âge : {{ $course->minAgeLabel() }}
                                        @elseif ($course->level_label)
                                            <i class="fa-solid fa-gauge-high"></i> {{ $course->level_label }}
                                        @endif
                                    </span>
                                    @if ($course->sessionRangeLabel())
                                        <span class="meta-time"><i class="fa-regular fa-clock"></i> {{ $course->sessionRangeLabel() }}</span>
                                    @endif
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

    @if ($testimonials->count())
        <section class="section section-white">
            <div class="container">
                <div class="catalog-head section-center" style="margin-bottom: 32px;">
                    <span class="section-label">Témoignages</span>
                    <h2 class="section-title">{{ $pageSettings->kids_testimonials_title ?: 'Ils nous font confiance' }}</h2>
                    @if ($pageSettings->kids_testimonials_subtitle)
                        <p class="section-sub">{{ $pageSettings->kids_testimonials_subtitle }}</p>
                    @endif
                </div>
                <div class="testimonials-row">
                    @foreach ($testimonials->take(3) as $testimonial)
                        @include('landing.partials.testimonial-card', ['testimonial' => $testimonial])
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <section class="section">
        <div class="container">
            <div class="catalog-head section-center" style="margin-bottom: 32px;">
                <span class="section-label">{{ $pageSettings->kids_about_label ?: 'À propos des cours' }}</span>
                <h2 class="section-title">{{ $pageSettings->kids_about_title ?: 'À propos des cours' }}</h2>
                @if ($pageSettings->kids_about_subtitle)
                    <p class="section-sub">{{ $pageSettings->kids_about_subtitle }}</p>
                @endif
            </div>
            <div class="suitability-grid">
                @foreach ($pageSettings->kids_about_items ?? [] as $feature)
                    <div class="suitability-item">
                        <span class="check">
                            @if (! empty($feature['icon']))
                                <span style="font-size: 1rem;">{{ $feature['icon'] }}</span>
                            @else
                                <i class="fa-solid fa-check"></i>
                            @endif
                        </span>
                        <p>
                            @if (! empty($feature['title']))
                                <strong style="color: var(--green);">{{ $feature['title'] }}.</strong>
                            @endif
                            {{ $feature['description'] ?? '' }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    @if (filled($pageSettings->kids_curriculum_items))
        <section class="section">
            <div class="container">
                <div class="catalog-head section-center" style="margin-bottom: 32px;">
                    <span class="section-label">{{ $pageSettings->kids_curriculum_label ?: 'Le programme' }}</span>
                    <h2 class="section-title">{{ $pageSettings->kids_curriculum_title ?: '📚 Que va apprendre mon enfant ?' }}</h2>
                    @if ($pageSettings->kids_curriculum_subtitle)
                        <p class="section-sub">{{ $pageSettings->kids_curriculum_subtitle }}</p>
                    @endif
                </div>
                <div class="curriculum-grid">
                    @foreach ($pageSettings->kids_curriculum_items as $subject)
                        <div class="curriculum-card">
                            <div class="icon">{{ $subject['icon'] ?? '' }}</div>
                            <h3>{{ $subject['title'] }}</h3>
                            <p>{{ $subject['description'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <section class="section section-white">
        <div class="container">
            <div class="detail-section" style="margin-bottom: 0;">
                <div class="session-features">
                    <span class="section-label">{{ $pageSettings->kids_journey_label ?: 'Comment ça marche' }}</span>
                    <h2>{{ $pageSettings->kids_journey_title ?: '💡 😊 Comment se déroule la séance ?' }}</h2>
                    @if ($pageSettings->kids_journey_subtitle)
                        <p>{{ $pageSettings->kids_journey_subtitle }}</p>
                    @endif
                    <div class="session-grid">
                        @foreach ($pageSettings->kids_journey_items ?? [] as $feature)
                            <div class="session-card">
                                <div class="session-card-title">{{ $feature['title'] ?? '' }}</div>
                                <p>{!! $feature['description'] ?? '' !!}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section section-white">
        <div class="container">
            <div class="faq-contact-grid">
                <div>
                    <span class="section-label">{{ $pageSettings->kids_faq_label ?: 'Questions fréquentes' }}</span>
                    <h2 class="section-title">{{ $pageSettings->kids_faq_title ?: '❓ Questions fréquentes — Cours enfants' }}</h2>
                    @if ($pageSettings->kids_faq_subtitle)
                        <p class="section-sub">{{ $pageSettings->kids_faq_subtitle }}</p>
                    @endif

                    <div class="faq-list">
                        @foreach ($pageSettings->kids_faq_items ?? [] as $faq)
                            <div class="faq-item">
                                <div class="faq-question" data-faq-toggle>
                                    <span>{{ $faq['question'] ?? '' }}</span>
                                    <div class="faq-arrow"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg></div>
                                </div>
                                <div class="faq-answer">
                                    <div class="faq-answer-inner">
                                        {!! $faq['answer'] ?? '' !!}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if ($pageSettings->kids_faq_cta1_text || $pageSettings->kids_faq_cta2_text)
                        <div class="faq-ctas">
                            @if ($pageSettings->kids_faq_cta1_text)
                                <a href="{{ $pageSettings->kids_faq_cta1_url ?: '#' }}" class="btn-primary" @if ($pageSettings->kids_faq_cta1_url) target="_blank" rel="noopener" @endif>
                                    {{ $pageSettings->kids_faq_cta1_text }}
                                </a>
                            @endif
                            @if ($pageSettings->kids_faq_cta2_text)
                                <a href="{{ $pageSettings->kids_faq_cta2_url ?: '#' }}" class="btn-outline" @if ($pageSettings->kids_faq_cta2_url) target="_blank" rel="noopener" @endif>
                                    {{ $pageSettings->kids_faq_cta2_text }}
                                </a>
                            @endif
                        </div>
                    @endif
                </div>

                <div>
                    @include('landing.partials.contact-card', [
                        'title' => $pageSettings->kids_form_title ?: 'Contactez-nous',
                        'subtitle' => $pageSettings->kids_form_subtitle,
                    ])
                </div>
            </div>
        </div>
    </section>

    @if (count($pageSettings->kids_faq_items ?? []))
        <script type="application/ld+json">
        {
            "@@context": "https://schema.org",
            "@type": "FAQPage",
            "mainEntity": [
                @foreach ($pageSettings->kids_faq_items as $faq)
                {
                    "@type": "Question",
                    "name": @json($faq['question'] ?? ''),
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": @json(strip_tags((string) ($faq['answer'] ?? '')))
                    }
                }@if (! $loop->last),@endif
                @endforeach
            ]
        }
        </script>
    @endif

    <section class="section" style="padding-top: 0;">
        <div class="container">
            <div class="booking-cta">
                <h2>Offrez à votre enfant la meilleure éducation coranique</h2>
                <p>Réservez dès maintenant la séance d'essai gratuite. Notre équipe pédagogique vous contactera dans les 24 heures pour évaluer le niveau de votre enfant et fixer le premier créneau.</p>
                <div class="booking-btn">
                    <a href="{{ route('home') . '#trial-form' }}" class="btn-primary">Réserver une séance d'essai gratuite</a>
                </div>
            </div>
        </div>
    </section>

    @include('landing.partials.footer', ['homeUrl' => route('home')])
    @include('landing.partials.floating')

@endsection