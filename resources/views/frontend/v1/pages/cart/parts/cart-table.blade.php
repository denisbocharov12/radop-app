<section class="section-content section-shopping-cart padding-y bg">
    <div class="container">
        <div class="row">
            <div class="col-12 col-cart-heading">
                <div class="heading">
                    <h1>{{__('theme.cart')}}</h1>
                </div>
            </div>
        </div>
        <div class="row cart-page">
            @include('frontend.v1.components.cart-table')
        </div>
    </div>
</section>
