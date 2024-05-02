<section class="section-header section-header-top">
    <div class="container">
        <div class="row row-main">
            @include('frontend.v1.header.components.header-logo')
            @include('frontend.v1.header.components.header-search')
            <div class="header-account col-auto col-sm-auto col-md-auto col-lg-auto">
                @include('frontend.v1.header.components.header-account')
                @include('frontend.v1.header.components.header-wishlist')
                @include('frontend.v1.header.components.header-cart')
            </div>
        </div>
    </div>
</section>
