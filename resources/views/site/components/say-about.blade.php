<div class="testimonial-area-10 gap-top-equal photography-testimonial edublink-animated-shape">
    <div class="container edublink-animated-shape">
        <div class="testimonial-heading-area">
            <div class="section-title section-center" data-sal-delay="50" data-sal="slide-up" data-sal-duration="800">
                <span class="pre-title">{{ __('messages.testimonials') }}</span>
                <h2 class="title">{!! __('messages.what_our_clients_say') !!}</h2>
                <span class="shape-line"><i class="icon-19"></i></span>
            </div>
        </div>
        <div class="photography-testimonial-activator swiper">
            <div class="swiper-wrapper">
                @foreach($testimonials as $testimonial)
                    <div class="swiper-slide">
                        <div class="testimonial-grid">
                            <div class="content">
                                <div class="quote-icon">
                                    <img src="https://edublink.html.rtl.devsblink.com/assets/images/svg-icons/quote.svg" alt="quote svg">
                                </div>
                                <p>{{ $testimonial->testimonial }}</p>
                                <h5 class="title">{{ $testimonial->name }}</h5>
                                <span class="subtitle">{{ $testimonial->position }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="swiper photography-testimonial-thumbs photo-testimonial-thumb-wrap">
            <div class="swiper-wrapper">
                @foreach($testimonials as $testimonial)
                    <div class="nav-thumb swiper-slide">
                        <div class="clint-thumb">
                            <img src="{{ asset('/storage/app/public/' . $testimonial->image) }}" width="104" height="104" alt="Testimonial" loading="">
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="swiper-slide-controls slide-prev">
            <i class="icon-west"></i>
        </div>
        <div class="swiper-slide-controls slide-next">
            <i class="icon-east"></i>
        </div>

        <ul class="shape-group">
            <li class="shape-1 scene" data-sal-delay="1000" data-sal="fade" data-sal-duration="1000">
                <img data-depth="-1.5" src="/assets/site/images/about/shape-13.png" alt="Shape">
            </li>
            <li class="shape-2 sal-animate" data-sal-delay="200" data-sal="fade" data-sal-duration="1000">
                <img src="/assets/site/images/others/Photo-shape-6.png" alt="Shape">
            </li>
            <li class="shape-3 sal-animate" data-sal-delay="200" data-sal="fade" data-sal-duration="1000">
                <img class="d-block-shape-light" src="/assets/site/images/others/map-shape-3.png" alt="Shape">
                <img class="d-none-shape-dark" src="/assets/site/images/others/dark-map-2-shape-3.png" alt="Shape">
            </li>
            <li class="shape-4" data-sal-delay="1000" data-sal="fade" data-sal-duration="1000">
                <img class="rotateit" src="/assets/site/images/about/shape-37.png" alt="Shape">
            </li>
            <li class="shape-5">
                <span></span>
            </li>
        </ul>
    </div>
</div>
<!-- End Testimonial Area  -->
