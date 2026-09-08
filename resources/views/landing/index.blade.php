@extends('layouts.landing')

@section('title', $settings->meta_title ?: 'Ar-Rahman Academy | Cours de Coran et arabe en ligne')

@section('description', $settings->meta_description ?: 'Cours de Coran et d\'arabe en ligne pour enfants et adultes. Enseignants diplômés Al-Azhar, cours particuliers 7j/7. Séance d\'essai gratuite sans engagement.')

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