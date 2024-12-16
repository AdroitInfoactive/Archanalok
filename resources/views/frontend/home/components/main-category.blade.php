<section class="popular-section section-padding">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 text-center">
                <h2 class="sec_titles" style="font-family: 'Poppins', sans-serif;">Categories</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="popular-slider owl-carousel">
                    @foreach(@$mainCategory as $category)
                        <div class="product-item-2 text-center">
                            <div class="product-thumb"> 
                                <a href="{{ route('maincategory.show', $category->slug) }}">
                                    <img src="{{ asset(@$category->image ?: @$category->logo) }}" alt="{{ $category->name }}">
                                </a>
                            </div>
                            <div class="product-details">
                                <h5>
                                    <a href="{{ route('maincategory.show', $category->slug) }}">{{ $category->name }}</a>
                                </h5>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
