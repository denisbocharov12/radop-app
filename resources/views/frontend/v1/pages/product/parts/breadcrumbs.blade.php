<section class="section-standart section-breadcrumb section-breadcrumb-product">
    <div class="container">
        <div class="row">
            <div class="col-12 col-breadcrumb">
                <nav>
                    <ol class="breadcrumb text-white">
                        <li class="breadcrumb-item"><a href="{{route('theme.home')}}">Главная</a></li>
                        <li class="breadcrumb-item"><a href="{{route('theme.shop.index')}}">Каталог</a></li>
                        <li class="breadcrumb-item">
                            <a
                                class="active"
                                href="{{route('theme.product.index', $product->slug)}}"
                            >{{$product->title}}</a
                            >
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="col-12 col-breadcrumb-mobile">
                <nav>
                    <ol class="breadcrumb text-white">
                        <li class="breadcrumb-item"><a href="{{ url()->previous() }}">Назад</a></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
