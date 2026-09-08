@php
    $shareText = urlencode($post->title);
    $shareUrl = urlencode(route('blog.show', $post->slug));
    $currentUrl = route('blog.show', $post->slug);
@endphp

@extends('layouts.landing')

@section('title', $post->title . ' - ' . $settings->footer_brand_name)

@section('meta_description', $post->excerpt)

@section('bodyClass', 'pattern-bg')

@section('styles')
    @vite(['resources/css/blog.css'])
@endsection

@section('content')

    @include('landing.partials.nav', [
        'activePage' => 'blog',
        'homeUrl' => route('home'),
    ])

    {{-- Structured data (SEO) --}}
    @section('head')
        <link rel="canonical" href="{{ $currentUrl }}">
        <meta property="og:type" content="article">
        <meta property="og:title" content="{{ $post->title }}">
        <meta property="og:description" content="{{ $post->excerpt }}">
        <meta property="og:url" content="{{ $currentUrl }}">
        @if ($post->cover_image_url)
            <meta property="og:image" content="{{ $post->cover_image_url }}">
        @endif
        <script type="application/ld+json">
        {
            "@@context": "https://schema.org",
            "@type": "Article",
            "headline": @json($post->title),
            "image": @json($post->cover_image_url),
            "author": { "@type": "Person", "name": @json($post->author_name) },
            "publisher": { "@type": "Organization", "name": @json($settings->footer_brand_name) },
            "datePublished": @json($post->published_at?->toIso8601String()),
            "description": @json($post->excerpt)
        }
        </script>
    @endsection

    <div class="container">
        <div class="breadcrumbs">
            <a href="{{ route('home') }}">Accueil</a> /
            <a href="{{ route('blog.index') }}">Blog</a> /
            @if ($post->category)
                <a href="{{ route('blog.index', ['k' => $post->category->slug]) }}">{{ $post->category->name }}</a> /
            @endif
            <span>{{ $post->title }}</span>
        </div>

        <div class="article-layout">

            <main class="article-main shadow-card">
                <span class="badge">{{ $post->category?->name }}</span>
                <h1 class="article-title">{{ $post->title }}</h1>

                <div class="article-meta">
                    @if ($post->author_image_url)
                        <img src="{{ $post->author_image_url }}" alt="{{ $post->author_name }}" class="author-img">
                    @endif
                    <div>
                        <strong>{{ $post->author_name }}</strong>
                        <div>Publié le {{ $post->published_at->translatedFormat('j F Y') }} • {{ $post->reading_time }} min de lecture</div>
                    </div>
                </div>

                @if ($post->cover_image_url)
                    <img src="{{ $post->cover_image_url }}" alt="{{ $post->title }}" class="cover-img">
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

                <div class="article-body">
                    {!! $bodyHtml !!}

                    <div class="in-article-cta">
                        <h3>Vous souhaitez un enseignant expérimenté pour accompagner votre enfant ?</h3>
                        <p>Réservez dès maintenant une séance d'essai gratuite avec les meilleurs enseignants du Coran pour enfants.</p>
                        <a href="{{ route('home') . '#trial-form' }}" class="btn-primary"><i class="fa-solid fa-calendar-check"></i> Réserver un essai gratuit</a>
                    </div>
                </div>

                <div class="share-buttons">
                    <span>Partager l'article :</span>
                    <a href="https://wa.me/?text={{ $shareText }}%20{{ $shareUrl }}" class="share-btn share-wa" aria-label="WhatsApp" target="_blank" rel="noopener"><i class="fa-brands fa-whatsapp"></i></a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}" class="share-btn share-fb" aria-label="Facebook" target="_blank" rel="noopener"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="https://twitter.com/intent/tweet?url={{ $shareUrl }}&text={{ $shareText }}" class="share-btn share-tw" aria-label="Twitter" target="_blank" rel="noopener"><i class="fa-brands fa-x-twitter"></i></a>
                </div>

                <div class="author-box">
                    @if ($post->author_image_url)
                        <img src="{{ $post->author_image_url }}" alt="{{ $post->author_name }}" class="author-img">
                    @endif
                    <div>
                        <h4 style="color: var(--green);">À propos de l'auteur : {{ $post->author_name }}</h4>
                        <p style="font-size: 0.9rem; color: var(--text-mid);">Spécialisé dans l'enseignement du Coran et de la langue arabe.</p>
                    </div>
                </div>
            </main>

            <aside>
                <div class="sidebar-widget shadow-card">
                    <h3 class="sidebar-title"><i class="fa-solid fa-graduation-cap"></i> Commencez le parcours de votre enfant</h3>
                    <p style="font-size: 0.95rem; color: var(--text-mid); margin-bottom: 20px;">Donnez à votre enfant les bonnes orientations dès le début pour gagner des années d'essais.</p>

                    <a href="{{ route('home') . '#trial-form' }}" class="btn-primary" style="width: 100%; justify-content: center; margin-bottom: 12px;">
                        <i class="fa-solid fa-laptop"></i> Essai gratuit
                    </a>

                    <a href="{{ $settings->header_btn1_url }}" class="btn-whatsapp" target="_blank" rel="noopener">
                        <i class="fa-brands fa-whatsapp"></i> Contactez-nous via WhatsApp
                    </a>
                </div>
            </aside>

        </div>

        @if ($related->count())
            <section style="margin-top: 60px; padding-top: 40px; border-top: 2px dashed var(--cream-dark);">
                <div style="margin-bottom: 30px;">
                    <span class="section-label">Enrichissement culturel</span>
                    <h2 class="section-title" style="font-size: 1.8rem;">Articles similaires</h2>
                </div>

                <div class="blog-grid">
                    @foreach ($related as $rel)
                        <article class="card">
                            <div class="card-img-wrapper">
                                <img src="{{ $rel->cover_image_url ?? 'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?q=80&w=600&auto=format&fit=crop' }}" alt="{{ $rel->title }}" class="card-img">
                            </div>
                            <div class="card-body">
                                <div class="card-meta">
                                    <span class="badge">{{ $rel->category?->name }}</span>
                                    <span><i class="fa-regular fa-clock"></i> {{ $rel->reading_time }} min</span>
                                </div>
                                <h3 class="card-title">{{ $rel->title }}</h3>
                                <p class="card-excerpt">{{ $rel->excerpt }}</p>
                                <div class="card-footer">
                                    <span class="card-meta"><i class="fa-regular fa-calendar"></i> {{ $rel->published_at->translatedFormat('j F Y') }}</span>
                                    <a href="{{ route('blog.show', $rel->slug) }}" class="btn-outline">Lire l'article</a>
                                </div>
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