@extends('layouts.landing')

@section('title', $pageSettings->meta_title ?: 'Cours de Coran pour enfants en ligne | Ar-Rahman Academy')

@section('description', $pageSettings->meta_description ?: 'Cours de Coran et d\'arabe en ligne pour enfants de 4 à 16 ans. Mémorisation, Tajwid, langue arabe avec des enseignants spécialisés Al-Azhar.')

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

    @php
        $kidsFaqs = [
            ['q' => 'Les cours de Coran pour enfants sont-ils individuels ?', 'a' => 'Oui, les cours sont 100% particuliers : votre enfant travaille seul avec son enseignant, sans groupe ni distraction.'],
            ['q' => 'Comment l\'enseignant est-il choisi ?', 'a' => 'Nous choisissons l\'enseignant en fonction de l\'âge, du niveau et des objectifs de votre enfant. Enseignant pour les garçons et enseignante pour les filles, selon votre préférence.'],
            ['q' => 'Peut-on changer l\'horaire des cours ?', 'a' => 'Oui, sans frais et sans engagement. Nous sommes disponibles 7 jours sur 7, de 7h à 22h, et vous pouvez modifier vos créneaux à tout moment.'],
            ['q' => 'Comment suivre les progrès de mon enfant ?', 'a' => 'Après chaque séance, l\'enseignant envoie un rapport périodique aux parents avec l\'évaluation de la séance, les acquis et les points à travailler.'],
            ['q' => 'La séance d\'essai est-elle gratuite ?', 'a' => 'Oui, la première séance est entièrement gratuite et sans engagement. Vous pourrez évaluer la méthode et l\'enseignant avant de vous inscrire.'],
            ['q' => 'Quelles sont les qualifications des enseignants ?', 'a' => 'Tous nos enseignants sont diplômés de l\'Al-Azhar et titulaires d\'Ijazah certifiées en Tajwid, avec une expérience confirmée dans l\'enseignement des enfants.'],
        ];

        $kidsSubjects = [
            ['icon' => '📖', 'title' => 'Récitation du Coran', 'description' => 'Une lecture correcte, fluide et appliquée, lettre par lettre, dès le premier jour.'],
            ['icon' => '🎵', 'title' => 'Tajwid', 'description' => 'Les règles de récitation enseignées de façon ludique et progressive, adaptées à chaque âge.'],
            ['icon' => '🧠', 'title' => 'Mémorisation', 'description' => 'Un programme de mémorisation (Hifz) structuré avec révision continue des sourates apprises.'],
            ['icon' => '🗣️', 'title' => 'Langue arabe', 'description' => 'Le vocabulaire, la lecture et la conversation en arabe avec une méthode simple et interactive.'],
            ['icon' => '🤲', 'title' => 'Invocations', 'description' => 'Les invocations quotidiennes et adhkar du matin et du soir mémorisés avec leur signification.'],
            ['icon' => '🌿', 'title' => 'Valeurs islamiques', 'description' => 'Les bonnes manières, le respect des parents et les valeurs de l\'Islam enseignées avec bienveillance.'],
        ];

        $kidsSessionFeatures = [
            ['title' => '👨‍🏫 Enseignant dédié', 'description' => 'Un même enseignant suit votre enfant toute l\'année pour assurer une continuité et une relation de confiance.'],
            ['title' => '💻 Séance interactive', 'description' => 'Une plateforme en ligne sûre, avec partage d\'écran, exercices visuels et outils pédagogiques.'],
            ['title' => '🏠 Sans déplacement', 'description' => 'Votre enfant apprend depuis la maison, à un horaire choisi selon votre emploi du temps familial.'],
            ['title' => '📝 Suivi parental', 'description' => 'Un rapport après chaque séance pour suivre la progression, les points forts et les points à améliorer.'],
            ['title' => '⏰ Horaires flexibles', 'description' => 'Disponibilité 7 jours sur 7, de 7h à 22h, avec possibilité de modifier les créneaux à tout moment.'],
        ];
    @endphp

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
                <div class="emojis">📖 ✨</div>
                <div class="hero-showcase-title">Un environnement d'apprentissage joyeux, conçu pour l'enfant</div>
                <div class="hero-showcase-sub">Suivi précis avec des rapports périodiques pour les parents après chaque séance.</div>
            </div>
        </div>
    </section>

    <div class="container">
        <nav class="breadcrumbs" aria-label="breadcrumb">
            <a href="{{ route('home') }}">Accueil</a> /
            <span aria-current="page">Cours enfants</span>
        </nav>
    </div>

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
                                <span class="icon">{{ $course->icon }}</span>
                                <h3>{{ $course->title }}</h3>
                            </div>
                            <div class="course-card-body">
                                <div class="course-meta">
                                    <span class="meta-badge">
                                        @if ($course->ageBandLabel())
                                            <i class="fa-solid fa-child"></i> Âge : {{ $course->ageBandLabel() }}
                                        @elseif ($course->level_label)
                                            <i class="fa-solid fa-gauge-high"></i> {{ $course->level_label }}
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
                <span class="section-label">Pour les parents</span>
                <h2 class="section-title">🎯 Ce cours convient-il à mon enfant ?</h2>
                <p class="section-sub">Nos programmes sont conçus pour répondre aux besoins spécifiques des enfants et des familles.</p>
            </div>
            <div class="suitability-grid">
                <div class="suitability-item"><span class="check"><i class="fa-solid fa-check"></i></span><p>Apprentissage 100% en ligne, sans déplacement ni perte de temps</p></div>
                <div class="suitability-item"><span class="check"><i class="fa-solid fa-check"></i></span><p>Enseignant dédié qui s'adapte à la personnalité et au rythme de votre enfant</p></div>
                <div class="suitability-item"><span class="check"><i class="fa-solid fa-check"></i></span><p>Méthode ludique, positive et bienveillante qui motive l'enfant</p></div>
                <div class="suitability-item"><span class="check"><i class="fa-solid fa-check"></i></span><p>Rapports périodiques aux parents pour suivre chaque séance</p></div>
                <div class="suitability-item"><span class="check"><i class="fa-solid fa-check"></i></span><p>Horaires flexibles compatibles avec l'école et les activités familiales</p></div>
                <div class="suitability-item"><span class="check"><i class="fa-solid fa-check"></i></span><p>Enseignant pour les garçons et enseignante pour les filles, selon votre préférence</p></div>
                <div class="suitability-item"><span class="check"><i class="fa-solid fa-check"></i></span><p>Programme personnalisé selon l'âge, le niveau et les objectifs de l'enfant</p></div>
                <div class="suitability-item"><span class="check"><i class="fa-solid fa-check"></i></span><p>Première séance d'essai gratuite et sans engagement</p></div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="catalog-head section-center" style="margin-bottom: 32px;">
                <span class="section-label">Le programme</span>
                <h2 class="section-title">📚 Que va apprendre mon enfant ?</h2>
                <p class="section-sub">Un programme complet qui couvre le Coran, la langue arabe et l'éducation islamique.</p>
            </div>
            <div class="curriculum-grid">
                @foreach ($kidsSubjects as $subject)
                    <div class="curriculum-card">
                        <div class="icon">{{ $subject['icon'] }}</div>
                        <h3>{{ $subject['title'] }}</h3>
                        <p>{{ $subject['description'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section section-white">
        <div class="container">
            <div class="detail-section" style="margin-bottom: 0;">
                <div class="session-features">
                    <h2>💡 😊 Comment se déroule la séance ?</h2>
                    <p>Nous garantissons une expérience interactive, sûre et motivante à chaque séance :</p>
                    <div class="session-grid">
                        @foreach ($kidsSessionFeatures as $feature)
                            <div class="session-card">
                                <div class="session-card-title">{{ $feature['title'] }}</div>
                                <p>{{ $feature['description'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="catalog-head section-center">
                <span class="section-label">Questions fréquentes</span>
                <h2 class="section-title">❓ Questions fréquentes — Cours enfants</h2>
                <p class="section-sub">Toutes les réponses aux questions que se posent les parents avant de commencer.</p>
            </div>

            <div class="faq-list" style="margin: 0 auto;">
                @foreach ($kidsFaqs as $faq)
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
            @foreach ($kidsFaqs as $faq)
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