@extends('frontend.v1.layouts.layout')

@section('sf-page', 1)

@section('content')
    <x-sf-account-shell :title="__('theme.my-sale')">
        @if($user->sale === null || (float) $user->sale === 0.0)
            <div class="sf-card px-6 py-14 text-center">
                <x-sf-icon name="star" :size="40" class="mx-auto mb-3 text-ink-300" />
                <p class="text-md font-medium text-ink-700">{{ __('theme.no-my-sale') }}</p>
                <a href="{{ route('theme.shop.catalog') }}" class="sf-btn-primary mt-5 inline-flex">{{ __('theme.go-to-catalog') }}</a>
            </div>
        @else
            <div class="sf-card flex flex-col gap-5 overflow-hidden p-0 sm:flex-row">
                <div class="flex items-center justify-center bg-brand-600 px-8 py-8 text-white sm:w-56">
                    <p class="text-center">
                        <span class="block text-5xl font-extrabold leading-none">{{ rtrim(rtrim(number_format((float) $user->sale, 2, ',', ''), '0'), ',') }}%</span>
                        <span class="mt-2 block text-xs font-medium uppercase tracking-wide text-white/80">{{ __('theme.sale-heading') }}</span>
                    </p>
                </div>
                <div class="flex flex-1 flex-col justify-center p-5 sm:pl-0">
                    <p class="text-sm leading-relaxed text-ink-700">{{ __('theme.sale-description-info') }}</p>
                    <a href="{{ route('theme.shop.catalog') }}" class="sf-btn-secondary mt-4 self-start">{{ __('theme.go-to-catalog') }}</a>
                </div>
            </div>
        @endif
    </x-sf-account-shell>
@endsection
