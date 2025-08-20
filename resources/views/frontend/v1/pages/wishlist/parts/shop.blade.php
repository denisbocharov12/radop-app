<section class="section-standart section-wishlist pt-0">
    <div class="container">
        <div class="col-12 col-wishlist-heading">
            <div class="heading">
                <h1>{{__('theme.wishlist')}}</h1>
            </div>
            <hr />
        </div>
    </div>
    <div class="container">
        <div class="row row-category-list">
            @if(app('wishlist')->getContent()->count() < 1)
                @include('frontend.v1.pages.wishlist.parts.not-found')
            @else
                <div class="col-12">
                    <div class="{{app('wishlist')->getContent()->count() < 1 ? 'row' : 'grid-products-list-wrap'}}" >
                        @include('frontend.v1.pages.wishlist.parts.list')
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>

<section class="section-standart section-slider section-brand-slider">
    <div class="container">
        <div class="row">
            <div class="col-12 col-slider">
                <div class="wrap-slider theme-slider" id="partners-slider">
                    @foreach($themeBrands as $brand)
                        <div class="item">
                            <a href="{{route('theme.brand.index', $brand->onec_id)}}">
                                <img src="{{$brand->getFirstMediaUrl('media', 'thumb')}}" alt="{{$brand->title}}" loading="lazy"/>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
