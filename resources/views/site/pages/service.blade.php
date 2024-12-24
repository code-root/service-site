@extends('site.layouts.app')

@section('title', $locale === 'ar' ? 'الخدمات' : 'Services')
@section('content')

<div class="amazing-breadcrumb-area">
    <div class="container">
        <div class="breadcrumb-inner">
            <div class="page-title">
                <h1 class="title">{{ $locale === 'ar' ? 'الخدمات' : 'Services' }}</h1>
            </div>
            <ul class="amazing-breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">{{ $locale === 'ar' ? 'الرئيسية' : 'Home' }}</a></li>
                <li class="separator"><i class="icon-angle-right"></i></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $locale === 'ar' ? 'الخدمات' : 'Services' }}</li>
            </ul>
        </div>
    </div>
    <ul class="shape-group">
        <li class="shape-1">
            <span></span>
        </li>
        <li class="shape-2 scene"><img data-depth="2" src="assets/site/images/about/shape-13.png" alt="shape"></li>
        <li class="shape-3 scene"><img data-depth="-2" src="assets/site/images/about/shape-15.png" alt="shape"></li>
        <li class="shape-4">
            <span></span>
        </li>
        <li class="shape-5 scene"><img data-depth="2" src="assets/site/images/about/shape-07.png" alt="shape"></li>
    </ul>
</div>

<!--=====================================-->
<!--=        Services Area Start        =-->
<!--=====================================-->
<div class="amazing-service-area service-area-1 gap-tb-text">
    <div class="container">
        <h6 class="showing-text">
            {{ $locale === 'ar' ? 'وجدنا' : 'We found' }}
            <span>{{ $services->count() }}</span>
            {{ $locale === 'ar' ? 'خدمات المتاحة لك' : 'services available for you' }}
        </h6>
        <div class="row g-5">
            @foreach($services as $service)
            <!-- Start Single Service  -->
            <div class="col-md-6 col-lg-4 col-xl-3" data-sal-delay="100" data-sal="slide-up" data-sal-duration="800">
                <div class="amazing-service service-style-1 service-box-shadow hover-button-bg-white">
                    <div class="inner">
                        <div class="thumbnail">
                            <a href="{{ route('service.details', $service->id) }}">
                                <img src="{{ asset('/storage/app/public/' . $service->image) }}" alt="{{ $service->name }}">
                            </a>
                        </div>
                        <div class="content">
                            <h6 class="title">
                                <a href="{{ route('service.details', $service->id) }}">{{ $service->title }}</a>
                            </h6>
                            <p>{{ $service->description }}</p>
                            <div class="service-price">${{ $service->price }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Single Service  -->
            @endforeach
        </div>
    </div>
</div>
<!-- End Service Area -->

@endsection

@section('scripts')

@endsection
