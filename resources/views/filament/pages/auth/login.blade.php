@php
    $heading = $this->getHeading();
    $subheading = $this->getSubHeading();
@endphp

<div {{ $attributes->class(['fi-login-page flex min-h-screen']) }}>
    {{-- Left Panel: Branding --}}
    <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden items-center justify-center"
         style="background: linear-gradient(135deg, #92400e 0%, #d97706 50%, #f59e0b 100%);">
        <div class="absolute inset-0 opacity-10">
            <svg class="w-full h-full" viewBox="0 0 400 400" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="arabesque" x="0" y="0" width="80" height="80" patternUnits="userSpaceOnUse">
                        <circle cx="40" cy="40" r="30" fill="none" stroke="white" stroke-width="0.5"/>
                        <circle cx="40" cy="40" r="20" fill="none" stroke="white" stroke-width="0.5"/>
                        <circle cx="40" cy="40" r="10" fill="none" stroke="white" stroke-width="0.5"/>
                        <line x1="0" y1="40" x2="80" y2="40" stroke="white" stroke-width="0.3"/>
                        <line x1="40" y1="0" x2="40" y2="80" stroke="white" stroke-width="0.3"/>
                    </pattern>
                </defs>
                <rect width="400" height="400" fill="url(#arabesque)"/>
            </svg>
        </div>

        <div class="relative z-10 text-center px-12 max-w-lg">
            @if($this->hasLogo() && $this->getLogo())
                <img src="{{ $this->getLogo() }}" alt="{{ filament()->getBrandName() }}"
                     class="h-20 w-auto mx-auto mb-8 rounded-xl shadow-2xl bg-white p-2">
            @else
                <div class="w-20 h-20 mx-auto mb-8 rounded-2xl bg-white/20 backdrop-blur-sm flex items-center justify-center shadow-2xl">
                    <x-heroicon-o-academic-cap class="w-10 h-10 text-white" />
                </div>
            @endif

            <h1 class="text-4xl font-bold text-white mb-4" style="font-family: 'Inter', sans-serif;">
                {{ filament()->getBrandName() }}
            </h1>
            <p class="text-xl text-white/90 mb-8 leading-relaxed">
                لوحة التحكم الإدارية
            </p>

            <div class="flex items-center justify-center gap-6 text-white/80 text-sm mt-12">
                <div class="flex items-center gap-2">
                    <x-heroicon-o-shield-check class="w-5 h-5" />
                    <span>آمن ومحمي</span>
                </div>
                <div class="w-1 h-1 rounded-full bg-white/50"></div>
                <div class="flex items-center gap-2">
                    <x-heroicon-o-chart-bar class="w-5 h-5" />
                    <span>إدارة شاملة</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Right Panel: Login Form --}}
    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-white dark:bg-gray-900">
        <div class="w-full max-w-md">
            {{-- Mobile Logo --}}
            <div class="lg:hidden text-center mb-8">
                @if($this->hasLogo() && $this->getLogo())
                    <img src="{{ $this->getLogo() }}" alt="{{ filament()->getBrandName() }}"
                         class="h-16 w-auto mx-auto mb-4 rounded-xl shadow-lg bg-white p-1.5 dark:bg-gray-800">
                @endif
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                    {{ filament()->getBrandName() }}
                </h2>
            </div>

            {{-- Heading --}}
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                    {{ $heading ?? __('filament-panels::auth/pages/login.title') }}
                </h2>
                @if($subheading)
                    <p class="text-gray-600 dark:text-gray-400">
                        {!! $subheading !!}
                    </p>
                @endif
            </div>

            {{-- Login Form --}}
            <div class="fi-login-form">
                {{ $this->content }}
            </div>

            {{-- Footer --}}
            <div class="mt-8 text-center text-sm text-gray-500 dark:text-gray-400">
                <p>&copy; {{ date('Y') }} {{ filament()->getBrandName() }}. All rights reserved.</p>
            </div>
        </div>
    </div>
</div>