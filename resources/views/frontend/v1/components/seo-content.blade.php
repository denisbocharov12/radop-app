{{-- Long-form body copy for category / brand listings. Renders only when
     content is non-empty. Editors paste pre-formatted HTML, so it is handed to
     `.sf-prose` rather than styled per element here. --}}
@php
    $seoContent = $seoContent ?? null;
@endphp

@if(is_string($seoContent) && trim($seoContent) !== '')
    <section class="sf-section pt-2">
        <div class="sf-container">
            <div class="sf-prose max-w-none">
                {!! $seoContent !!}
            </div>
        </div>
    </section>
@endif
