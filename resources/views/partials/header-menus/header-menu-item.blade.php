@php
    $locale = app()->getLocale();
    $itemTitle = $item->getTranslation('title', $locale);
    $itemLink = $item->getTranslation('link', $locale);
    $itemImage = $item->getFirstMedia('header_menu_item_image');
    $hasChildren = $item->children && $item->children->isNotEmpty();

    $productsCount = $item->products_count ?? 0;
@endphp

<li class="item megamenu">
    <a href="{{ $itemLink ?? '#' }}" class="link link-megamenu" target="{{ $item->target ?? '_self' }}">
        @if($itemImage)
            <img src="{{ $itemImage->getUrl() }}" alt="{{ $itemTitle }}" style="width: 22px; height: 22px; margin-right: 5px">
        @endif
        {{ $itemTitle }}
    </a>
    @if($hasChildren)
        <div class="megamenu-wrap">
            <div class="container container-megamenu">
                <div class="row row-megamenu">
                    <div class="col-12 col-content-megamenu" id="js-content-megamenu">
                        <div class="row row-list-content">
                            @foreach($item->children->values() as $child)
                                @php
                                    $childTitle = $child->getTranslation('title', $locale);
                                    $childLink = $child->getTranslation('link', $locale);
                                    $childImage = $child->getFirstMedia('header_menu_item_image');
                                    $hasGrandChildren = $child->children && $child->children->isNotEmpty();

                                    $childProductsCount = $child->products_count ?? 0;
                                @endphp
                                <div class="col-4 col-list-content">
                                    <a href="{{ $childLink ?? '#' }}" class="heading" target="{{ $child->target ?? '_self' }}">
                                        @if($childImage)
                                            <img src="{{ $childImage->getUrl() }}" alt="{{ $childTitle }}" style="width: 22px; height: 22px; margin-right: 5px">
                                        @endif
                                        {{ $childTitle }}
                                        @if($childProductsCount > 0)
                                            <span style="color: #999; font-size: 14px;">({{ $childProductsCount }})</span>
                                        @endif
                                    </a>
                                    @if($hasGrandChildren)
                                        @include('partials.header-menus.header-menu-item-column', ['category' => $child])
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</li>

