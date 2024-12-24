{{-- @extends('layouts.app') --}}

@section('title', 'Content Page')

@section('content')

    @include('site.partials.home-page.sliders')


    @include('site.components.categories')
    @include('site.components.services')
    @include('site.partials.home-page.about-us')
    @include('site.components.say-about')
    @include('site.partials.home-page.gallery')
    @include('site.partials.home-page.faq')
    @include('site.partials.home-page.partners')


@endsection
