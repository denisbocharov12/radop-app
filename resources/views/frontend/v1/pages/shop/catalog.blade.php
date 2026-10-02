@extends('frontend.v1.layouts.layout')

@section('sf-page', 1)

@section('content')
    <x-sf-breadcrumbs :with-shop="false" :items="[['url' => null, 'name' => __('theme.shop')]]" />

    <section class="sf-container">
        <h1 class="mb-6 mt-2 text-2xl font-bold text-ink-900 lg:text-3xl">{{ __('theme.show-all-categories') }}</h1>

        {{--
            A masonry-free three-column layout: `columns` lets each root category
            block flow naturally instead of the fixed 3-column grid the old
            markup used, which left large gaps when branches differed in length.
        --}}
        <div class="columns-1 gap-8 sm:columns-2 lg:columns-3">
            @foreach(($themeParentCategories ?? collect())->sortBy('catalog_order') as $parentCategory)
                <div class="mb-7 break-inside-avoid">
                    <a
                        href="{{ route('theme.category.index', $parentCategory->onec_id) }}"
                        class="mb-2 flex items-center gap-2 text-md font-bold text-ink-900 hover:text-brand-600"
                    >
                        {{ $parentCategory->name }}
                        <x-sf-icon name="chevronRight" :size="14" class="text-ink-300" />
                    </a>

                    @if($parentCategory->children->isNotEmpty())
                        <ul class="space-y-1">
                            @foreach($parentCategory->children as $child)
                                <li>
                                    <a href="{{ route('theme.category.index', $child->onec_id) }}" class="sf-mega-leaf">
                                        {{ $child->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            @endforeach
        </div>
    </section>
@endsection
