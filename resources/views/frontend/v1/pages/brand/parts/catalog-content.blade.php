<section class="section-standart section-brands-catalog">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="heading">
                    <h1>{{__('theme.all-brands')}}</h1>
                </div>
            </div>
        </div>
        <div class="row brands-catalog-grid">
            @foreach($brands as $brand)
                @include('frontend.v1.pages.brand.parts.catalog-brand-card', ['brand' => $brand])
            @endforeach
        </div>
    </div>
</section>

