<div class="col-lg-3 col-md-4 col-6 brand-catalog-item">
    <a href="{{route('theme.brand.index', $brand->onec_id)}}" class="brand-card drop-shadow">
        <div class="brand-card-image">
            @if($brand->hasMedia('media'))
                <img src="{{$brand->getFirstMediaUrl('media', 'thumb')}}" alt="{{$brand->title}}" loading="lazy"/>
            @else
                <div class="brand-card-placeholder">
                    <span>{{Str::limit($brand->title, 2, '')}}</span>
                </div>
            @endif
        </div>
        <div class="brand-card-content">
            <h3 class="brand-card-title">{{$brand->title}}</h3>
            @if($brand->products_count > 0)
                <div class="brand-card-products-count">
                    <span class="count">{{$brand->products_count}}</span>
                    <span class="text">
                        @if($brand->products_count == 1)
                            {{__('theme.product-single')}}
                        @elseif($brand->products_count >= 2 && $brand->products_count <= 4)
                            {{__('theme.products-few')}}
                        @else
                            {{__('theme.products-many')}}
                        @endif
                    </span>
                </div>
            @endif
        </div>
    </a>
</div>

