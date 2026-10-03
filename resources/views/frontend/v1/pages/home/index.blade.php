@extends('frontend.v1.layouts.layout')

@section('sf-page', 1)

@section('content')
    @php
        $sfJson = static fn (array $data): string => json_encode(
            $data,
            JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE
        );

        $heroSlides = collect($banners ?? [])->map(fn ($banner) => [
            'id' => $banner->id,
            'url' => $banner->linkForLocale(),
            'image' => asset('storage/' . ($locale === 'ro' ? $banner->image_path_ro : $banner->image_path_ru)),
            'alt' => 'Radop',
        ])->values()->all();

    @endphp

    <h1 class="sf-sr-only">{{ __('seo.home_h1') }}</h1>

    {{-- Главная собирается из секций: порядок, видимость и настройки лежат в
         таблице home_sections и правятся в админке. --}}
    @foreach($homeSections ?? [] as $section)
        @includeIf('frontend.v1.pages.home.sections.' . str_replace('_', '-', $section['type']), ['section' => $section])
    @endforeach

@endsection

@section('scripts')
    @include('frontend.v1.analytics.ga4-item-lists')
    {{-- Показ баннеров считает сам слайдер — по факту появления на экране,
         один раз на баннер (см. HeroSlider.vue). --}}
@endsection
