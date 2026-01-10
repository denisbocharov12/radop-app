@php
    $locale = app()->getLocale();
    $itemTitle = $item->getTranslation('title', $locale);
    $itemLink = $item->getTranslation('link', $locale);
    $itemImage = $item->getFirstMedia('header_menu_item_image');
    $hasChildren = $item->children && $item->children->isNotEmpty();

    $productsCount = 0;
    if ($item->category_id) {
        $category = \App\Models\Category::where('onec_id', $item->category_id)->first();
        if ($category) {
            $productsCount = $category->products()
                ->where('status', true)
                ->where('site_status', true)
                ->where('stock', '!=', 0)
                ->count();
        }
    }
@endphp

<li class="item megamenu">
    <a href="{{ $itemLink ?? '#' }}" class="link link-megamenu" target="{{ $item->target ?? '_self' }}">
        @if($itemImage)
            <img src="{{ $itemImage->getUrl() }}" alt="{{ $itemTitle }}" style="width: 22px; height: 22px; margin-right: 5px">
        @endif
        {{ $itemTitle }}
        @if($productsCount > 0)
            <span style="color: #999; font-size: 14px;">({{ $productsCount }})</span>
        @endif
    </a>
    @if($hasChildren)
        <div class="megamenu-wrap">
            <div class="container container-megamenu">
                <div class="row row-megamenu">
                    <div class="col-12 col-content-megamenu" id="js-content-megamenu">
                        <div class="row row-list-content">
                            @foreach($item->children->sortBy(function($child) use ($locale) {
                                $titleRaw = $child->getRawOriginal('title');
                                $title = is_array(json_decode($titleRaw, true))
                                    ? $child->getTranslation('title', $locale)
                                    : ($titleRaw ?? '');
                                return mb_strtolower($title);
                            })->values() as $child)
                                @php
                                    $childTitle = $child->getTranslation('title', $locale);
                                    $childLink = $child->getTranslation('link', $locale);
                                    $childImage = $child->getFirstMedia('header_menu_item_image');
                                    $hasGrandChildren = $child->children && $child->children->isNotEmpty();

                                    $childProductsCount = 0;
                                    if ($child->category_id) {
                                        $childCategory = \App\Models\Category::where('onec_id', $child->category_id)->first();
                                        if ($childCategory) {
                                            $childProductsCount = $childCategory->products()
                                                ->where('status', true)
                                                ->where('site_status', true)
                                                ->where('stock', '!=', 0)
                                                ->count();
                                        }
                                    }
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

