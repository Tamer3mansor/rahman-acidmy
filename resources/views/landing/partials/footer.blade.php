<footer class="footer">
    <div class="container">
        <div class="footer-inner">
            <div class="footer-brand">
                <div class="brand-name">{{ $settings->footer_brand_name }}</div>
                <div class="brand-sub">{{ $settings->footer_brand_sub }}</div>
                <p>{!! $settings->footer_description !!}</p>
            </div>
            <div class="footer-col">
                <h4>روابط سريعة</h4>
                <ul>
                    @php($homeUrl = $homeUrl ?? route('home'))
                    <li><a href="{{ $homeUrl }}">الرئيسية</a></li>
                    <li><a href="{{ $homeUrl }}#courses">دوراتنا</a></li>
                    <li><a href="{{ $homeUrl }}#journey">منهجنا</a></li>
                    <li><a href="{{ $homeUrl }}#teachers">معلمونا</a></li>
                    <li><a href="{{ $homeUrl }}#faq">أسئلة شائعة</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>تواصل معنا</h4>
                <ul>
                    <li><a href="{{ $settings->header_btn1_url }}">واتساب</a></li>
                    <li><a href="#trial-form">احجز حصة تجريبية</a></li>
                    <li><a href="mailto:contact@arrahman-academy.com">البريد الإلكتروني</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>{{ $settings->footer_copyright }}</p>
            <p style="color:rgba(255,255,255,0.25);font-size:0.75rem;">صُمِّمت بإتقان ❤️</p>
        </div>
    </div>
</footer>