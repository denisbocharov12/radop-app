@extends('v2.layouts.app')

@section('title', 'Сортировка секций главной')
@section('breadcrumb')
    <a href="{{ route('home-section.index') }}" class="hover:text-brand-600 transition-colors">Секции главной</a>
    <i data-lucide="chevron-right" class="w-3.5 h-3.5 mx-2 text-gray-300"></i>
    <span class="text-gray-700">Сортировка</span>
@endsection

@section('content')
    @php
        $sortItems = collect($sections)->map(fn ($section) => [
            'id' => $section->id,
            'label' => ($section->getTranslation('title', 'ru', false)
                ?: $section->getTranslation('title', 'ro', false)
                ?: ($types[$section->type] ?? $section->type)) . ' — ' . ($types[$section->type] ?? $section->type),
        ]);
    @endphp

    <x-sortable-list
        :items="$sortItems"
        title="Сортировка секций главной"
        description="Перетащите строки за рукоятку. Порядок сохраняется по кнопке «Сохранить»."
        :backUrl="route('home-section.index')"
        :showImage="false"
        :showCode="false"
    />
@endsection

@section('scripts')
    @include('v2.partials.sortable-script', ['orderUrl' => route('home-section.sort.order')])
@endsection
