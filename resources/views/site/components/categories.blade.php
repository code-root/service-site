<div class="amazing-categorie-area categorie-area-6">
    <div class="container">
        <div class="section-title section-center" data-sal-delay="150" data-sal="slide-up" data-sal-duration="800">
            <span class="pre-title">{{ $basicFields['categories_services'] ?? 'Default services' }}</span>
            <h2 class="title">{{ $basicFields['categories_creativity_and_passion'] ?? 'Default creativity and passion' }}</h2>
            <span class="shape-line"><i class="icon-19"></i></span>
            <p class="text">{{ $basicFields['categories_description'] ?? 'Default description' }}</p>
        </div>
        <div class="row g-5">
            @foreach($categories as $item)
            <div class="col-lg-4 col-md-6" data-sal-delay="50" data-sal="slide-up" data-sal-duration="800">
                <div class="categorie-grid categorie-style-6 ">
                    <div class="icon" style="background: {{ $item->color_class }};">
                        <img src="{{ asset('/storage/app/public/' .$item->icon) }}" alt="Icon" >

                        {{-- @if(Str::startsWith($item->icon, 'assets'))
                        <img src="{{ asset($item->icon) }}" alt="Icon">
                        @else
                        <i class="{{ $item->icon }}"></i>
                        @endif --}}
                    </div>
                    <div class="content">
                        <h5 class="title">{{ getTranslations($item->tr_token ,  'title' ) }}</h5>
                        <p>{{ getTranslations($item->tr_token ,  'description' ) }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="service-btn">
            <a href="#" class="amazing-btn">{{ $basicFields['categories_start_today'] ?? 'Default start today' }}<i class="icon-west"></i></a>
        </div>
    </div>
    <ul class="shape-group">
        <li class="shape-1" data-sal-delay="1000" data-sal="fade" data-sal-duration="1000">
            <img src="assets/site/images/others/rtl-shape-47.png" alt="Shape">
        </li>
        <li class="shape-2" data-sal-delay="1000" data-sal="fade" data-sal-duration="1000">
            <img class="rotateit" src="assets/site/images/others/shape-38.png" alt="Shape">
        </li>
        <li class="shape-3 scene" data-sal-delay="1000" data-sal="fade" data-sal-duration="1000">
            <span data-depth="2.5"></span>
        </li>
    </ul>
</div>
