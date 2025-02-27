<div class="hero-banner hero-style-12 bg-image photography-banner">
    <div class="swiper photography-activator">
        <div class="swiper-wrapper">
            @foreach ($sliders as $slider)
            <div class="swiper-slide">
                <img width="360px" height="360px" data-transform-origin='center center' style="width: 100%;height: 100vh;object-fit: cover;object-position: 83%;filter: blur(6px);"
                    data-src="{{ asset('/storage/app/public/' . $slider->image) }}" class="swiper-lazy" alt="image">
                <div class="thumbnail-bg-content">
                    <div class="container cd-root-animated-shape">
                        <div class="row">
                            <div class="col-7">
                                <div class="banner-content">
                                    <span style="font-family: system-ui;color: #1f2432;font-weight: bold;font-size: larger;" data-sal="slide-up"
                                        data-sal-duration="1000">{{ getTranslations($slider->tr_token ,  'name' ) }}</span>
                                    <h1 class="title" data-sal-delay="100" data-sal="slide-up"
                                        data-sal-duration="1000">{{ getTranslations($slider->tr_token ,  'title' ) }}</h1>
                                    <p data-sal-delay="200" data-sal="slide-up" data-sal-duration="1000">{{ getTranslations($slider->tr_token ,  'details' ) }} </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="swiper-slide-controls slide-prev">
            <i class="icon-west"></i>
        </div>
        <div class="swiper-slide-controls slide-next">
            <i class="icon-east"></i>
        </div>

        <div class="pagination-box-wrapper">
            <div class="pagination-box-wrap">
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </div>
</div>
