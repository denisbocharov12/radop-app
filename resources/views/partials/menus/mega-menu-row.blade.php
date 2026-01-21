@php
    $locale = app()->getLocale();
    $rowTitle = $row->getTranslation('title', $locale);
    $rowChildren = $row->children ? $row->children->where('type', '!=', 'widget_link')->where('type', '!=', 'row')->values() : collect();
@endphp

<div class="mega-menu__row">
    @if($rowTitle)
        <h3 class="mega-menu__row-title">{{ $rowTitle }}</h3>
    @endif
    @if($rowChildren->isNotEmpty())
        <div class="mega-menu__columns">
            @php
                $rowColumns = $rowChildren->chunk(ceil($rowChildren->count() / 3));
            @endphp
            @foreach($rowColumns as $column)
                <div class="mega-menu__column">
                    @foreach($column as $child)
                        @include('partials.menus.mega-menu-category-item', ['item' => $child])
                    @endforeach
                </div>
            @endforeach
        </div>
    @endif
</div>
