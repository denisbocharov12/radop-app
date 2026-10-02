@extends('frontend.v1.layouts.layout')

@section('sf-page', 1)

@section('content')
    @php
        /*
         * Landing page for a category that has sub-categories. Previously three
         * fixed Bootstrap columns fed by the CMS `column` field, which left
         * ragged gaps; now a card per sub-category in a responsive grid, still
         * in the CMS order (column first, then position).
         */
        $user = auth()->guard('user')->user();
        $personalized = $user && $user->sale;

        $children = ($existedCategory->childrenOrderedByColumn ?? $existedCategory->children)
            ->sortBy(static fn ($c) => [(int) ($c->column ?? 1), (int) ($c->column_order ?? $c->order ?? 0)])
            ->values();

        $trail = collect($breadcrumbs ?? []);
        $title = (string) data_get($trail->last(), 'name', $existedCategory->name ?? '');

        $exportUrl = $personalized
            ? route('theme.category.export.personalized', $existedCategory->onec_id)
            : route('theme.category.export', $existedCategory->onec_id);
    @endphp

    <x-sf-breadcrumbs :items="$trail" />
    @include('frontend.v1.components.breadcrumb-schema', ['items' => $breadcrumbs])

    <div class="sf-container">
        <div class="mb-6 mt-2 flex flex-wrap items-end justify-between gap-3">
            <div>
                <h1 class="text-2xl font-bold text-ink-900 lg:text-3xl">{{ $title }}</h1>
                <p class="mt-1 text-sm text-ink-500">{{ __('theme.sf-subcategories') }}: {{ $children->count() }}</p>
            </div>
            <x-sf-export-button :url="$exportUrl" :personalized="$personalized" />
        </div>

        <ul class="grid gap-3 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @foreach($children as $category)
                @php
                    $grandchildren = $category->childrenOrderedByColumn ?? $category->children;
                    $icon = $category->getFirstMediaUrl('media');
                @endphp
                <li class="sf-card flex flex-col p-4 transition-shadow hover:shadow-card-hover">
                    <div class="flex items-start gap-3">
                        <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-lg bg-brand-50">
                            @if($icon)
                                <img src="{{ $icon }}" alt="" class="h-6 w-6 object-contain" loading="lazy" />
                            @else
                                <x-sf-icon name="grid" :size="20" class="text-brand-600" />
                            @endif
                        </span>
                        <a
                            href="{{ route('theme.category.index', $category->onec_id) }}"
                            class="min-w-0 flex-1 pt-0.5 text-md font-semibold leading-snug text-ink-900 hover:text-brand-600"
                        >{{ $category->name }}</a>
                        <x-sf-export-button
                            :url="$personalized ? route('theme.category.export.personalized', $category->onec_id) : route('theme.category.export', $category->onec_id)"
                            :personalized="$personalized"
                            compact
                        />
                    </div>

                    @if($grandchildren->isNotEmpty())
                        <ul class="mt-3 space-y-0.5 border-t border-ink-100 pt-3">
                            @foreach($grandchildren->take(8) as $leaf)
                                <li>
                                    <a href="{{ route('theme.category.index', $leaf->onec_id) }}" class="sf-mega-leaf">{{ $leaf->name }}</a>
                                </li>
                            @endforeach
                        </ul>
                        @if($grandchildren->count() > 8)
                            <a href="{{ route('theme.category.index', $category->onec_id) }}" class="sf-section-link mt-2 inline-flex items-center gap-1">
                                {{ __('theme.view-all') }} ({{ $grandchildren->count() }})
                                <x-sf-icon name="arrowRight" :size="14" />
                            </a>
                        @endif
                    @endif
                </li>
            @endforeach
        </ul>
    </div>

    <x-sf-brand-rail :brands="$themeBrands ?? []" class="pt-2" />
@endsection
