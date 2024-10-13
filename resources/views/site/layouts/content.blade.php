{{-- @extends('layouts.app') --}}

@section('title', 'Content Page')

@section('content')

@include('site.partials.home-page.sliders')


@include('site.partials.home-page.about-us')
@include('site.partials.home-page.gallery')
@include('site.partials.home-page.faq')
@include('site.partials.home-page.partners')


@endsection