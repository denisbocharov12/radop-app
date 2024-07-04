<section class="section-standart section-breadcrumb">
    <div class="container">
        <div class="row">
            <div class="col-12 col-breadcrumb">
                <nav>
                    <ol class="breadcrumb text-white">
                        <li class="breadcrumb-item"><a href="{{route('theme.home')}}">{{__('theme.home')}}</a></li>
                        <li class="breadcrumb-item"><a href="{{route('theme.shop.index')}}">{{__('theme.shop')}}</a></li>
                        @foreach($breadcrumbs as $item)
                            @include('frontend.v1.pages.brand.parts.breadcrumb-item', $item)
                        @endforeach
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
