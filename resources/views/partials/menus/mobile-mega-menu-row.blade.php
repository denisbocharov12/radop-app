@php
    $locale = app()->getLocale();
    $rowTitle = $row->getTranslation('title', $locale);
    $rowRegularChildren = $row->children ? $row->children->where('type', '!=', 'widget_link')->where('type', '!=', 'row')->values() : collect();
@endphp

@if($rowRegularChildren->isNotEmpty())
    <li class="drop-menu-list__item">
        @if($rowTitle)
            <div class="drop-menu-list__row-title">{{ $rowTitle }}</div>
        @endif
        <ul class="column-catalog__list drop-menu-list">
            @foreach($rowRegularChildren as $rowChild)
                @php
                    $rowChildTitle = $rowChild->getTranslation('title', $locale);
                    $rowChildLink = $rowChild->getTranslation('link', $locale);
                    $rowChildProductsCount = $rowChild->products_count ?? 0;
                @endphp
                <li class="drop-menu-list__item">
                    <a href="{{ $rowChildLink ?? '#' }}" class="drop-menu-list__link">
                        {{ $rowChildTitle }}
                        @if($rowChildProductsCount > 0)
                            <span class="mega-menu__category-count--mobile">{{ $rowChildProductsCount }}</span>
                        @endif
                    </a>
                </li>
            @endforeach
        </ul>
    </li>
@endif
