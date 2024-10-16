@extends('site.layouts.app')

@section('title', $page->{'name_' . app()->getLocale()})
@section('content')
    <div class="eman-breadcrumb-area">
        <div class="container">
            <div class="breadcrumb-inner">
                <div class="page-title">
                    <h1 class="title">{{ $page->{'name_' . app()->getLocale()} }}</h1>
                </div>
                <ul class="eman-breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="separator"><i class="icon-angle-right"></i></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $page->{'name_' . app()->getLocale()} }}</li>
                </ul>
            </div>
        </div>
        <ul class="shape-group">
            <li class="shape-1"><span></span></li>
            <li class="shape-2 scene"></li>
            <li class="shape-3 scene"></li>
            <li class="shape-4"><span></span></li>
            <li class="shape-5 scene"></li>
        </ul>
    </div>
    <section class="section-gap-equal contact-me-area">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-9">
                    <div class="contact-me">
                        <div class="inner">
                            <div class="contact-us-info">
                                <h3 class="heading-title">{!! $page->{'name' . app()->getLocale()} !!}</h3>
                                <p>{!! $page->{'description_' . app()->getLocale()} !!}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
