@php
    /*
     * The brand-blue category strip under the header (present on radop.md).
     *
     * Source of truth is the CMS `header_menu`; when it is absent or empty the
     * top-level categories stand in, which is the same fallback the old
     * `header.blade.php` used. Both shapes are normalised to one array here so
     * the markup below does not have to branch.
     */
    $locale = app()->getLocale();
    $navItems = [];

    $cmsMenu = app(\App\Services\HeaderMenuRenderService::class)->getHeaderMenuData('header_menu');

    if ($cmsMenu && $cmsMenu->is_active && $cmsMenu->rootItems->isNotEmpty()) {
        $navItems = $cmsMenu->rootItems->map(fn ($item) => [
            'title' => $item->getTranslation('title', $locale),
            'url' => $item->getTranslation('link', $locale) ?: '#',
            'target' => $item->target ?? '_self',
            'children' => collect($item->children ?? [])->map(fn ($child) => [
                'title' => $child->getTranslation('title', $locale),
                'url' => $child->getTranslation('link', $locale) ?: '#',
            ])->all(),
        ])->all();
    } elseif (! empty($themeParentCategories)) {
        $navItems = $themeParentCategories->sortBy('catalog_order')->map(fn ($category) => [
            'title' => $category->name,
            'url' => route('theme.category.index', $category->onec_id),
            'target' => '_self',
            'children' => collect($category->children ?? [])->map(fn ($child) => [
                'title' => $child->name,
                'url' => route('theme.category.index', $child->onec_id),
            ])->all(),
        ])->all();
    }
@endphp

@if(! empty($navItems))
    <nav class="sf-nav" aria-label="{{ __('theme.navigation-menu') }}">
        <div class="sf-container relative">
            <ul class="flex items-stretch">
                @foreach($navItems as $item)
                    <li class="group/nav relative" data-sf-nav-item>
                        <a
                            href="{{ $item['url'] }}"
                            target="{{ $item['target'] }}"
                            class="sf-nav-link"
                        >
                            {{ $item['title'] }}
                            @if(! empty($item['children']))
                                <x-sf-icon name="chevronDown" :size="13" class="opacity-70" />
                            @endif
                        </a>

                        @if(! empty($item['children']))
                            <div class="sf-nav-panel">
                                <p class="mb-3 text-md font-bold text-ink-900">
                                    <a href="{{ $item['url'] }}" class="hover:text-brand-600">{{ $item['title'] }}</a>
                                </p>
                                <ul class="columns-2 gap-8">
                                    @foreach($item['children'] as $child)
                                        <li class="mb-1 break-inside-avoid">
                                            <a href="{{ $child['url'] }}" class="sf-mega-leaf">{{ $child['title'] }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </nav>
@endif
