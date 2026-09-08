@extends('frontend.v1.layouts.layout')

@section('sf-page', 1)

@section('content')
    <x-sf-breadcrumbs :with-shop="false" :items="[['url' => null, 'name' => __('theme.brands-catalog')]]" />

    <div class="sf-container pb-12">
        <h1 class="mb-6 mt-2 text-2xl font-bold text-ink-900 lg:text-3xl">{{ __('theme.brands-catalog') }}</h1>

        <ul class="grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6">
            @foreach($brands as $brand)
                <li>
                    <a
                        href="{{ route('theme.brand.index', $brand->onec_id) }}"
                        class="flex h-full flex-col items-center gap-2 rounded-lg border border-ink-200 bg-white p-4 text-center transition-all duration-200 hover:border-brand-300 hover:shadow-card-hover"
                    >
                        <span class="flex h-14 items-center justify-center">
                            @if($brand->hasMedia('media'))
                                <img
                                    src="{{ $brand->getFirstMediaUrl('media', 'thumb') }}"
                                    alt="{{ $brand->title }}"
                                    class="max-h-14 w-auto object-contain"
                                    loading="lazy"
                                />
                            @else
                                <span class="flex h-12 w-12 items-center justify-center rounded-full bg-brand-50 text-md font-bold uppercase text-brand-600">
                                    {{ Str::limit($brand->title, 2, '') }}
                                </span>
                            @endif
                        </span>

                        <span class="text-sm font-medium text-ink-800">{{ $brand->title }}</span>

                        @if($brand->products_count > 0)
                            <span class="text-2xs text-ink-400">
                                {{ $brand->products_count }}
                                @if($brand->products_count == 1)
                                    {{ __('theme.product-single') }}
                                @elseif($brand->products_count <= 4)
                                    {{ __('theme.products-few') }}
                                @else
                                    {{ __('theme.products-many') }}
                                @endif
                            </span>
                        @endif
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
