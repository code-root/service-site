<div class="amazing-faq-area faq-style-12 section-gap-equal"
    @if($locale == 'ar') style="direction: rtl;" @endif>
    <div class="container">
        <div class="row g-5 row--45">
            <div class="col-lg-6">
                <div class="amazing-faq-content">
                    <div class="section-title section-left" data-sal-delay="50" data-sal="slide-up"
                        data-sal-duration="1000">
                        <span class="pre-title color-secondary">{{ $settings['faq_pre_title'] ?? 'FAq’s' }}</span>
                        <h2 class="title">{{ $settings['faq_title'] ?? 'Over 10 Years in Distant Skill Development' }}
                        </h2>
                        <span class="shape-line"><i class="icon-19"></i></span>
                        <p>{{ $settings['faq_description'] ?? 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eius mod tempor incididunt labore dolore magna.' }}
                        </p>
                    </div>
                    <div class="faq-accordion" id="faq-accordion" data-sal-delay="50" data-sal="slide-up"
                        data-sal-duration="1000">
                        <div class="accordion">
                            @foreach ($faqs as $faq)
                                <div class="accordion-item">
                                    <h5 class="accordion-header">
                                        <button class="accordion-button {{ $loop->first ? '' : 'collapsed' }}"
                                            type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse{{ $loop->index }}"
                                            aria-expanded="{{ $loop->first ? 'true' : 'false' }}">
                                            {{ $faq->{'question_' . $locale} }}
                                        </button>
                                    </h5>
                                    <div id="collapse{{ $loop->index }}"
                                        class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}"
                                        data-bs-parent="#faq-accordion">
                                        <div class="accordion-body">
                                            <p>{{ $faq->{'answer_' . $locale} }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="amazing-faq-gallery">
                    <div class="faq-thumbnail thumbnail-1" data-sal-delay="50" data-sal="slide-up"
                        data-sal-duration="1000">
                        <img src="https://static.semrush.com/blog/uploads/media/58/b7/58b7eaacbb07317b6d97d6dc1b15f7b2/faq-templates-examples.svg"
                            alt="Faq Images">
                    </div>

                    <ul class="shape-group">
                        <li class="shape-1 scene" data-sal-delay="500" data-sal="fade" data-sal-duration="200">
                            <img data-depth="1.5" src="assets/site/images/faq/shape-18.png" alt="Shape Images">
                        </li>
                        <li class="shape-2 scene" data-sal-delay="500" data-sal="fade" data-sal-duration="200">
                            <img data-depth="-1.5" src="assets/site/images/faq/shape-17.png" alt="Shape Images">
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
