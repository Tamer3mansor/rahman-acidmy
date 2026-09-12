@extends('layouts.landing')

@section('title', $settings->meta_title ?: 'Cours de Coran et arabe en ligne en France, Belgique et Canada | Ar-Rahman Academy')

@section('description', $settings->meta_description ?: 'Cours de Coran et d\'arabe en ligne pour enfants et adultes en France, Belgique et Canada. Enseignants diplômés Al-Azhar, cours particuliers 7j/7. Séance d\'essai gratuite sans engagement.')

@if ($settings->og_image)
    @php
        $homeOgImage = \Illuminate\Support\Str::startsWith($settings->og_image, ['http://', 'https://'])
            ? $settings->og_image
            : asset('storage/'.$settings->og_image);
    @endphp
    @section('og_image', $homeOgImage)
@endif

@section('head')
    @if ($courses->count())
        <script type="application/ld+json">
        {
            "@@context": "https://schema.org",
            "@@type": "ItemList",
            "itemListElement": [
                @foreach ($courses as $course)
                {
                    "@type": "Course",
                    "position": {{ $loop->iteration }},
                    "name": @json($course->title),
                    "description": @json($course->short_description),
                    "url": @json(route('courses.show', $course->slug)),
                    "provider": {
                        "@type": "EducationalOrganization",
                        "name": "Ar-Rahman Academy",
                        "url": "{{ config('seo.url') }}"
                    }
                }@if (! $loop->last),@endif
                @endforeach
            ]
        }
        </script>
    @endif
@endsection

@section('content')

    @include('landing.partials.nav')

    <main>
        @include('landing.partials.hero')
        @include('landing.partials.trust')
        @include('landing.partials.journey')
        @include('landing.partials.compare')
        @include('landing.partials.teachers')
        @include('landing.partials.faq')
        @include('landing.partials.form')
    </main>

    @include('landing.partials.footer')
    @include('landing.partials.floating')

@endsection