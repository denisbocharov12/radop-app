@extends('frontend.v1.layouts.layout')

@section('content')
    <section class="section-standart section-about">
        <div class="container">
            <div class="row align-items-center mb-5">
                <div class="col-md-6 order-md-2">
                    <h2>{{__('theme.rating')}}</h2>
                    <p>{{__('theme.rating-text')}}</p>
                </div>
                <div class="col-md-6 order-md-1">
                    <div class="img-container">
                        <img src="{{asset('/v1/frontend/assets')}}/images/raiting.jpg" alt="RAITING" class="img-fluid">
                    </div>
                </div>
            </div>

            <div class="row align-items-center mb-5">
                <div class="col-md-6">
                    <h2>{{__('theme.assortment')}}</h2>
                    <p>{{__('theme.assortment-text')}}</p>
                </div>
                <div class="col-md-6">
                    <div class="img-container">
                        <img src="{{asset('/v1/frontend/assets')}}/images/sortiment.png" alt="SORTIMENT" class="img-fluid">
                    </div>
                </div>
            </div>

            <div class="row align-items-center mb-5">
                <div class="col-md-6 order-md-2">
                    <h2>{{__('theme.production')}}</h2>
                    <p>{{__('theme.production-text')}}</p>
                </div>
                <div class="col-md-6 order-md-1">
                    <div class="img-container">
                        <img src="{{asset('/v1/frontend/assets')}}/images/producere.jpg" alt="PRODUCERE" class="img-fluid">
                    </div>
                </div>
            </div>

            <div class="row align-items-center mb-5">
                <div class="col-md-6">
                    <h2>{{__('theme.main-directives')}}</h2>
                    <p>{{__('theme.main-directives-1')}}</p>
                    <p>{{__('theme.main-directives-2')}}</p>
                </div>
                <div class="col-md-6">
                    <div class="img-container">
                        <img src="{{asset('/v1/frontend/assets')}}/images/directii.jpg" alt="DIRECTII" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>

        <section class="section-standart section-slider">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-slider">
                        <div class="wrap-slider" id="partners-slider">
                            @foreach($themeBrands as $brand)
                                <div class="item">
                                    <a href="{{route('theme.brand.index', $brand->id)}}">
                                        <img src="{{$brand->getFirstMediaUrl('media')}}" alt="{{$brand->title}}" />
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>
@endsection
