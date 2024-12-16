@if(!empty($query))
    <div class="col-12 products-not-found mb-5">
        <div class="wrap">
            <p>{{__('theme.products_not_found_for_query')}}</p>
        </div>
    </div>
@else
    <div class="col-12 products-not-found mb-5">
        <div class="wrap">
            <p>{{__('theme.missing-category')}}</p>
        </div>
    </div>
@endif
