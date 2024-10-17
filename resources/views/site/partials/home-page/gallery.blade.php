<style>
    .edu-gallery-area {
        margin: 20px; /* هامش حول الـ div الكبيرة */
    }
    .thumbnail img {
        width: 45rem;
    height: 45rem;
    object-fit: cover;
    }
</style>

<div class="edu-gallery-area edu-section-gap" style="{{ $locale === 'ar' ? 'direction: rtl;' : 'direction: ltr;' }}">
    <div class="container">
        <div class="isotope-wrapper">
            <div class="isotop-button button-transparent isotop-filter">
                <button data-filter="*" class="is-checked"><span class="filter-text">All</span></button>
                @foreach($categories as $category)
                <button data-filter=".{{ $category->slug }}">
                    <span class="filter-text">{{ $category->name_en }}</span>
                </button>
                @endforeach
            </div>
            <div class="row">
                @foreach($categories as $category)
                    @foreach($category->galleries as $gallery)
                    <div class="col-md-4 mb-4 {{ $category->slug }}">

                        <a href="{{ asset('/back-end/storage/' . $gallery->image) }}" class="edu-popup-image edu-gallery-grid p-gallery-grid-wrap isotope-item" lg-event-uid="{{ $loop->iteration }}">
                            <div class="thumbnail">
                                <img src="{{ asset('/back-end/storage/' . $gallery->image) }}" alt="Gallery Image" class="img-fluid">
                            </div>
                        </a>
                        
                    </div>
                    @endforeach
                @endforeach
            </div>
        </div>
    </div>
</div>