@php
    $hasChildren = isset($category->children) && $category->children->isNotEmpty();
    $paddingLeft = $level * 20;
@endphp

<div class="category-item" style="margin-bottom: 8px; padding-left: {{ $paddingLeft }}px;">
    <a href="javascript:void(0);" 
       class="category-filter-link" 
       data-category-id="{{ $category->onec_id }}"
       data-page-type="{{ $pageType }}"
       data-page-sub-type="{{ $pageSubType ?? '' }}"
       data-brand-onec-id="{{ $brandOnecId ?? '' }}"
       style="display: flex; justify-content: space-between; align-items: center; text-decoration: none; color: inherit; padding: 4px 0;">
        <span>{{ $category->name }}</span>
        <span style="color: #999; font-size: 14px;">({{ $category->products_count ?? 0 }})</span>
    </a>
    @if($hasChildren)
        <div class="category-children" style="margin-top: 4px;">
            @foreach($category->children as $child)
                @include('frontend.v1.components.categories-filter-item', [
                    'category' => $child,
                    'level' => $level + 1,
                    'pageType' => $pageType,
                    'pageSubType' => $pageSubType ?? null,
                    'brandOnecId' => $brandOnecId ?? null
                ])
            @endforeach
        </div>
    @endif
</div>

