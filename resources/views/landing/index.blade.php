@extends('layouts.landing')

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