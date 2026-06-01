@php
    $locale = app()->getLocale();
    $panelTitle = $item->getTranslation('title', $locale);
    $panelLink = $item->getTranslation('link', $locale);
    $panelOnecId = $item->category_id;
@endphp
@if($panelOnecId)
    {{-- §7 — parent category title + grouped catalog download for the
         currently opened "Catalog produse" panel. The grouped export
         (radop_categories_grouped_{onec}) is produced for every category with
         children and served via theme.category.export. --}}
    <div class="mega-menu__panel-header">
        <a href="{{ $panelLink ?? '#' }}" class="mega-menu__panel-title">{{ $panelTitle }}</a>
        <a href="{{ route('theme.category.export', $panelOnecId) }}" class="export-excel-link mega-menu__export-link" title="{{ __('theme.download-catalog') }}">
            <span>{{ __('theme.download-catalog') }}</span>
            @include('frontend.v1.pages.shop.parts.excel-svg')
        </a>
    </div>
@endif
@if($item->children && $item->children->where('type', '!=', 'widget_link')->isNotEmpty())
    @php
        $allChildren = $item->children->where('type', '!=', 'widget_link')->values();
        $groups = collect();
        $currentGroup = collect();
        $currentGroupType = null;

        foreach ($allChildren as $child) {
            if ($child->type === 'row') {
                if ($currentGroup->isNotEmpty() && $currentGroupType !== 'row') {
                    $groups->push(['type' => 'regular', 'items' => $currentGroup]);
                    $currentGroup = collect();
                }
                $currentGroup->push($child);
                $currentGroupType = 'row';
            } else {
                if ($currentGroupType === 'row') {
                    $groups->push(['type' => 'row', 'items' => $currentGroup]);
                    $currentGroup = collect();
                }
                $currentGroup->push($child);
                $currentGroupType = 'regular';
            }
        }

        if ($currentGroup->isNotEmpty()) {
            $groups->push(['type' => $currentGroupType, 'items' => $currentGroup]);
        }
    @endphp
    @foreach($groups as $group)
        @if($group['type'] === 'row')
            <div class="mega-menu__columns_with_row">
                @foreach($group['items'] as $rowChild)
                    @include('partials.menus.mega-menu-category-item', ['item' => $rowChild])
                @endforeach
            </div>
        @else
            @php
                $regularItems = $group['items'];
                $columnCount = 3;
                $columns = collect();
                for ($i = 1; $i <= $columnCount; $i++) {
                    $columns[$i] = $regularItems->filter(function($item) use ($i) {
                        return ($item->column ?? 1) == $i;
                    })->sortBy(function($item) {
                        return $item->column_order ?? $item->order ?? 0;
                    })->values();
                }
            @endphp
            <div class="mega-menu__columns" style="display: grid; grid-template-columns: repeat({{ $columnCount }}, 1fr); gap: 40px;">
                @foreach($columns as $columnNum => $columnItems)
                    <div class="mega-menu__column">
                        @foreach($columnItems as $child)
                            @include('partials.menus.mega-menu-category-item', ['item' => $child])
                        @endforeach
                    </div>
                @endforeach
            </div>
        @endif
    @endforeach
@else
    <div class="mega-menu__empty">
        <p>{{ __('theme.no-subcategories') }}</p>
    </div>
@endif
