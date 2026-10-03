{{-- Слайдер баннеров. Данные те же, что были в шаблоне главной. --}}
@if(! empty($heroSlides))
    <div class="sf-container pt-4 lg:pt-6" id="{{ $section['anchor'] }}">
        <div
            data-sf-island="hero-slider"
            data-sf-props="{{ $sfJson(['slides' => $heroSlides, 'autoplay' => (int) ($autoplaySpeed ?? 0)]) }}"
            v-cloak
        >
            {{-- До загрузки скриптов и без JS виден и кликается первый баннер. --}}
            <a href="{{ $heroSlides[0]['url'] }}">
                <img
                    src="{{ $heroSlides[0]['image'] }}"
                    alt="Radop"
                    class="aspect-[1232/400] w-full rounded-lg object-cover"
                    fetchpriority="high"
                    decoding="async"
                />
            </a>
        </div>
    </div>
@endif
