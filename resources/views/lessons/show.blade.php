@php
    $course = $lesson->course;
    $trialUrl = $course ? route('courses.show', $course->slug) : route('home').'#trial-form';
    $currentUrl = route('lessons.show', $lesson->slug);
@endphp

@extends('layouts.landing')

@section('title', $lesson->title . ' - ' . $settings->footer_brand_name)

@section('description', $lesson->excerpt)

@section('bodyClass', 'pattern-bg')

@section('styles')
    @vite(['resources/css/lessons.css'])
@endsection

@section('content')

    @include('landing.partials.nav', [
        'activePage' => 'lessons',
        'homeUrl' => route('home'),
    ])

    {{-- Structured data (SEO) --}}
    @section('head')
        @if ($lesson->cover_image_url)
            @section('og_image', $lesson->cover_image_url)
        @endif
        <script type="application/ld+json">
        {
            "@@context": "https://schema.org",
            "@type": "Article",
            "headline": @json($lesson->title),
            "image": @json($lesson->cover_image_url),
            "publisher": { "@type": "Organization", "name": @json($settings->footer_brand_name) },
            "description": @json($lesson->excerpt),
            "dateModified": @json($lesson->updated_at?->toIso8601String())
        }
        </script>
    @endsection

    <div class="container">
        <div class="breadcrumbs">
            <a href="{{ route('home') }}">Accueil</a> /
            <a href="{{ route('lessons.index') }}">Leçons gratuites</a> /
            <span>{{ $lesson->title }}</span>
        </div>

        <div class="article-layout">

            <main class="article-main shadow-card">
                <div class="article-meta">
                    @if ($course)
                        <span class="badge gold"><i class="fa-solid fa-graduation-cap"></i> Lié au cours : {{ $course->title }}</span>
                    @endif
                    @if ($lesson->category)
                        <span class="badge">{{ \App\Enums\LessonCategory::tryFrom($lesson->category)?->getLabel() ?? $lesson->category }}</span>
                    @endif
                    @if ($lesson->reading_time)
                        <span class="article-meta-item"><i class="fa-regular fa-clock"></i> Temps de lecture estimé : {{ $lesson->reading_time }} min</span>
                    @endif
                    <span class="article-meta-item"><i class="fa-regular fa-calendar"></i> Mis à jour : {{ $lesson->updated_at?->translatedFormat('F Y') }}</span>
                </div>

                <h1 class="article-title">{{ $lesson->title }}</h1>
                <p class="article-excerpt">{{ $lesson->excerpt }}</p>

                @if ($lesson->cover_image_url)
                    <img src="{{ $lesson->cover_image_url }}" alt="{{ $lesson->title }}" class="cover-img">
                @endif

                @if ($lesson->pdf_download_url)
                    <div class="lesson-pdf-block">
                        <div>
                            <i class="fa-solid fa-file-pdf pdf-icon"></i>
                            <div>
                                <strong>Fiche PDF de la leçon</strong>
                                <p>Imprimez ou téléchargez cette leçon pour la réviser hors ligne.</p>
                            </div>
                        </div>
                        <a href="{{ $lesson->pdf_download_url }}" class="btn-primary" download target="_blank" rel="noopener">
                            <i class="fa-solid fa-download"></i> Télécharger le PDF
                        </a>
                    </div>
                @endif

                @if ($toc)
                    <div class="toc">
                        <h4><i class="fa-solid fa-list-ul"></i> Sommaire :</h4>
                        <ul>
                            @foreach ($toc as $entry)
                                <li><a href="#{{ $entry['id'] }}">{{ $loop->iteration }}. {{ $entry['text'] }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="article-body lesson-body">
                    {!! $bodyHtml !!}

                    <div class="in-article-cta">
                        <span class="badge gold"><i class="fa-solid fa-rocket"></i> Application pratique directe</span>
                        <h3>Aimez-vous notre méthode d'explication ?</h3>
                        <p>Réservez une séance d'essai en direct avec un enseignant spécialisé pour appliquer ces leçons avec votre enfant, étape par étape.</p>
                        <a href="{{ $trialUrl }}" class="btn-primary"><i class="fa-solid fa-calendar-check"></i> {{ $course ? 'Découvrir la formation complète' : "Réserver l'essai gratuit" }}</a>
                    </div>
                </div>
            </main>

            <aside>
                <div class="sidebar-widget shadow-card">
                    <h3 class="sidebar-title"><i class="fa-solid fa-graduation-cap"></i> {{ $pageSettings->sidebar_title ?: 'Commencez le parcours de votre enfant' }}</h3>
                    <p style="font-size: 0.95rem; color: var(--text-mid); margin-bottom: 20px;">{{ $pageSettings->sidebar_text ?: "Donnez à votre enfant les bonnes orientations dès le début pour gagner des années d'essais." }}</p>

                    <a href="{{ $pageSettings->sidebar_trial_url ?: route('home') . '#trial-form' }}" class="btn-primary" style="width: 100%; justify-content: center; margin-bottom: 12px;">
                        <i class="fa-solid fa-laptop"></i> {{ $pageSettings->sidebar_trial_label ?: 'Essai gratuit' }}
                    </a>

                    <a href="{{ $pageSettings->sidebar_whatsapp_url ?: $settings->header_btn1_url }}" class="btn-whatsapp" target="_blank" rel="noopener">
                        <i class="fa-brands fa-whatsapp"></i> {{ $pageSettings->sidebar_whatsapp_label ?: 'Contactez-nous via WhatsApp' }}
                    </a>
                </div>
            </aside>

        </div>

        @if ($lesson->audio_url)
            <section class="lesson-audio-block shadow-card">
                <span class="section-label">Fichier audio de la leçon</span>
                <h2 class="section-title" style="font-size: 1.6rem;">Écoutez la prononciation présentée dans ce modèle</h2>
                <audio controls class="audio-player">
                    <source src="{{ $lesson->audio_download_url }}">
                    Votre navigateur ne prend pas en charge le lecteur audio.
                </audio>
            </section>
        @endif

        @if ($related->count())
            <section style="margin-top: 60px; padding-top: 40px; border-top: 2px dashed var(--cream-dark);">
                <div style="margin-bottom: 30px;">
                    <span class="section-label">Enrichissez votre apprentissage</span>
                    <h2 class="section-title" style="font-size: 1.8rem;">Leçons recommandées</h2>
                </div>

                <div class="lessons-grid">
                    @foreach ($related as $rel)
                        <article class="card">
                            <div class="card-img-wrapper">
                                <img src="{{ $rel->cover_image_url ?? 'https://images.unsplash.com/photo-1585036156171-384164a8c675?q=80&w=600&auto=format&fit=crop' }}" alt="{{ $rel->title }}" class="card-img">
                                @if ($rel->course)
                                    <span class="badge gold lesson-badge"><i class="fa-solid fa-graduation-cap"></i> {{ $rel->course->title }}</span>
                                @endif
                            </div>
                            <div class="card-body">
                                <div class="card-meta">
                                    <span class="badge">{{ \App\Enums\LessonCategory::tryFrom($rel->category)?->getLabel() ?? $rel->category }}</span>
                                    <span><i class="fa-regular fa-clock"></i> {{ $rel->reading_time }} min</span>
                                    @if ($rel->audio_url)
                                        <span><i class="fa-solid fa-headphones"></i> Fichier audio</span>
                                    @endif
                                </div>
                                <h3 class="card-title">{{ $rel->title }}</h3>
                                <p class="card-excerpt">{{ $rel->excerpt }}</p>
                                <a href="{{ route('lessons.show', $rel->slug) }}" class="btn-outline lesson-cta">Consulter la leçon complète <i class="fa-solid fa-arrow-left"></i></a>
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>
        @endif
    </div>

    <div style="height: 60px;"></div>

    @include('landing.partials.footer')
    @include('landing.partials.floating')

@endsection