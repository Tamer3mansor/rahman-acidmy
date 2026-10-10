<footer class="footer">
    <div class="container">
        @php($homeUrl = $homeUrl ?? route('home'))
        <div class="footer-inner">
            <div class="footer-brand">
                <div class="brand-name">{{ $settings->footer_brand_name }}</div>
                <div class="brand-sub">{{ $settings->footer_brand_sub }}</div>
                <p>{!! $settings->footer_description !!}</p>

                @php($social = collect([
                    'WhatsApp' => $settings->footer_social_whatsapp,
                    'Telegram' => $settings->footer_social_telegram,
                    'Facebook' => $settings->footer_social_facebook,
                    'Instagram' => $settings->footer_social_instagram,
                    'TikTok' => $settings->footer_social_tiktok,
                    'X' => $settings->footer_social_x,
                    'YouTube' => $settings->footer_social_youtube,
                ])->filter())

                @if ($social->isNotEmpty())
                    <div class="footer-social">
                        @foreach ($social as $name => $url)
                            <a href="{{ $url }}" class="footer-social-btn footer-social-{{ strtolower($name) }}" aria-label="{{ $name }}" target="_blank" rel="noopener">
                                <i class="fa-brands {{ match ($name) {
                                    'WhatsApp' => 'fa-whatsapp',
                                    'Telegram' => 'fa-telegram',
                                    'Facebook' => 'fa-facebook-f',
                                    'Instagram' => 'fa-instagram',
                                    'TikTok' => 'fa-tiktok',
                                    'X' => 'fa-x-twitter',
                                    'YouTube' => 'fa-youtube',
                                } }}"></i>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
            <div class="footer-col">
                <h4>{{ $settings->footer_quicklinks_title ?: 'Liens rapides' }}</h4>
                <ul>
                    <li><a href="{{ $homeUrl }}">{{ $settings->footer_link_home ?: 'Accueil' }}</a></li>
                    <li><a href="{{ $homeUrl }}#courses">{{ $settings->footer_link_courses ?: 'Nos cours' }}</a></li>
                    <li><a href="{{ $homeUrl }}#journey">{{ $settings->footer_link_journey ?: 'Notre parcours' }}</a></li>
                    <li><a href="{{ $homeUrl }}#teachers">{{ $settings->footer_link_teachers ?: 'Nos enseignants' }}</a></li>
                    <li><a href="{{ $homeUrl }}#faq">{{ $settings->footer_link_faq ?: 'FAQ' }}</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>{{ $settings->footer_contact_title ?: 'Contactez-nous' }}</h4>
                <ul>
                    @if (! empty($settings->header_btn1_url))
                        <li><a href="{{ $settings->header_btn1_url }}" target="_blank" rel="noopener">{{ $settings->footer_link_whatsapp ?: 'WhatsApp' }}</a></li>
                    @endif
                    <li><a href="{{ $homeUrl }}#trial-form">{{ $settings->footer_link_trial ?: 'Réservez un essai' }}</a></li>
                    <li><a href="mailto:{{ \App\Models\SystemSettings::singleton()->contactEmail() }}">{{ $settings->footer_link_email ?: 'E-mail' }}</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>{{ $settings->footer_copyright }}</p>
            <p style="color:rgba(255,255,255,0.25);font-size:0.75rem;">{{ $settings->footer_made_with ?: 'Conçu avec passion ❤️' }}</p>
        </div>
    </div>
</footer>