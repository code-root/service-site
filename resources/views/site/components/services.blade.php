<div class="business-course amazing-course-area course-area-12 gap-tb-text bg-image">
    <div class="container amazingblink-animated-shape">
        <ul>
            <li>
                <div class="section-title section-left sal-animate" data-sal-delay="150" data-sal="slide-up" data-sal-duration="800">
                    <span class="pre-title">{{ $basicFields['services_popular_services'] ?? 'Default popular services' }}</span>
                    <h2 class="title">{{ $basicFields['services_choose_service'] ?? 'Default choose service' }}</h2>
                    <span class="shape-line"><i class="icon-19"></i></span>
                </div>
            </li>
            <li>
                <div class="slider-nav-wrapper sal-animate" data-sal-delay="150" data-sal="slide-up" data-sal-duration="1200">
                    <div class="swiper-navigation">
                        <div class="swiper-btn-nxt" tabindex="0" role="button" aria-label="Next slide">
                            <i class="icon-east"></i>
                        </div>
                        <div class="swiper-btn-prv" tabindex="0" role="button" aria-label="Previous slide" >
                            <i class="icon-west"></i>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
        <div class="swiper business-course-activation swiper-initialized swiper-horizontal swiper-pointer-events swiper-rtl">
            <div class="swiper-wrapper" id="swiper-wrapper-56a1966b13fe0d21" aria-live="polite">
                @foreach($services as $service)
                <div class="swiper-slide" data-swiper-slide-index="{{ $loop->index }}" style="width: 392.75px;" role="group" aria-label="{{ $loop->iteration }} / {{ $services->count() }}">
                    <!-- Start Single Service  -->
                    <div class="amazing-course course-style-15">
                        <div class="inner">
                            <div class="thumbnail">
                                <a href="{{ route('service.details', $service->id) }}">
                                    <img src="{{ asset('/storage/app/public/' . $service->image) }}" alt="Service Image">
                                </a>
                            </div>
                            <div class="course-price">${{ $service->price }}</div>
                            <ul class="course-meta">
                                <li><i class="icon-24"></i> {{ $service->orders->count() }} {{ $basicFields['services_subscribers'] ?? 'Default subscribers' }}</li>
                                <li><i class="icon-25"></i> {{ $service->views->count() }} {{ $basicFields['services_views'] ?? 'Default views' }}</li>
                            </ul>
                            <div class="content">
                                <h6 class="title">
                                    <a href="{{ route('service.details', $service->id) }}">{{ getTranslations($service->tr_token ,  'title' ) }} </a>
                                </h6>
                            </div>
                        </div>
                    </div>
                    <!-- End Single Service  -->
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <ul class="shape-group">
        <li class="shape-1">
            <img src="assets/site/images/bg/bg-image-43.webp" alt="Shape">
        </li>
    </ul>
</div>
