<div class="amazing-about-area about-style-3" @if(session('locale') == 'ar') style="direction: rtl;" @endif>
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-6" data-sal-delay="50" data-sal="slide-up" data-sal-duration="800">
                <div class="about-content">
                    <div class="section-title section-left">
                        <span class="pre-title">{{ $locale === 'ar' ? 'من نحن' : 'About Us' }}</span>
                        <h2 class="title">
                            {{ $locale === 'ar' ? $settings['about_us'] ?? 'نحن نقدم أفضل خدمات التعليم لك' : $settings['about_us'] ?? 'We Provide Best Education Services For You' }}
                        </h2>
                        <span class="shape-line"><i class="icon-19"></i></span>
                    </div>
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#about-edu" type="button" role="tab" aria-selected="true">
                                {{ session('locale') == 'ar' ? 'من نحن' : 'About Us' }} {{ $settings['site_name'] ?? '' }}
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#about-mission" type="button" role="tab" aria-selected="false">
                                {{ session('locale') == 'ar' ? 'رؤية البرنامج' : 'Program Vision' }}
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#about-vision" type="button" role="tab" aria-selected="false">
                                {{ session('locale') == 'ar' ? 'رسالة البرنامج' : 'Program Mission' }}
                            </button>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="about-edu" role="tabpanel">
                            <p>{!!  $settings['about_intro'] ?? 'Default introduction text.' !!}</p>
                        </div>
                        <div class="tab-pane fade" id="about-mission" role="tabpanel">
                            <p>{{ $settings['about_mission'] ?? 'Default mission text.' }}</p>
                        </div>
                        <div class="tab-pane fade" id="about-vision" role="tabpanel">
                            <p>{{ $settings['about_vision'] ?? 'Default vision text.' }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about-image-gallery">
                    <img class="main-img-1" data-sal-delay="100" data-sal="slide-up" data-sal-duration="800"
                        src="{{ route('view-image', ['m' => 'Setting', 'id' => 0, 'nameVar'=> 'about_image_2']) }}"
                        alt="About Image">
                    <!-- <img class="main-img-2" data-sal-delay="100" data-sal="slide-left" data-sal-duration="800"
                        src="{{ route('view-image', ['m' => 'Setting', 'id' => 0, 'nameVar'=> 'about_image_1']) }}"
                        alt="About Image"> -->
                  
                        <video style="border-radius: 10px; width: 50%;" class="main-img-2" data-sal-delay="100" data-sal="slide-left" data-sal-duration="800" autoplay loop muted>
                                    <source src="assets/site/videos/v1.mp4" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>

                    <ul class="shape-group">
                        <li class="shape-1 scene" data-sal-delay="500" data-sal="fade" data-sal-duration="200">
                            <img data-depth="2" src="assets/site/images/about/shape-13.png" alt="Shape">
                        </li>
                        <li class="shape-2 scene" data-sal-delay="500" data-sal="fade" data-sal-duration="200">
                            <img data-depth="-2" src="assets/site/images/about/shape-39.png" alt="Shape">
                        </li>
                        <li class="shape-3 scene" data-sal-delay="500" data-sal="fade" data-sal-duration="200">
                            <img data-depth="2" src="assets/site/images/about/shape-07.png" alt="Shape">
                        </li>
                        <li class="shape-4" data-sal-delay="500" data-sal="fade" data-sal-duration="200">
                            <span></span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <ul class="shape-group">
        <li class="shape-5">
            <img class="rotateit" src="assets/site/images/about/shape-13.png" alt="Shape">
        </li>
        <li class="shape-6">
            <span></span>
        </li>
    </ul>
</div>
