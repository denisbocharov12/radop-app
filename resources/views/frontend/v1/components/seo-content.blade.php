{{-- Long-form body copy for category / brand listings. Renders only when
     content is non-empty. Editors paste pre-formatted HTML. --}}
@php
    $seoContent = $seoContent ?? null;
@endphp
@if(is_string($seoContent) && trim($seoContent) !== '')
    <section class="section-standart section-seo-content pt-2 pb-4">
        <div class="container">
            <div class="seo-content-wrap">
                {!! $seoContent !!}
            </div>
        </div>
    </section>
@endif
