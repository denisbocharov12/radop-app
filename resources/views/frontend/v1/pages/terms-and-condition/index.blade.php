@extends('frontend.v1.layouts.layout')

@section('sf-page', 1)

@section('content')
    <x-sf-page>
                <h1>{{ __('terms-and-conditions.terms-and-conditions') }}</h1>
                <p>{!! __('terms-and-conditions.introduction-1') !!}</p>
                <p>{!! __('terms-and-conditions.introduction-2') !!}</p>
                <p>{{ __('terms-and-conditions.introduction-3') }}</p>
                <h2>1. {{ __('terms-and-conditions.general-provisions') }}</h2>
                <p>1.1. {{ __('terms-and-conditions.general-provisions-1') }}</p>
                <p>1.2. {{ __('terms-and-conditions.general-provisions-2') }}</p>
                <p>1.3. {{ __('terms-and-conditions.general-provisions-3') }}</p>
                <p>1.4. {{ __('terms-and-conditions.general-provisions-4') }}</p>
                <p>1.5. {{ __('terms-and-conditions.general-provisions-5') }}</p>
                <p>1.6. {{ __('terms-and-conditions.general-provisions-6') }}</p>
                <p>1.7. {{ __('terms-and-conditions.general-provisions-7') }}</p>
                <p>1.8. {{ __('terms-and-conditions.general-provisions-8') }}</p>
                <h2>2. {{ __('terms-and-conditions.definitions') }}</h2>
                <p>2.1. {!! __('terms-and-conditions.definitions-1') !!}</p>
                <p>2.2. {{ __('terms-and-conditions.definitions-2') }}</p>
                <p>2.3. {!! __('terms-and-conditions.definitions-3') !!}</p>
                <p>2.4. {!! __('terms-and-conditions.definitions-4') !!}</p>
                <p>2.5. {{ __('terms-and-conditions.definitions-5') }}</p>
                <p>2.6. {{ __('terms-and-conditions.definitions-6') }}</p>
                <p>2.7. {{ __('terms-and-conditions.definitions-7') }}</p>
                <h2>3. {{ __('terms-and-conditions.registration') }}</h2>
                <p>3.1. {{ __('terms-and-conditions.registration-1') }}</p>
                <h2>4. {{ __('terms-and-conditions.order-process') }}</h2>
                <p>4.1. {{ __('terms-and-conditions.order-process-1') }}</p>
                <p>4.2. {{ __('terms-and-conditions.order-process-2') }}</p>
                <p>{{ __('terms-and-conditions.order-process-2-1') }}</p>
                <p>{{ __('terms-and-conditions.order-process-2-2') }}</p>
                <p>{{ __('terms-and-conditions.order-process-2-3') }}</p>
                <p>{{ __('terms-and-conditions.order-process-2-4') }}</p>
                <p>4.3. {{ __('terms-and-conditions.order-process-3') }}</p>
                <p>4.4. {{ __('terms-and-conditions.order-process-4') }}</p>
                <p>4.5. {!! __('terms-and-conditions.order-process-5') !!}</p>
                <p>4.6. {{ __('terms-and-conditions.order-process-6') }}</p>
                <p>4.7. {{ __('terms-and-conditions.order-process-7') }}</p>
                <h2>5. {{ __('terms-and-conditions.delivery') }}</h2>
                <p>5.1. {{ __('terms-and-conditions.delivery-1') }}</p>
                <p>5.2. {{ __('terms-and-conditions.delivery-2') }}</p>
                <p>5.3. {{ __('terms-and-conditions.delivery-3') }}</p>
                <p>5.4. {{ __('terms-and-conditions.delivery-4') }}</p>
                <p>5.5. {{ __('terms-and-conditions.delivery-5') }}</p>
                <p>5.6. {{ __('terms-and-conditions.delivery-6') }}</p>
                <h2>6. {{ __('terms-and-conditions.payment-terms') }}</h2>
                <p>6.1. {{ __('terms-and-conditions.payment-terms-1') }}</p>
                <p>6.2. {{ __('terms-and-conditions.payment-terms-2') }}</p>
                <p>6.3. {{ __('terms-and-conditions.payment-terms-3') }}</p>
                <p>6.4. {{ __('terms-and-conditions.payment-terms-4') }}</p>
                <p>6.5. {{ __('terms-and-conditions.payment-terms-5') }}</p>
                <p>6.6. {{ __('terms-and-conditions.payment-terms-6') }}</p>
                <p>6.7. {{ __('terms-and-conditions.payment-terms-7') }}</p>
                <p>6.7.1. {{ __('terms-and-conditions.payment-terms-7-1') }}</p>
                <p>6.7.2. {{ __('terms-and-conditions.payment-terms-7-2') }}</p>
                <p>6.7.3. {{ __('terms-and-conditions.payment-terms-7-3') }}</p>
                <h2>7. {{ __('terms-and-conditions.return-terms') }}</h2>
                <p>7.1. {{ __('terms-and-conditions.return-terms-1') }}</p>
                <p>7.1.1. {{ __('terms-and-conditions.return-terms-1-1') }}</p>
                <p>7.1.2. {{ __('terms-and-conditions.return-terms-1-2') }}</p>
                <p>7.1.3. {{ __('terms-and-conditions.return-terms-1-3') }}</p>
                <p>7.1.4. {{ __('terms-and-conditions.return-terms-1-4') }}</p>
                <p>7.1.5. {{ __('terms-and-conditions.return-terms-1-5') }}</p>
                <p>7.1.6. {{ __('terms-and-conditions.return-terms-1-6') }}</p>
                <p>7.2. {{ __('terms-and-conditions.return-terms-2') }}</p>
                <p>7.2.1. {{ __('terms-and-conditions.return-terms-2-1') }}</p>
                <p>7.2.2. {{ __('terms-and-conditions.return-terms-2-2') }}</p>
                <p>7.3. {{ __('terms-and-conditions.refund-terms') }}</p>
                <p>7.3.1. {{ __('terms-and-conditions.refund-terms-1') }}</p>
                <p>7.4. {{ __('terms-and-conditions.assortment-terms') }}</p>
                <p>7.4.1. {{ __('terms-and-conditions.assortment-terms-1') }}</p>
                <p>7.4.2. {{ __('terms-and-conditions.assortment-terms-2') }}</p>
                <p>7.5. {!! __('terms-and-conditions.claim-terms') !!}</p>
                <h2>8. {{ __('terms-and-conditions.privacy-policy') }}</h2>
                <p>8.1. {!! __('terms-and-conditions.privacy-policy-1') !!}</p>
                <p>8.2. {{ __('terms-and-conditions.privacy-policy-2') }}</p>
                <p>8.3. {{ __('terms-and-conditions.privacy-policy-3') }}</p>
                <p>8.4. {{ __('terms-and-conditions.privacy-policy-4') }}</p>
                <h2>9. {{ __('terms-and-conditions.cookie-policy') }}</h2>
                <p>9.1. {{ __('terms-and-conditions.cookie-policy-1') }}</p>
                <p>9.2. {{ __('terms-and-conditions.cookie-policy-2') }}</p>
                <h2>10. {{ __('terms-and-conditions.security-measures') }}</h2>
                <p>{{ __('terms-and-conditions.security-measures-1') }}</p>
                <h2>11. {{ __('terms-and-conditions.minor-users') }}</h2>
                <p>{{ __('terms-and-conditions.minor-users-1') }}</p>
                <h2>12. {{ __('terms-and-conditions.other-conditions') }}</h2>
                <p>12.1. {{ __('terms-and-conditions.other-conditions-1') }}</p>
                <p>12.2. {!! __('terms-and-conditions.other-conditions-2') !!}</p>
                <p>12.3. {{ __('terms-and-conditions.other-conditions-3') }}</p>
                <h2>{{ __('terms-and-conditions.non-exchangeable-products') }}</h2>
                <p>1. {{ __('terms-and-conditions.non-exchangeable-products-1') }}</p>
                <p>2. {{ __('terms-and-conditions.non-exchangeable-products-2') }}</p>
                <p>3. {{ __('terms-and-conditions.non-exchangeable-products-3') }}</p>
                <p>4. {{ __('terms-and-conditions.non-exchangeable-products-4') }}</p>
                <p>5. {{ __('terms-and-conditions.non-exchangeable-products-5') }}</p>
                <p>6. {{ __('terms-and-conditions.non-exchangeable-products-6') }}</p>
                <p>7. {{ __('terms-and-conditions.non-exchangeable-products-7') }}</p>
                <p>8. {{ __('terms-and-conditions.non-exchangeable-products-8') }}</p>
                <p>9. {{ __('terms-and-conditions.non-exchangeable-products-9') }}</p>
                <p>10. {{ __('terms-and-conditions.non-exchangeable-products-10') }}</p>
                <p>11. {{ __('terms-and-conditions.non-exchangeable-products-11') }}</p>
                <p>12. {{ __('terms-and-conditions.non-exchangeable-products-12') }}</p>
                <p>13. {{ __('terms-and-conditions.non-exchangeable-products-13') }}</p>
                <h2>{{ __('terms-and-conditions.data-protection') }}</h2>
                <h2>{{ __('terms-and-conditions.claims') }}</h2>
                <p>{{ __('terms-and-conditions.claims-1') }}</p>
                <p>{{ __('terms-and-conditions.claims-2') }}</p>
                <p>{!! __('terms-and-conditions.claims-3') !!}</p>
                <p>{!! __('terms-and-conditions.claims-4') !!}</p>
                <p>{!! __('terms-and-conditions.claims-5') !!}</p>
    </x-sf-page>
@endsection
