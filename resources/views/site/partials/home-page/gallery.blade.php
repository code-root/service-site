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
                    <span class="filter-text">All</span>
                </button>
                @foreach($categories as $category)
                <button data-filter=".{{ $category->name_en }}">
                    <span class="filter-text">{{ $category->name_en }}</span>
                </button>
                @endforeach
      
            </div>
            <div class="isotope-list gallery-grid-wrap">
                <div id="animated-thumbnials">
                    @foreach($categories as $category)
                    @foreach($category->galleries as $gallery)
                    <a href="{{ route('page.show', $gallery->page_id) }}" class="cd-root-gallery-grid isotope-item {{ $category->name_en }}">
                        <div class="thumbnail">
                            <img src="{{ route('view-image', ['m' => 'App\Models\Gallery', 'id' => $gallery->id , 'nameVar'=> 'image']) }}" alt="{{ $category->name_en }}">
                        </div>
                    </a>
                    @endforeach
                @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
