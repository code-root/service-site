<div class="amazingteam-area team-area-8 gap-tb-text"
    @if(session('locale') == 'ar') style="direction: rtl;" @endif>
    <div class="container">
        <div class="section-title section-center" data-sal-delay="150" data-sal="slide-up" data-sal-duration="800">
            <span class="pre-title color-secondary">{{ session('locale') === 'ar' ? 'الشركاء' : 'Partners' }}</span>
            <h2 class="title">{{ session('locale') === 'ar' ? 'شركاؤنا في النجاح' : 'Our Success Partners' }}</h2>
            <span class="shape-line"><i class="icon-19"></i></span>
        </div>
        <div class="row g-5">
            @foreach ($partners as $partner)
                <!-- Start Partner Grid  -->
                <div class="col-lg-4 col-sm-6 col-12" data-sal-delay="50" data-sal="slide-up" data-sal-duration="800">
                    <div class="amazingteam-grid team-style-1 team-style-8">
                        <div class="inner">
                            <div class="thumbnail-wrap">
                                <div class="thumbnail">
                                    <img src="{{ route('api.image.partners') }}?id={{ $partner->id }}"
                                    style="width: 50%;height: 19%;"
                                        alt="{{ $partner->name }}">
                                </div>
                            </div>
                            <div class="content">
                                <h5 class="title">{{ $partner->{'name_' . session('locale')} }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Partner Grid  -->
            @endforeach
        </div>
    </div>
</div>
