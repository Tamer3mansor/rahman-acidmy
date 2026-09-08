@extends('layouts.landing')

@section('title', 'Nos tarifs - Académie Coran et Langue Arabe')

@section('meta_description', 'Des offres claires pour l\'apprentissage du Coran et de la langue arabe en ligne. Choisissez la durée de cours qui convient et commencez avec un essai gratuit.')

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

    {{-- Hero & duration selector --}}
    <section class="section">
        <div class="container section-center">
            <span class="section-label"><i class="fa-solid fa-gift"></i> Première séance gratuite</span>
            <h1 class="section-title">Des offres claires pour apprendre en toute sérénité</h1>
            <p class="section-sub">Plus le nombre de cours augmente, plus le tarif unitaire diminue. Choisissez la durée qui convient à votre enfant et commencez dès maintenant.</p>

            <div class="duration-hint">Choisissez la durée du cours :</div>
            <div class="duration-picker-wrapper" id="durationPicker">
                @foreach ($durations as $duration)
                    <button type="button" class="duration-btn {{ $loop->first ? 'active' : '' }}" data-duration="{{ $duration }}">{{ $duration }} min</button>
                @endforeach
            </div>
        </div>

        {{-- Packages grid --}}
        <div class="container">
            <div class="packages-grid" id="packagesGrid" data-wa-phone="{{ $whatsappPhone }}">
                @foreach ($packages as $package)
                    <article class="package-card {{ $package->is_featured ? 'featured' : '' }}"
                             data-pack-name="{{ $package->name }}"
                             data-classes="{{ $package->classes_count }}"
                             data-price-30="{{ number_format($package->totalFor(30), 2) }}"
                             data-price-45="{{ number_format($package->totalFor(45), 2) }}"
                             data-price-60="{{ number_format($package->totalFor(60), 2) }}">

                        @if ($package->is_featured)
                            <span class="featured-tag"><i class="fa-solid fa-star"></i> Le plus demandé</span>
                        @endif

                        <div class="pack-header">
                            <h3 class="pack-title">{{ $package->name }}</h3>
                            <span class="badge badge-{{ $package->badge_style }}">{{ $package->badge }}</span>
                        </div>
                        <p class="pack-desc">{{ $package->description }}</p>

                        <div class="pack-classes-box">
                            <div class="pack-classes-count inter-font">{{ $package->classes_count }} {{ $package->classes_count >= 3 && $package->classes_count <= 10 ? 'cours' : 'cours' }}</div>
                            <div class="pack-classes-sub duration-label-text"
                                 data-duration-label-30="de 30 minutes par cours"
                                 data-duration-label-45="de 45 minutes par cours"
                                 data-duration-label-60="de 60 minutes par cours">de 30 minutes par cours</div>
                        </div>

                        <div class="pack-price-box">
                            @foreach ($durations as $duration)
                                @php($savings = $package->savingsFor($duration))
                                <div class="price-duration" data-duration="{{ $duration }}" @if ($duration !== 30) hidden @endif>
                                    <div class="price-main">
                                        <span class="price-amount inter-font">{{ number_format($package->totalFor($duration), 2) }}</span>
                                        <span class="price-currency">€</span>
                                        @if ($savings > 0)
                                            <span class="price-original inter-font">{{ number_format($package->originalFor($duration), 2) }}€</span>
                                        @endif
                                    </div>
                                    <div class="price-per-lesson">soit <span class="per-lesson-val inter-font">{{ number_format($package->rateFor($duration), 2) }}</span>€ / cours</div>
                                    @if ($savings > 0)
                                        <div class="savings-pill">Économie de <span class="savings-val inter-font">{{ number_format($savings, 2) }}</span>€</div>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        <ul class="pack-features">
                            @foreach ($package->features as $feature)
                                <li><i class="fa-solid fa-check-circle"></i>
                                    @if ($feature === 'Durée du cours au choix')
                                        <span class="duration-label-text"
                                              data-duration-label-30="Durée du cours : 30 minutes"
                                              data-duration-label-45="Durée du cours : 45 minutes"
                                              data-duration-label-60="Durée du cours : 60 minutes">Durée du cours : 30 minutes</span>
                                    @else
                                        <span>{{ $feature }}</span>
                                    @endif
                                </li>
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

    {{-- Included in all packages --}}
    <section class="section section-white">
        <div class="container section-center">
            <span class="section-label">Garantie qualité</span>
            <h2 class="section-title">Avantages inclus dans tous les packs</h2>
            <p class="section-sub">Les mêmes garanties et services premium offerts à chaque élève, quel que soit le pack choisi.</p>

            <div class="included-grid">
                @foreach ($perks as $perk)
                    <div class="included-card">
                        <div class="included-icon"><i class="{{ $perk->icon }}"></i></div>
                        <h3 class="included-title">{{ $perk->title }}</h3>
                        <p class="included-desc">{{ $perk->description }}</p>
                    </div>
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