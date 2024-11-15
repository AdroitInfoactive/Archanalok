<section class="slider-section">
    <div class="hero-slider owl-carousel anim_class">
        @foreach ($bannerSliders as $bannerSlider )
        <div class="single-slide bg-img d-flex align-items-center" data-bg-image="{{ asset(@$bannerSlider->banner) }}">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="slider-content">
                            <h5 class="sub-title animated">{!! insertBreaks($bannerSlider->sub_title) !!} <span></span></h5>
                            <h2 class="animated">{{ $bannerSlider->title }}</h2>
                            <a href="#" class="fishto-btn animated">Get A Quote <i
                                    class="nss-long-arrow-right1"></i></a>
                            <a href="#" class="fishto-btn sb2 animated">Shop Now <i
                                    class="nss-long-arrow-right1"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       @endforeach
    </div>
</section>