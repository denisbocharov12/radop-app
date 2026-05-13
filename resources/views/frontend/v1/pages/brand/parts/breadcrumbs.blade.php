<section class="section-standart section-breadcrumb">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-12 col-breadcrumb d-md-flex">
                <nav>
                    <ol class="breadcrumb text-white d-md-flex">
                        <li class="breadcrumb-item"><a href="{{route('theme.home')}}">{{__('theme.home')}}</a></li>
                        <li class="breadcrumb-item"><a href="{{route('theme.shop.catalog')}}" class="js-trigger-mega-menu">{{__('theme.shop')}}</a></li>
                        @foreach($breadcrumbs as $item)
                            @include('frontend.v1.pages.brand.parts.breadcrumb-item', $item)
                        @endforeach
                    </ol>
                </nav>
            </div>
            <div class="col-6 col-sm-7 col-md-9">
                <nav>
                    <ol class="breadcrumb text-white d-flex mb-0">
                        @php
                            $all = collect([['url' => route('theme.home'), 'name' => __('theme.home')], ['url' => route('theme.shop.catalog'), 'name' => __('theme.shop')]])
                                ->merge($breadcrumbs ?? []);
                            $last = $all->last();
                        @endphp
                        {{-- SEO P0 §3.3 — visually-prominent last breadcrumb item is the
                             de-facto page heading; promote to a real <h1>. --}}
                        <li class="breadcrumb-item active" aria-current="page">
                            <h1 class="breadcrumb-h1">{{ is_array($last) ? ($last['title'] ?? $last['name'] ?? '') : (is_object($last) ? ($last->title ?? $last->name ?? '') : '') }}</h1>
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="col-6 col-sm-5 col-md-3">
                @include('frontend.v1.pages.brand.parts.export-excel')
            </div>
        </div>
    </div>
</section>
