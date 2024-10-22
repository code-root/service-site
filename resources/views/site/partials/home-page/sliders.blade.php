<div class="hero-banner hero-style-12 bg-image photography-banner">
    <div class="swiper photography-activator">
        <div class="swiper-wrapper">
                @foreach ($sliders as $slider)
                <div class="swiper-slide">
                    <img width="360px" height="360px" data-transform-origin='center center'
                        data-src="{{ route('view-image', ['m' => 'App\Models\App\AppSlider', 'id' => $slider->id , 'nameVar'=> 'image']) }}" class="swiper-lazy" alt="image">
                    <div class="thumbnail-bg-content">
                        <div class="container cd-root-animated-shape">
                            <div class="row">
                                <div class="col-7">
                                    <div class="banner-content">
                                        <span class="subtitle" data-sal="slide-up"
                                            data-sal-duration="1000">{{ $slider->{'name_' . session('locale')} }}</span>
                                        <h1 class="title" data-sal-delay="100" data-sal="slide-up"
                                            data-sal-duration="1000">
                                            {{ $slider->{'name_' . session('locale')} }}</h1>
                                        <p data-sal-delay="200" data-sal="slide-up" data-sal-duration="1000">
                                            {{ $slider->details }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
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

        <div class="pagination-box-wrapper">
            <div class="pagination-box-wrap">
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </div>
</div>
