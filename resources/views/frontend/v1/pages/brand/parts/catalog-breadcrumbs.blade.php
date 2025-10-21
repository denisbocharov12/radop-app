<section class="section-standart section-breadcrumb">
    <div class="container">
        <div class="row">
            <div class="col-12 col-breadcrumb">
                <nav>
                    <ol class="breadcrumb text-white d-none d-md-flex">
                        <li class="breadcrumb-item"><a href="{{route('theme.home')}}">{{__('theme.home')}}</a></li>
                        <li class="breadcrumb-item" aria-current="page"><a href="{{route('theme.brand.catalog')}}">{{__('theme.brands-catalog')}}</a></li>
                    </ol>
                    <ol class="breadcrumb text-white d-flex d-md-none">
                        @php
                            $all = collect([['url' => route('theme.home'), 'name' => __('theme.home')], ['url' => route('theme.brand.catalog'), 'name' => __('theme.brands-catalog')]])
                                ->merge($breadcrumbs ?? []);
                            $last = $all->last();
                        @endphp
                        <li class="breadcrumb-item active fw-bold" style="color: #000000" aria-current="page">
                            @if(isset($last['url']))
                                <a href="{{$last['url']}}" style="font-size: 18px;">{{$last['name']}}</a>
                            @else
                                {{$last['name'] ?? $last->name ?? ''}}
                            @endif
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

