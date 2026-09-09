@php
    $heading = $this->getHeading();
    $subheading = $this->getSubHeading();
@endphp

<div {{ $attributes->class(['lgn-root']) }}>
    <div class="lgn-aside">
        <div class="lgn-aside-inner">
            @if ($logo = $this->getLogo())
                <img
                    src="{{ $logo }}"
                    alt="{{ filament()->getBrandName() }}"
                    class="lgn-aside-logo"
                    onerror="this.style.display='none';this.nextElementSibling.style.display='flex'"
                >
                <div class="lgn-aside-fallback" style="display:none">
                    <x-heroicon-o-academic-cap />
                </div>
            @else
                <div class="lgn-aside-fallback">
                    <x-heroicon-o-academic-cap />
                </div>
            @endif

            <h1 class="lgn-brand">{{ filament()->getBrandName() }}</h1>
            <p class="lgn-tagline">لوحة التحكم الإدارية</p>

            <hr>

            <div class="lgn-features">
                <div class="lgn-feature">
                    <x-heroicon-o-shield-check />
                    <span>آمن ومحمي</span>
                </div>
                <span class="lgn-features-sep"></span>
                <div class="lgn-feature">
                    <x-heroicon-o-chart-bar />
                    <span>إدارة شاملة</span>
                </div>
            </div>
        </div>
    </div>

    <div class="lgn-main">
        <div class="lgn-card">
            <div class="lgn-mobile-head">
                @if ($logo = $this->getLogo())
                    <img
                        src="{{ $logo }}"
                        alt="{{ filament()->getBrandName() }}"
                        class="lgn-mobile-logo"
                        onerror="this.style.display='none'"
                    >
                @endif
                <h2 class="lgn-heading">{{ filament()->getBrandName() }}</h2>
            </div>

            <div>
                <h2 class="lgn-heading">{{ $heading ?? __('filament-panels::auth/pages/login.title') }}</h2>
                @if ($subheading)
                    <p class="lgn-sub">{!! $subheading !!}</p>
                @endif
            </div>

            <div class="fi-login-form">
                {{ $this->content }}
            </div>

            <div class="lgn-footer">
                &copy; {{ date('Y') }} {{ filament()->getBrandName() }} &mdash; جميع الحقوق محفوظة
            </div>
        </div>
    </div>
</div>