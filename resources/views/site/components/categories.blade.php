<div class="amazing-categorie-area categorie-area-6">
    <div class="container">
        <div class="section-title section-center" data-sal-delay="150" data-sal="slide-up" data-sal-duration="800">
            <span class="pre-title">خدمات</span>
            <h2 class="title">إبداعك وعاطفتك خدمات <br> مدرب الأعمال</h2>
            <span class="shape-line"><i class="icon-19"></i></span>
            <p class="text">لكن لا بد أن أوضح لك أن كل هذه الأفكار المغلوطة حول استنكار النشوة وتمجيد الألم نشأت بالفعل، وسأعرض لك التفاصيل لتكتشف حقيقة <br> بأنه لا يوجد من يرغب في الحب ونيل المنال ويتلذذ بالآلام، الألم هو الألم ولكن نتيجة لظروف ما قد تكمن السعاده فيما نتحمله من كد وأسي <br> حي لهذا، من منا لم يتحمل جهد بدني شاق إلا من أجل الحصول على ميزة أو فائدة؟ ولكن من لديه.</p>
        </div>
            <div class="row g-5">
                @foreach($category as $item)
                    <div class="col-lg-4 col-md-6" data-sal-delay="50" data-sal="slide-up" data-sal-duration="800">
                        <div class="categorie-grid categorie-style-6 {{ $item->color_class }}">
                            <div class="icon">
                                @if(Str::startsWith($item->icon, 'assets'))
                                    <img src="{{ asset($item->icon) }}" alt="Icon">
                                @else
                                    <i class="{{ $item->icon }}"></i>
                                @endif
                            </div>
                            <div class="content">
                                <h5 class="title">{{ $item->title }}</h5>
                                <p>{{ $item->description }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach

        </div>
        <div class="service-btn">
            <a href="#" class="amazing-btn">ابدأ اليوم <i class="icon-west"></i></a>
        </div>
    </div>
    <ul class="shape-group">
        <li class="shape-1" data-sal-delay="1000" data-sal="fade" data-sal-duration="1000">
            <img src="assets/images/others/rtl-shape-47.png" alt="Shape">
        </li>
        <li class="shape-2" data-sal-delay="1000" data-sal="fade" data-sal-duration="1000">
            <img class="rotateit" src="assets/images/others/shape-38.png" alt="Shape">
        </li>
        <li class="shape-3 scene" data-sal-delay="1000" data-sal="fade" data-sal-duration="1000">
            <span data-depth="2.5"></span>
        </li>
    </ul>
</div>