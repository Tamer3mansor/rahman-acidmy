<footer class="footer">
    <div class="container">
        @php($homeUrl = $homeUrl ?? route('home'))
        <div class="footer-inner">
            <div class="footer-brand">
                <div class="brand-name">{{ $settings->footer_brand_name }}</div>
                <div class="brand-sub">{{ $settings->footer_brand_sub }}</div>
                <p>{!! $settings->footer_description !!}</p>
            </div>
            <div class="footer-col">
                <h4>Liens rapides</h4>
                <ul>
                    <li><a href="{{ $homeUrl }}">Accueil</a></li>
                    <li><a href="{{ $homeUrl }}#courses">Nos cours</a></li>
                    <li><a href="{{ $homeUrl }}#journey">Notre parcours</a></li>
                    <li><a href="{{ $homeUrl }}#teachers">Nos enseignants</a></li>
                    <li><a href="{{ $homeUrl }}#faq">FAQ</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Contactez-nous</h4>
                <ul>
                    @if (! empty($settings->header_btn1_url))
                        <li><a href="{{ $settings->header_btn1_url }}" target="_blank" rel="noopener">WhatsApp</a></li>
                    @endif
                    <li><a href="{{ $homeUrl }}#trial-form">Réservez un essai</a></li>
                    <li><a href="mailto:contact@arrahman-academy.com">E-mail</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>{{ $settings->footer_copyright }}</p>
            <p style="color:rgba(255,255,255,0.25);font-size:0.75rem;">Conçu avec passion ❤️</p>
        </div>
    </div>
</footer>