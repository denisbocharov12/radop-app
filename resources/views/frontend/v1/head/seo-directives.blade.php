{{-- Теги <head> собираются по слоям в App\Services\Seo\SeoHeadLayers: канонический
     адрес, директивы индексации, суффикс заголовка, номер страницы, OG и Twitter.
     Вызывается до SEOMeta::generate(), иначе получим два canonical. --}}
@php
    app(\App\Services\Seo\SeoHeadLayers::class)->apply(request());
@endphp
