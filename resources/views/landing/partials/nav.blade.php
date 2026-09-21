<?php
    $homeUrl = $homeUrl ?? route('home');
    $activePage = $activePage ?? 'home';
?>
<nav class="navbar" id="navbar">
    <div class="container">
        <div class="nav-inner">
            <a href="{{ $logoUrl ?? $homeUrl }}" class="nav-logo">
                <div class="nav-logo-icon">
                    @if ($settings->header_logo_path)
                        <img src="{{ asset('storage/' . $settings->header_logo_path) }}" alt="{{ $settings->header_brand_name }}">
                    @else
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M12 3L4 7v5c0 4.4 3.4 8.5 8 9.5 4.6-1 8-5.1 8-9.5V7l-8-4z" fill="none" stroke="#C9963A" stroke-width="1.5"/>
                            <path d="M9 12l2 2 4-4" stroke="#C9963A" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                    @endif
                </div>
                <div class="nav-logo-text">
                    <div class="name">{{ $settings->header_brand_name }}</div>
                    <div class="sub">{{ $settings->header_brand_sub }}</div>
                </div>
            </a>

            <ul class="nav-links">
                <li class="nav-item has-dropdown">
                    <button type="button" class="nav-toggle" aria-haspopup="true" aria-expanded="false">
                        Nos cours
                        <svg class="chevron" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 9l6 6 6-6"/></svg>
                    </button>
                    <ul class="dropdown">
                        <li><a href="{{ route('kids.index') }}" @if ($activePage === 'kids') class="active" @endif>Cours pour enfants</a></li>
                        <li><a href="{{ route('adults.index') }}" @if ($activePage === 'adults') class="active" @endif>Cours pour adultes</a></li>
                    </ul>
                </li>
                <li><a href="{{ $homeUrl }}#teachers">Professeurs</a></li>
                <li><a href="{{ $homeUrl }}#trust">Témoignages</a></li>
                <li><a href="{{ route('price.index') }}" @if ($activePage === 'price') class="active" @endif>Tarifs</a></li>
                <li class="nav-item has-dropdown">
                    <button type="button" class="nav-toggle" aria-haspopup="true" aria-expanded="false">
                        Ressources
                        <svg class="chevron" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 9l6 6 6-6"/></svg>
                    </button>
                    <ul class="dropdown dropdown--right">
                        <li><a href="{{ route('blog.index') }}" @if ($activePage === 'blog') class="active" @endif>Blog</a></li>
                        <li><a href="{{ route('lessons.index') }}" @if ($activePage === 'lessons') class="active" @endif>Leçons gratuites</a></li>
                        <li class="faq-in-resources"><a href="{{ $homeUrl }}#faq">FAQ</a></li>
                    </ul>
                </li>
                <li class="nav-faq-bar"><a href="{{ $homeUrl }}#faq">FAQ</a></li>
            </ul>

            <div class="nav-actions">
                <a href="{{ $settings->header_btn1_url }}" class="nav-wa" target="_blank" rel="noopener" aria-label="WhatsApp">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                </a>
                @if (($activePage ?? 'home') === 'home')
                    <button class="nav-btn" data-scroll-to-form>Essai gratuit</button>
                @else
                    <a href="{{ $homeUrl }}#trial-form" class="nav-btn">Essai gratuit</a>
                @endif
            </div>

            <div class="hamburger" id="hamburger" aria-label="Menu">
                <span></span><span></span><span></span>
            </div>
        </div>
    </div>
    <div class="mobile-menu" id="mobileMenu">
        <a href="{{ route('kids.index') }}">Cours pour enfants</a>
        <a href="{{ route('adults.index') }}">Cours pour adultes</a>
        <a href="{{ $homeUrl }}#teachers">Professeurs</a>
        <a href="{{ $homeUrl }}#trust">Témoignages</a>
        <a href="{{ route('price.index') }}">Tarifs</a>
        <a href="{{ route('blog.index') }}">Blog</a>
        <a href="{{ route('lessons.index') }}">Leçons gratuites</a>
        <a href="{{ $homeUrl }}#faq">FAQ</a>
        <a href="{{ $settings->header_btn1_url }}" target="_blank" rel="noopener">{{ $settings->header_btn1_title }}</a>
        <div class="mobile-btns">
            @if (($activePage ?? 'home') === 'home')
                <button class="btn-primary" data-scroll-to-form>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    Essai gratuit
                </button>
            @else
                <a href="{{ $homeUrl }}#trial-form" class="btn-primary">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    Essai gratuit
                </a>
            @endif
        </div>
    </div>
</nav>