@php
    $hasChildren = $item->children && $item->children->where('type', '!=', 'widget_link')->isNotEmpty();
    $depthClass = 'mega-menu__item--depth-' . $depth;
    $typeClass = 'mega-menu__item--' . $item->type;
@endphp

<li class="mega-menu__item {{ $depthClass }} {{ $typeClass }} @if($hasChildren) mega-menu__item--has-children @endif"
    data-item-id="{{ $item->id }}"
    data-item-type="{{ $item->type }}">

    @if($item->type === 'promo_block')
        {{-- Promo Block Type --}}
        <div class="mega-menu__promo">
            @if($item->icon_class)
                <i class="{{ $item->icon_class }} mega-menu__icon"></i>
            @endif

            <div class="mega-menu__promo-content">
                <h4 class="mega-menu__promo-title">{{ $item->title }}</h4>

                @if($item->content_data)
                    @if(isset($item->content_data['description']))
                        <p class="mega-menu__promo-description">{{ $item->content_data['description'] }}</p>
                    @endif

                    @if(isset($item->content_data['image']))
                        <img src="{{ $item->content_data['image'] }}"
                             alt="{{ $item->title }}"
                             class="mega-menu__promo-image">
                    @endif

                    @if(isset($item->content_data['badge']))
                        <span class="mega-menu__promo-badge">{{ $item->content_data['badge'] }}</span>
                    @endif
                @endif

                @if($item->link)
                    <a href="{{ $item->link }}"
                       target="{{ $item->target }}"
                       class="mega-menu__promo-link">
                        {{ $item->content_data['link_text'] ?? __('theme.menu.view_more') }}
                    </a>
                @endif
            </div>
        </div>

    @elseif($item->link)
        {{-- Category or Custom Link with URL --}}
        <a href="{{ $item->link }}"
           target="{{ $item->target }}"
           class="mega-menu__link">

            @if($item->icon_class)
                <i class="{{ $item->icon_class }} mega-menu__icon"></i>
            @endif

            <span class="mega-menu__title">{{ $item->title }}</span>

            @if($hasChildren)
                <i class="mega-menu__arrow"></i>
            @endif
        </a>

    @else
        {{-- Category without direct link (just a label) --}}
        <span class="mega-menu__label">
            @if($item->icon_class)
                <i class="{{ $item->icon_class }} mega-menu__icon"></i>
            @endif

            <span class="mega-menu__title">{{ $item->title }}</span>

            @if($hasChildren)
                <i class="mega-menu__arrow"></i>
            @endif
        </span>
    @endif

    {{-- Recursive Children Rendering --}}
    @if($hasChildren)
        <ul class="mega-menu__list mega-menu__list--depth-{{ $depth + 1 }}">
            @php
                $locale = app()->getLocale();
            @endphp
            @foreach($item->children->where('type', '!=', 'widget_link')->sortBy(function($child) use ($locale) {
                $titleRaw = $child->getRawOriginal('title');
                $title = is_array(json_decode($titleRaw, true))
                    ? $child->getTranslation('title', $locale)
                    : ($titleRaw ?? '');
                return mb_strtolower($title);
            })->values() as $child)
                @include('partials.menus.mega-menu-item', ['item' => $child, 'depth' => $depth + 1])
            @endforeach
        </ul>
    @endif
</li>

