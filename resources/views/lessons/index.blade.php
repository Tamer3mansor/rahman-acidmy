@extends('layouts.landing')

@section('title', 'Leçons gratuites - Exemples et explications | ' . $settings->footer_brand_name)

@section('description', 'Leçons gratuites de Coran, Tajwid et langue arabe en ligne pour enfants et adultes en France, Belgique et Canada. Découvrez notre méthode d\'enseignement avec des exemples et explications simplifiés.')

@section('bodyClass', 'pattern-bg')

@section('styles')
    @vite(['resources/css/lessons.css'])
@endsection

@section('content')

    @include('landing.partials.nav', [
        'activePage' => 'lessons',
        'homeUrl' => route('home'),
    ])

    <section class="section page-hero lessons-hero">
        <div class="container section-center">
            <span class="section-label">Exemples et explications gratuits</span>
            <h1 class="section-title">Découvrez par vous-même notre méthode et la qualité de l'enseignement</h1>
            <p class="section-sub">Un ensemble d'exemples et de mini-leçons qui expliquent le tajwid, la lecture et la langue arabe d'une façon simplifiée, soutenue par l'audio et les visuels.</p>

            @include('landing.partials.search-form', [
                'searchAction' => route('lessons.index'),
                'searchTerm' => $search,
                'searchHidden' => array_filter(['k' => $activeCategory?->value]),
                'searchClearUrl' => route('lessons.index', ['k' => $activeCategory?->value]),
                'searchPlaceholder' => 'Rechercher une leçon…',
            ])
        </div>
    </section>

    <div class="container">
        <div class="filter-bar">
            <a href="{{ route('lessons.index', ['q' => $search]) }}" class="filter-btn {{ $activeCategory === null ? 'active' : '' }}">Tous</a>
            @foreach ($categories as $category)
                <a href="{{ route('lessons.index', ['k' => $category->value, 'q' => $search]) }}" class="filter-btn {{ $activeCategory?->value === $category->value ? 'active' : '' }}">{{ $category->getLabel() }}</a>
            @endforeach
        </div>

        @if ($lessons->total())
            <p class="results-count">
                <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
                <span><strong>{{ $lessons->total() }}</strong> {{ $lessons->total() > 1 ? 'leçons trouvées' : 'leçon trouvée' }}</span>
                @if ($search !== null)
                    <span class="results-count-term">« {{ $search }} »</span>
                @endif
            </p>
        @endif

        @if ($lessons->count())
            <div class="lessons-grid">
                @foreach ($lessons as $lesson)
                    <article class="card">
                        <div class="card-img-wrapper">
                            <img src="{{ $lesson->cover_image_url ?? 'https://images.unsplash.com/photo-1585036156171-384164a8c675?q=80&w=600&auto=format&fit=crop' }}" alt="{{ $lesson->title }}" class="card-img">
                            @if ($lesson->course)
                                <span class="badge gold lesson-badge"><i class="fa-solid fa-graduation-cap"></i> {{ $lesson->course->title }}</span>
                            @endif
                        </div>
                        <div class="card-body">
                            <div class="card-meta">
                                <span class="badge">{{ \App\Enums\LessonCategory::tryFrom($lesson->category)?->getLabel() ?? $lesson->category }}</span>
                                <span><i class="fa-regular fa-clock"></i> {{ $lesson->reading_time }} min</span>
                                @if ($lesson->audio_url)
                                    <span><i class="fa-solid fa-headphones"></i> Fichier audio</span>
                                @endif
                            </div>
                            <h3 class="card-title">{{ $lesson->title }}</h3>
                            <p class="card-excerpt">{{ $lesson->excerpt }}</p>
                            <a href="{{ route('lessons.show', $lesson->slug) }}" class="btn-outline lesson-cta">Consulter la leçon complète <i class="fa-solid fa-arrow-left"></i></a>
                        </div>
                    </article>
                @endforeach
            </div>

            @include('landing.partials.pagination', ['paginator' => $lessons])
        @else
            <p class="empty-state">
                @if ($search !== null)
                    Aucune leçon ne correspond à votre recherche.
                @else
                    Aucune leçon dans cette catégorie pour le moment.
                @endif
            </p>
        @endif
    </div>

    <div style="height: 60px;"></div>

    @include('landing.partials.footer')
    @include('landing.partials.floating')

@endsection