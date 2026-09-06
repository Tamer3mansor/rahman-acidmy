@extends('layouts.landing')

@section('title', 'باقات الأسعار - أكاديمية القرآن واللغة العربية')

@section('meta_description', 'باقات واضحة لتعليم القرآن الكريم واللغة العربية عبر الإنترنت، اختر مدة الحصة المناسبة وابدأ رحلة طفلك مع حصة تجريبية مجانية.')

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
            <span class="section-label"><i class="fa-solid fa-gift"></i> الحصة الأولى مجاناً</span>
            <h1 class="section-title">باقات واضحة للتعلم بأسلوب مريح وسلس</h1>
            <p class="section-sub">كلما زاد عدد الحصص في الباقة، قل سعر الحصة الواحدة. اختر مدة الحصة المناسبة لطفلك وابدأ الآن.</p>

            <div class="duration-hint">اختر مدة الحصة الواحدة:</div>
            <div class="duration-picker-wrapper" id="durationPicker">
                @foreach ($durations as $duration)
                    <button type="button" class="duration-btn {{ $loop->first ? 'active' : '' }}" data-duration="{{ $duration }}">{{ $duration }} دقيقة</button>
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
                            <span class="featured-tag"><i class="fa-solid fa-star"></i> الأكثر طلباً</span>
                        @endif

                        <div class="pack-header">
                            <h3 class="pack-title">{{ $package->name }}</h3>
                            <span class="badge badge-{{ $package->badge_style }}">{{ $package->badge }}</span>
                        </div>
                        <p class="pack-desc">{{ $package->description }}</p>

                        <div class="pack-classes-box">
                            <div class="pack-classes-count inter-font">{{ $package->classes_count }} {{ $package->classes_count >= 3 && $package->classes_count <= 10 ? 'حصص' : 'حصة' }}</div>
                            <div class="pack-classes-sub duration-label-text"
                                 data-duration-label-30="بواقع 30 دقيقة للحصة"
                                 data-duration-label-45="بواقع 45 دقيقة للحصة"
                                 data-duration-label-60="بواقع 60 دقيقة للحصة">بواقع 30 دقيقة للحصة</div>
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
                                    <div class="price-per-lesson">أي <span class="per-lesson-val inter-font">{{ number_format($package->rateFor($duration), 2) }}</span>€ / للحصة</div>
                                    @if ($savings > 0)
                                        <div class="savings-pill">وفرت <span class="savings-val inter-font">{{ number_format($savings, 2) }}</span>€</div>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        <ul class="pack-features">
                            @foreach ($package->features as $feature)
                                <li><i class="fa-solid fa-check-circle"></i>
                                    @if ($feature === 'مدة الحصة حسب الاختيار')
                                        <span class="duration-label-text"
                                              data-duration-label-30="مدة الحصة 30 دقيقة"
                                              data-duration-label-45="مدة الحصة 45 دقيقة"
                                              data-duration-label-60="مدة الحصة 60 دقيقة">مدة الحصة 30 دقيقة</span>
                                    @else
                                        <span>{{ $feature }}</span>
                                    @endif
                                </li>
                            @endforeach
                        </ul>

                        <button type="button" class="{{ $package->is_featured ? 'btn-primary' : 'btn-outline' }} select-package-btn" data-select-package>
                            <i class="fa-brands fa-whatsapp"></i> هذه الباقة تناسبني
                        </button>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Included in all packages --}}
    <section class="section section-white">
        <div class="container section-center">
            <span class="section-label">ضمان الجودة</span>
            <h2 class="section-title">مميّزات شاملة في جميع الباقات</h2>
            <p class="section-sub">نفس الضمانات والخدمات المتميزة تُقدّم لكل طالب بغض النظر عن الباقة المختارة.</p>

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
                <span class="badge cta-banner-badge">بدون أي التزام</span>
                <h2 class="cta-banner-title">هل تحتار في اختيار الباقة المناسبة لطفلك؟</h2>
                <p class="cta-banner-sub">فريقنا التعليمي يرافقك مجاناً لمساعدتك في تحديد المستوى، اختيار الباقة الأنسب، وتحديد مواعيد الحصص.</p>

                <div class="cta-buttons-group">
                    <a href="{{ $settings->header_btn1_url }}" target="_blank" rel="noopener" class="btn-whatsapp">
                        <i class="fa-brands fa-whatsapp"></i> تحدث معنا عبر WhatsApp
                    </a>
                    <a href="{{ route('home') . '#trial-form' }}" class="btn-primary">
                        <i class="fa-solid fa-laptop"></i> احجز حصتك التجريبية مجاناً
                    </a>
                </div>
            </div>
        </div>
    </section>

    @include('landing.partials.footer')
    @include('landing.partials.floating')

@endsection