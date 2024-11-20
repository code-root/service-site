<style>
.about-image-gallery-2 {
    width: 100%;
    position: relative;
    padding: 90px 0;
    display: flex;
    align-items: center;
    justify-content: center;
}
@media screen and    (max-width: 768px) {
    .about-image-gallery-2 {
        padding: 45px 30px;
    }

    .vvvvvvvvvv {
        width: 100%;
    }
}
</style>
<div class="hero-banner hero-style-12 bg-image photography-banner">
    <div class="swiper photography-activator">
        <div class="swiper-wrapper">
                @foreach ($sliders as $slider)
                <div class="swiper-slide">
                    <img width="360px" height="360px" data-transform-origin='center center' style="width: 100%;height: 100vh;object-fit: cover;object-position: 83%;filter: blur(6px);"
                        data-src="{{ route('view-image', ['m' => 'App\Models\App\AppSlider', 'id' => $slider->id , 'nameVar'=> 'image']) }}" class="swiper-lazy" alt="image">
                    <div class="thumbnail-bg-content">
                        <div class="container cd-root-animated-shape">
                            <div class="row">
                                <div class="col-7">
                                    <div class="banner-content">
                                        <span style="font-family: system-ui;color: #1f2432;font-weight: bold;font-size: larger;}" data-sal="slide-up"
                                            data-sal-duration="1000">{{ $slider->{'name_' . $locale} }}</span>
                                        <h1 class="title" data-sal-delay="100" data-sal="slide-up"
                                            data-sal-duration="1000">
                                            {{ $slider->{'name_' . $locale} }}</h1>
                                        <p data-sal-delay="200" data-sal="slide-up" data-sal-duration="1000">
                                            {{ $slider->{'details_' . $locale} }}</p>
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

<div class="about-image-gallery-2">
                    <div class="main-img-1 sal-animate" data-sal-delay="50" data-sal="slide-up" data-sal-duration="800">
                    <video style="border-radius: 10px;" class="main-img-2 vvvvvvvvvv" data-sal-delay="100" data-sal="slide-left" data-sal-duration="800" autoplay loop muted>
                                    <source src="assets/site/videos/v1.mp4" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                    </div>
                    <ul class="shape-group">
                        <li class="shape-1 scene sal-animate" data-sal-delay="500" data-sal="fade" data-sal-duration="200" >
                            <img data-depth="2" src="assets/site/images/about/shape-49.png" alt="Shape" >
                        </li>
                        <li class="shape-2 scene sal-animate" data-sal-delay="500" data-sal="fade" data-sal-duration="200" >
                            <img data-depth="-2" src="assets/site/images/counterup/shape-02.png" alt="Shape" >
                        </li>
                    
                        <li class="shape-3 shape-dark scene sal-animate" data-sal-delay="500" data-sal="fade" data-sal-duration="200" >
                            <img data-depth="2" src="assets/site/images/about/dark-shape-50.png" alt="Shape" >
                            </li>
    </ul>
</div>
