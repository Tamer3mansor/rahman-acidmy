@extends('layouts.landing')

@section('title', $pageSettings->meta_title ?: 'Cours de Coran et Tajwid pour adultes en ligne en France, Belgique et Canada | Ar-Rahman Academy')

@section('description', $pageSettings->meta_description ?: 'Cours de Coran, Tajwid et arabe pour adultes en France, Belgique et Canada. Apprentissage personnalisé, horaires flexibles 7j/7, enseignants diplômés Al-Azhar avec Ijazah.')

@if ($pageSettings->og_image)
    @php
        $adultsOgImage = \Illuminate\Support\Str::startsWith($pageSettings->og_image, ['http://', 'https://'])
            ? $pageSettings->og_image
            : asset('storage/'.$pageSettings->og_image);
    @endphp
    @section('og_image', $adultsOgImage)
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
                "name": "Cours adultes",
                "item": "{{ config('seo.url') }}/adultes"
            }
        ]
    }
    </script>
@endsection

@section('content')

    @php
        $adultsFaqs = [
            ['q' => 'Puis-je apprendre le Coran à mon rythme ?', 'a' => 'Oui. Après une évaluation initiale, l\'enseignant établit un plan d\'étude personnalisé, adapté à votre niveau, vos objectifs et votre emploi du temps.'],
            ['q' => 'Les cours pour adultes sont-ils individuels ?', 'a' => 'Oui, les cours sont 100% particuliers : vous travaillez seul avec un enseignant (homme) ou une enseignante (femme), selon votre préférence.'],
            ['q' => 'Y a-t-il un engagement ou un contrat ?', 'a' => 'Non. Sans contrat ni frais d\'annulation : vous pouvez modifier ou annuler vos cours à tout moment.'],
            ['q' => 'Comment se déroule la correction de la récitation (Tajwid) ?', 'a' => 'L\'enseignant écoute votre récitation, corrige les erreurs lettre par lettre et applique les règles de Tajwid de façon progressive et pratique.'],
            ['q' => 'Quelles sont les qualifications des enseignants ?', 'a' => 'Tous nos enseignants sont diplômés de l\'Al-Azhar et titulaires d\'Ijazah certifiées en Tajwid, avec une expérience confirmée dans l\'enseignement des adultes.'],
        ];

        $adultsWhyUs = [
            ['icon' => '👨‍🏫', 'title' => 'Enseignants Al-Azhar', 'description' => 'Diplômés de l\'Al-Azhar et titulaires d\'Ijazah, avec une expérience confirmée dans l\'enseignement des adultes.'],
            ['icon' => '🕰️', 'title' => 'Horaires flexibles', 'description' => 'Cours disponibles 7 jours sur 7, de 7h à 22h, avec la possibilité de les déplacer gratuitement à tout moment.'],
            ['icon' => '🎯', 'title' => 'Plan personnalisé', 'description' => 'Un programme d\'étude sur mesure, établi après évaluation de votre niveau, pour progresser efficacement vers votre objectif.'],
            ['icon' => '📊', 'title' => 'Suivi continu', 'description' => 'Une évaluation régulière de votre progression avec des objectifs clairs à chaque étape de votre parcours.'],
        ];

        $adultsSteps = [
            ['title' => 'Réservez votre essai', 'description' => 'Une séance d\'essai gratuite pour découvrir la méthode et rencontrer votre enseignant.'],
            ['title' => 'Évaluation du niveau', 'description' => 'L\'enseignant évalue votre récitation, votre niveau en arabe et vos objectifs.'],
            ['title' => 'Plan d\'étude', 'description' => 'Un programme personnalisé est défini : matière, durée, horaires et fréquence des séances.'],
            ['title' => 'Progression suivie', 'description' => 'Des cours réguliers avec un suivi détaillé de vos acquis et de vos points de progression.'],
        ];
    @endphp

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
                <div class="emojis">{{ $pageSettings->adults_showcase_emoji ?? '📖' }}</div>
                <div class="hero-showcase-title">{{ $pageSettings->adults_showcase_title ?? 'Flexibilité et maîtrise pour les adultes' }}</div>
                <div class="hero-showcase-sub">{{ $pageSettings->adults_showcase_subtitle ?? "Des plans d'étude adaptés à votre emploi du temps, avec un enseignant pour les hommes et une enseignante pour les femmes." }}</div>
            </div>
        </div>
    </section>

    <div class="container">
        <nav class="breadcrumbs" aria-label="breadcrumb">
            <a href="{{ route('home') }}">Accueil</a> /
            <span aria-current="page">Cours adultes</span>
        </nav>
    </div>

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

    <section class="section section-white">
        <div class="container">
            <div class="catalog-head section-center" style="margin-bottom: 32px;">
                <span class="section-label">Pourquoi Ar-Rahman Academy</span>
                <h2 class="section-title">🎯 Pourquoi nous choisir pour apprendre le Coran ?</h2>
                <p class="section-sub">Une méthode éprouvée, des enseignants qualifiés et une flexibilité totale pour les adultes.</p>
            </div>
            <div class="suitability-grid">
                @foreach ($adultsWhyUs as $feature)
                    <div class="suitability-item">
                        <span class="check"><span style="font-size: 1rem;">{{ $feature['icon'] }}</span></span>
                        <p><strong style="color: var(--green);">{{ $feature['title'] }}.</strong> {{ $feature['description'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="catalog-head section-center" style="margin-bottom: 32px;">
                <span class="section-label">Comment ça marche</span>
                <h2 class="section-title">🚀 Comment se déroule votre parcours</h2>
                <p class="section-sub">Quatre étapes simples entre vous et votre objectif d'apprentissage du Coran.</p>
            </div>
            <div class="journey-steps">
                @foreach ($adultsSteps as $step)
                    <div class="step-card">
                        <div class="journey-step-num {{ $loop->iteration % 2 === 0 ? 'dark-green' : 'gold' }}">{{ $loop->iteration }}</div>
                        <h4>{{ $step['title'] }}</h4>
                        <p>{{ $step['description'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section section-white">
        <div class="container">
            <div class="catalog-head section-center">
                <span class="section-label">Questions fréquentes</span>
                <h2 class="section-title">❓ Questions fréquentes — Cours adultes</h2>
                <p class="section-sub">Toutes les réponses aux questions des adultes avant de commencer leur apprentissage.</p>
            </div>

            <div class="faq-list" style="margin: 0 auto;">
                @foreach ($adultsFaqs as $faq)
                    <div class="faq-item">
                        <div class="faq-question" data-faq-toggle>
                            <span>{{ $faq['q'] }}</span>
                            <div class="faq-arrow"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg></div>
                        </div>
                        <div class="faq-answer">
                            <div class="faq-answer-inner">
                                {{ $faq['a'] }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@type": "FAQPage",
        "mainEntity": [
            @foreach ($adultsFaqs as $faq)
            {
                "@type": "Question",
                "name": @json($faq['q']),
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": @json($faq['a'])
                }
            }@if (! $loop->last),@endif
            @endforeach
        ]
    }
    </script>

    <section class="section" style="padding-top: 0;">
        <div class="container">
            <div class="booking-cta">
                <h2>Commencez votre apprentissage du Coran dès aujourd'hui</h2>
                <p>Réservez votre séance d'essai gratuite. Votre enseignant vous contactera dans les 24 heures pour évaluer votre niveau et définir votre plan d'étude personnalisé.</p>
                <div class="booking-btn">
                    <a href="{{ route('home') . '#trial-form' }}" class="btn-primary">Réserver ma séance d'essai gratuite</a>
                </div>
            </div>
        </div>
    </section>

    @include('landing.partials.footer', ['homeUrl' => route('home')])
    @include('landing.partials.floating')

@endsection