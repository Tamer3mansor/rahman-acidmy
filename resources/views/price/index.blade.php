@extends('layouts.landing')

@section('title', 'Tarifs des cours de Coran et arabe en ligne | Ar-Rahman Academy')

@section('description', 'Tarifs des cours de Coran et arabe en ligne. Cours particuliers à des tarifs clairs et sans engagement. Première séance gratuite.')

@section('bodyClass', 'pattern-bg')

@section('styles')
    @vite(['resources/css/price.css'])
@endsection

@section('scripts')
    @vite(['resources/js/price.js'])
@endsection

@section('content')

    @include('landing.partials.nav', [
        'activePage' => 'price',
        'homeUrl' => route('home'),
    ])

    {{-- Hero --}}
    <section class="section">
        <div class="container section-center">
            <span class="section-label"><i class="fa-solid fa-gift"></i> Première séance gratuite</span>
            <h1 class="section-title">Des offres claires pour apprendre en toute sérénité</h1>
            <p class="section-sub">Un tarif transparent calculé au taux horaire. Choisissez le pack qui convient à votre enfant et commencez dès maintenant.</p>
        </div>

        {{-- Packages grid --}}
        <div class="container">
            <div class="packages-grid" id="packagesGrid" data-wa-phone="{{ $whatsappPhone }}">
                @foreach ($packages as $package)
                    @php($total = $package->effectivePrice())
                    @php($perLesson = $package->ratePerLesson())
                    <article class="package-card {{ $package->is_featured ? 'featured' : '' }}"
                             data-pack-name="{{ $package->name }}"
                             data-classes="{{ $package->classes_count }}"
                             data-price="{{ number_format($total, 2) }}">

                        @if ($package->is_featured)
                            <span class="featured-tag"><i class="fa-solid fa-star"></i> Le plus demandé</span>
                        @endif

                        <div class="pack-header">
                            <h3 class="pack-title">{{ $package->name }}</h3>
                            <span class="badge badge-{{ $package->badge_style }}">{{ $package->badge }}</span>
                        </div>
                        <p class="pack-desc">{{ $package->description }}</p>

                        <div class="pack-classes-box">
                            <div class="pack-classes-count inter-font">{{ $package->classes_count }}</div>
                            <div class="pack-classes-sub">cours particuliers</div>
                        </div>

                        <div class="pack-price-box">
                            <div class="price-main">
                                <span class="price-amount inter-font">{{ number_format($total, 2) }}</span>
                                <span class="price-currency">€</span>
                            </div>
                            <div class="price-per-lesson">soit <span class="per-lesson-val inter-font">{{ number_format($perLesson, 2) }}</span>€ / cours</div>
                        </div>

                        <ul class="pack-features">
                            @foreach ($package->features as $feature)
                                <li><i class="fa-solid fa-check-circle"></i><span>{{ $feature }}</span></li>
                            @endforeach
                        </ul>

                        <button type="button" class="{{ $package->is_featured ? 'btn-primary' : 'btn-outline' }} select-package-btn" data-select-package>
                            <i class="fa-brands fa-whatsapp"></i> Ce pack me convient
                        </button>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Final CTA banner --}}
    <section class="section">
        <div class="container">
            <div class="cta-banner">
                <span class="badge cta-banner-badge">Sans aucun engagement</span>
                <h2 class="cta-banner-title">Vous hésitez sur le pack qui convient à votre enfant ?</h2>
                <p class="cta-banner-sub">Notre équipe pédagogique vous accompagne gratuitement pour évaluer le niveau, choisir le pack adapté et planifier les cours.</p>

                <div class="cta-buttons-group">
                    <a href="{{ $settings->header_btn1_url }}" target="_blank" rel="noopener" class="btn-whatsapp">
                        <i class="fa-brands fa-whatsapp"></i> Discutez avec nous via WhatsApp
                    </a>
                    <a href="{{ route('home') . '#trial-form' }}" class="btn-primary">
                        <i class="fa-solid fa-laptop"></i> Réservez votre essai gratuit
                    </a>
                </div>
            </div>
        </div>
    </section>

    @include('landing.partials.footer')
    @include('landing.partials.floating')

@endsection