{{-- Топ-категории: компактные блоки «иконка + название» вместо прежней полосы
     меню в шапке. Состав и порядок задаются в админке, заголовка у секции нет —
     блок работает как быстрый вход в каталог. --}}
<section class="sf-container sf-top-cats-section" id="{{ $section['anchor'] }}" aria-label="{{ __('theme.navigation-menu') }}">
    <ul class="sf-top-cats" style="--sf-top-cats: {{ $section['categories']->count() }}">
        @foreach($section['categories'] as $category)
            <li>
                <a href="{{ $category['url'] }}" class="sf-top-cat" title="{{ $category['name'] }}">
                    <span class="sf-top-cat-icon">
                        @if($category['icon'])
                            <img src="{{ $category['icon'] }}" alt="" class="h-5 w-5 object-contain" loading="lazy" decoding="async" />
                        @else
                            <x-sf-icon name="grid" :size="18" class="text-brand-600" />
                        @endif
                    </span>
                    <span class="sf-top-cat-name">{{ $category['name'] }}</span>
                </a>
            </li>
        @endforeach
    </ul>
</section>
