<div class="edu-gallery-area edu-section-gap" style="{{ $locale === 'ar' ? 'direction: rtl;' : 'direction: ltr;' }}">
    <div class="container">
        <div class="isotope-wrapper">
            <div class="isotop-button button-transparent isotop-filter">
                <button data-filter="*" class="is-checked">
                    <span class="filter-text">All</span>
                </button>
                @foreach ($categories as $category)
                    <button data-filter=".{{ $category->slug }}">
                        <span class="filter-text">{{ $category->name_en }}</span>
                    </button>
                @endforeach
            </div>
            <div class="isotope-list gallery-grid-wrap">
                <div id="animated-thumbnials" lg-uid="lg0">
                    @foreach ($categories as $category)
                        @foreach ($category->galleries as $gallery)
                            <a href="{{ asset('public/storage/' . $gallery->image) }}"
                                class="edu-popup-image edu-gallery-grid p-gallery-grid-wrap isotope-item {{ $category->slug }}"
                                lg-event-uid="{{ $loop->iteration }}">
                                <div class="thumbnail">
                                    <img src="{{ asset('public/storage/' . $gallery->image) }}" width="360px"
                                        height="360px" alt="Gallery Image">
                                </div>
                            </a>
                        @endforeach
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
