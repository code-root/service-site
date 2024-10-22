
<style>
    .cd-root-gallery-area {
        margin: 20px; /* هامش حول الـ div الكبيرة */
    }
    .thumbnail-x img {
        width: 45rem;
    height: 45rem;
    object-fit: cover;
    }
</style>

<div class="cd-root-gallery-area cd-root-section-gap">
    <div class="container">
        <div class="isotope-wrapper">
            <div class="isotop-button button-transparent isotop-filter">
                <button data-filter="*" class="is-checked">
                    <span class="filter-text">{{ session('locale') === 'ar' ? 'الكل' : 'All' }}</span>
                </button>
                @foreach($categories as $category)
                <button data-filter=".{{ $category->slug }}">
                    <span class="filter-text">{{ $category->{'name_' . session('locale')} }}</span>
                </button>
                @endforeach
            </div>
            <div class="row" @if(session('locale') == 'ar') style="direction: rtl;" @endif>
                @foreach($categories as $category)
                    @foreach($category->galleries as $gallery)
                    <div class="col-md-4 mb-4 {{ $category->slug }}">
                        <a href="{{ route('page.show', $gallery->page_id) }}" class="cd-root-popup-image cd-root-gallery-grid p-gallery-grid-wrap isotope-item" lg-event-uid="{{ $loop->iteration }}">
                            <div class="thumbnail-x">
                                <img src="{{ route('view-image', ['m' => 'App\Models\Gallery', 'id' => $gallery->id , 'nameVar'=> 'image']) }}" alt="Gallery Image" class="img-fluid">
                            </div>
                        </a>
                    </div>
                    @endforeach
                @endforeach
            </div>
        </div>
    </div>
</div>

