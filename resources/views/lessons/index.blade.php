@extends('layouts.landing')

@section('title', 'Leçons gratuites - Exemples et explications | ' . $settings->footer_brand_name)

@section('meta_description', 'Découvrez notre méthode d\'explication et la qualité de notre enseignement : des leçons et des exemples gratuits de tajwid, de lecture et de langue arabe, simplifiés avec l\'audio et les visuels.')

@section('bodyClass', 'pattern-bg')

@section('styles')
    @vite(['resources/css/lessons.css'])
@endsection

@section('content')

    @include('landing.partials.nav', [
        'activePage' => 'lessons',
        'homeUrl' => route('home'),
    ])

    <section class="section lessons-hero">
        <div class="container section-center">
            <span class="section-label">Exemples et explications gratuits</span>
            <h1 class="section-title">Découvrez par vous-même notre méthode et la qualité de l'enseignement</h1>
            <p class="section-sub">Un ensemble d'exemples et de mini-leçons qui expliquent le tajwid, la lecture et la langue arabe d'une façon simplifiée, soutenue par l'audio et les visuels.</p>
        </div>
    </section>

    <div class="container">
        <div class="filter-bar">
            <a href="{{ route('lessons.index') }}" class="filter-btn {{ $activeCategory === null ? 'active' : '' }}">Tous</a>
            @foreach ($categories as $category)
                <a href="{{ route('lessons.index', ['k' => $category->value]) }}" class="filter-btn {{ $activeCategory?->value === $category->value ? 'active' : '' }}">{{ $category->getLabel() }}</a>
            @endforeach
        </div>

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
                                <span class="badge">{{ $lesson->category->getLabel() }}</span>
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
        @else
            <p class="section-center" style="color: var(--text-mid); padding: 40px 0;">Aucune leçon dans cette catégorie pour le moment.</p>
        @endif
    </div>

    <div style="height: 60px;"></div>

    @include('landing.partials.footer')
    @include('landing.partials.floating')

@endsection