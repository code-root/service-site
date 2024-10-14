<div class="hero-banner hero-style-3 bg-image">
    <div class="swiper university-activator">
        <div class="swiper-wrapper">
            @foreach($sliders as $slider)
            <div class="swiper-slide">
                <img width="360px" height="360px" data-transform-origin='center center' data-src="{{ asset('storage/' . $slider->image) }}" class="swiper-lazy" alt="image">
                <div class="thumbnail-bg-content">
                    <div class="container al-eman--animated-shape">
                        <div class="row">
                            <div class="col-7">
                                <div class="banner-content">
                                    <span class="subtitle" data-sal="slide-up" data-sal-duration="1000">{{ $locale === 'ar' ? $slider->name_ar : $slider->name_en }}</span>
                                    <h1 class="title" data-sal-delay="100" data-sal="slide-up" data-sal-duration="1000">{{ $locale === 'ar' ? $slider->name_ar : $slider->name_en }}</h1>
                                    <p data-sal-delay="200" data-sal="slide-up" data-sal-duration="1000">{{ $slider->details }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="hero-slider-bg-controls">
            <div class="swiper-slide-controls slide-prev">
                <i class="icon-west"></i>
            </div>
            <div class="swiper-slide-controls slide-next">
                <i class="icon-east"></i>
            </div>
        </div>
    </div>
    <ul class="shape-group">
        <li class="shape-1 scene" data-sal-delay="1000" data-sal="fade" data-sal-duration="1000">
            <img data-depth="2" src="assets/site/images/others/shape-10.png" alt="Shape">
        </li>
        <li class="shape-2 scene" data-sal-delay="1000" data-sal="fade" data-sal-duration="1000">
            <img data-depth="-3" src="assets/site/images/others/shape-11.png" alt="Shape">
        </li>
        <li class="shape-3">
            <img src="assets/site/images/others/shape-25.png" alt="Shape">
        </li>
    </ul>
</div>

<div class="features-area-3">
    <div class="container">
        <div class="features-grid-wrap">
            <div class="features-box features-style-3 color-primary-style al-eman--svg-animate">
                <div class="icon">
                    <img class="svgInject" src="assets/site/images/animated-svg-icons/scholarship-facility.svg" alt="animated icon">
                </div>
                <div class="content">
                    <p>
                        {{ $locale === 'ar' ? 'سهولة الوصول للأماكن السياحية والمتاحف والشواطئ.' : 'Easy access to tourist attractions, museums, and beaches.' }}
                    </p>
                </div>
            </div>
            <div class="features-box features-style-3 color-secondary-style al-eman--svg-animate">
                <div class="icon">
                    <img class="svgInject" src="assets/site/images/animated-svg-icons/skilled-lecturers.svg" alt="animated icon">
                </div>
                <div class="content">
                    <p>
                        {{ $locale === 'ar' ? 'سهولة الوصول للفنادق وأماكن الإقامة وفقا للتقييمات.' : 'Easy access to hotels and accommodations based on reviews.' }}
                    </p>
                </div>
            </div>
            <div class="features-box features-style-3 color-extra02-style al-eman--svg-animate">
                <div class="icon">
                    <img class="svgInject" src="assets/site/images/animated-svg-icons/book-library.svg" alt="animated icon">
                </div>
                <div class="content">
                    <p>
                        {{ $locale === 'ar' ? 'تسهيل التجربة على الزوار' : 'Facilitating the experience for visitors.' }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
