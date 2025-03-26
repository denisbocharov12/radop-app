@extends('frontend.v1.layouts.layout')

@section('content')
    <section class="section-page">
        <div class="about-us-section">
            <div class="container">
                <h1>{{ __('about-us.about-us') }}</h1>
                <h2>{{ __('about-us.welcome') }}</h2>
                <p>{{ __('about-us.about') }}</p>
                <p>{!! __('about-us.mission') !!}</p>

                <h2>{{ __('about-us.offers') }}</h2>
                <p>{{ __('about-us.offers-1') }}</p>

                <h2>{{ __('about-us.brands') }}</h2>
                <p>{{ __('about-us.activities') }}</p>

                <h3>{{ __('about-us.wholesale_distribution') }}</h3>
                <p>{{ __('about-us.wholesale_distribution_desc') }}</p>

                <h3>{{ __('about-us.retail_supplies') }}</h3>
                <p>{{ __('about-us.retail_supplies_desc') }}</p>

                <h3>{{ __('about-us.online_supplies') }}</h3>
                <p>{{ __('about-us.online_supplies_desc') }}</p>

                <h3>{{ __('about-us.own_production') }}</h3>
                <p>{{ __('about-us.own_production_desc') }}</p>

                <h2>{{ __('about-us.categories') }}</h2>
                @foreach(__('about-us.categories_list') as $category)
                    <p>{{ $category }}</p>
                @endforeach

                <h2>{{ __('about-us.products') }}</h2>
                @foreach(__('about-us.products_list') as $product)
                    <p>{{ $product }}</p>
                @endforeach

                <h2>{{ __('about-us.own_production_details') }}</h2>
                @foreach(__('about-us.own_production_list') as $ownProduct)
                    <p>{{ $ownProduct }}</p>
                @endforeach

                <h2>{{ __('about-us.advantages') }}</h2>
                @foreach(__('about-us.advantages_list') as $advantage)
                    <p>{{ $advantage }}</p>
                @endforeach

                <h2>{{ __('about-us.company_info') }}</h2>
                <p>{{ __('about-us.company_details.name') }}</p>
                <p>{{ __('about-us.company_details.address') }}</p>
                <p>{{ __('about-us.company_details.fiscal_code') }}</p>
                <p>{{ __('about-us.company_details.vat') }}</p>
                <p>{{ __('about-us.company_details.bank') }}</p>
                <p>{{ __('about-us.company_details.iban') }}</p>
                <p>{{ __('about-us.company_details.bic') }}</p>
                <p>{!! __('about-us.company_details.phone') !!}</p>
                <p>{!!__('about-us.company_details.email') !!}</p>

                <h2>{{ __('about-us.slogan') }}</strong></h2>
            </div>
        </div>
    </section>
@endsection
