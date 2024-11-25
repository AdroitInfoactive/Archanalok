<section class="discount-section-2">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="discount-product overlay-anim">
                    <div class="content-ds">
                        <h3>
                            <span>{{ @$homeInfo->title }}</span>
                        </h3>
                        <p>
                            {!! @$homeInfo->description !!}
                        </p>
                        <a class="fishto-btn" href="{{ @$homeInfo->url }}">Know More</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="offser-text">
                    {!! @$homeInfo->short_description !!}
                </div>
            </div>
        </div>
    </div>
</section>