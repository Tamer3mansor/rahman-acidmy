@extends('layouts.landing')

@section('title', 'Blog islamique - Coran, Tajwid et arabe | Ar-Rahman Academy')

@section('description', 'Blog islamique | Ar-Rahman Academy. Articles sur l\'apprentissage du Coran, le Tajwid, la langue arabe et l\'éducation islamique.')

@section('bodyClass', 'pattern-bg')

@section('styles')
    @vite(['resources/css/blog.css'])
@endsection

@section('content')

    @include('landing.partials.nav', [
        'activePage' => 'blog',
        'homeUrl' => route('home'),
    ])

    <section class="section">
        <div class="container section-center">
            <span class="section-label">Blog éducatif</span>
            <h1 class="section-title">Derniers articles et conseils éducatifs</h1>
            <p class="section-sub">Votre guide complet pour la mémorisation du Coran et l'apprentissage de la langue arabe pour enfants et adultes avec des méthodes modernes.</p>

            <div class="filter-bar">
                <a href="{{ route('blog.index') }}" class="filter-btn {{ $activeCategorySlug === null ? 'active' : '' }}">Tous</a>
                @foreach ($categories as $category)
                    <a href="{{ route('blog.index', ['k' => $category->slug]) }}" class="filter-btn {{ $activeCategorySlug === $category->slug ? 'active' : '' }}">{{ $category->name }}</a>
                @endforeach
            </div>
        </div>

        <div class="container">
            @if ($featured && $activeCategorySlug === null)
                <div class="featured-card shadow-card">
                    <img src="{{ $featured->cover_image_url ?? 'https://images.unsplash.com/photo-1584286595398-a59f21d313f5?q=80&w=800&auto=format&fit=crop' }}" alt="{{ $featured->title }}" class="featured-img">
                    <div class="featured-content">
                        <div>
                            <span class="badge gold"><i class="fa-solid fa-thumbtack"></i> Article vedette</span>
                            <span class="badge">{{ $featured->category?->name }}</span>
                        </div>
                        <h2 class="card-title">{{ $featured->title }}</h2>
                        <p class="card-excerpt">{{ $featured->excerpt }}</p>
                        <div class="card-meta">
                            <span><i class="fa-regular fa-user"></i> {{ $featured->author_name }}</span>
                            <span><i class="fa-regular fa-calendar"></i> {{ $featured->published_at->translatedFormat('j F Y') }}</span>
                        </div>
                        <div>
                            <a href="{{ route('blog.show', $featured->slug) }}" class="btn-primary">Lire l'article complet <i class="fa-solid fa-arrow-left"></i></a>
                        </div>
                    </div>
                </div>
            @endif

            @if ($posts->count())
                <div class="blog-grid">
                    @foreach ($posts as $post)
                        <article class="card">
                            <div class="card-img-wrapper">
                                <img src="{{ $post->cover_image_url ?? 'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?q=80&w=600&auto=format&fit=crop' }}" alt="{{ $post->title }}" class="card-img">
                            </div>
                            <div class="card-body">
                                <div class="card-meta">
                                    <span class="badge">{{ $post->category?->name }}</span>
                                    <span><i class="fa-regular fa-clock"></i> {{ $post->reading_time }} min</span>
                                </div>
                                <h3 class="card-title">{{ $post->title }}</h3>
                                <p class="card-excerpt">{{ $post->excerpt }}</p>
                                <div class="card-footer">
                                    <span class="card-meta"><i class="fa-regular fa-calendar"></i> {{ $post->published_at->translatedFormat('j F Y') }}</span>
                                    <a href="{{ route('blog.show', $post->slug) }}" class="btn-outline" style="padding: 6px 14px; font-size:0.85rem;">Lire la suite</a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                @if ($posts->hasPages())
                    <div class="pagination">
                        @if ($posts->onFirstPage())
                            <span class="page-link"><i class="fa-solid fa-angle-right"></i></span>
                        @else
                            <a href="{{ $posts->previousPageUrl() }}" class="page-link" rel="prev"><i class="fa-solid fa-angle-right"></i></a>
                        @endif

                        @foreach ($posts->getUrlRange(1, $posts->lastPage()) as $page => $url)
                            <a href="{{ $url }}" class="page-link {{ $page === $posts->currentPage() ? 'active' : '' }}">{{ $page }}</a>
                        @endforeach

                        @if ($posts->hasMorePages())
                            <a href="{{ $posts->nextPageUrl() }}" class="page-link" rel="next"><i class="fa-solid fa-angle-left"></i></a>
                        @else
                            <span class="page-link"><i class="fa-solid fa-angle-left"></i></span>
                        @endif
                    </div>
                @endif
            @else
                <p class="section-center" style="color: var(--text-mid); padding: 40px 0;">Aucun article dans cette catégorie pour le moment.</p>
            @endif
        </div>
    </section>

    @include('landing.partials.footer')
    @include('landing.partials.floating')

@endsection