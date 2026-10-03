@extends('v2.layouts.app')

@php($isNew = ! $section->exists)

@section('title', $isNew ? 'Новая секция главной' : 'Секция главной')
@section('breadcrumb')
    <a href="{{ route('home-section.index') }}" class="hover:text-gray-700">Секции главной</a>
    <span class="text-gray-400">/</span>
    <span class="text-gray-700">{{ $isNew ? 'Новая' : 'Правка' }}</span>
@endsection

@section('content')
    <x-page-header
        :title="$isNew ? 'Новая секция' : 'Секция главной'"
        description="Заголовки переводимые: пустой перевод подменяется румынским"
    />

    @if($errors->any())
        <x-alert type="error" class="mb-4">
            <ul class="list-disc list-inside space-y-0.5">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </x-alert>
    @endif

    <form
        method="POST"
        action="{{ $isNew ? route('home-section.store') : route('home-section.update', $section) }}"
        enctype="multipart/form-data"
        x-data="{ type: @js(old('type', $section->type)), source: @js(old('source', $section->setting('source', 'new'))) }"
        class="space-y-4"
    >
        @csrf

        <div class="card p-4 space-y-4">
            <div class="grid gap-4 md:grid-cols-2">
                <label class="block">
                    <span class="label">Тип секции</span>
                    <select name="type" x-model="type" class="input">
                        @foreach($types as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </label>

                <label class="block">
                    <span class="label">Порядок</span>
                    <input type="number" name="order" min="0" max="10000" value="{{ old('order', $section->order ?: 100) }}" class="input">
                </label>

                <label class="block">
                    <span class="label">Заголовок (ro)</span>
                    <input type="text" name="title_ro" value="{{ old('title_ro', $section->getTranslation('title', 'ro', false)) }}" class="input">
                </label>

                <label class="block">
                    <span class="label">Заголовок (ru)</span>
                    <input type="text" name="title_ru" value="{{ old('title_ru', $section->getTranslation('title', 'ru', false)) }}" class="input">
                </label>

                <label class="block">
                    <span class="label">Подпись (ro)</span>
                    <input type="text" name="subtitle_ro" value="{{ old('subtitle_ro', $section->getTranslation('subtitle', 'ro', false)) }}" class="input">
                </label>

                <label class="block">
                    <span class="label">Подпись (ru)</span>
                    <input type="text" name="subtitle_ru" value="{{ old('subtitle_ru', $section->getTranslation('subtitle', 'ru', false)) }}" class="input">
                </label>

                <label class="block">
                    <span class="label">Ссылка «Смотреть все»</span>
                    <input type="text" name="link" value="{{ old('link', $section->link) }}" placeholder="/shop/new" class="input">
                </label>

                <label class="block">
                    <span class="label">Текст ссылки (ru)</span>
                    <input type="text" name="link_title_ru" value="{{ old('link_title_ru', $section->getTranslation('link_title', 'ru', false)) }}" class="input">
                </label>
            </div>

            <label class="inline-flex items-center gap-2">
                <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $section->is_active ?? true)) class="checkbox">
                <span>Показывать на сайте</span>
            </label>
        </div>

        {{-- Товары: у лент и у сезонной секции --}}
        <div class="card p-4 space-y-4" x-show="type === 'product_rail' || type === 'seasonal'" x-cloak>
            <h3 class="font-semibold text-gray-800">Товары</h3>

            <div class="grid gap-4 md:grid-cols-2">
                <label class="block">
                    <span class="label">Откуда брать</span>
                    <select name="source" x-model="source" class="input">
                        @foreach($sources as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </label>

                <label class="block">
                    <span class="label">Сколько показывать</span>
                    <input type="number" name="limit" min="1" max="40" value="{{ old('limit', $section->setting('limit', 12)) }}" class="input">
                </label>
            </div>

            <label class="block" x-show="source === 'manual'" x-cloak>
                <span class="label">Коды товаров 1С</span>
                <textarea name="product_codes" rows="4" class="input" placeholder="50000029, 13050124">{{ old('product_codes', implode(', ', (array) $section->setting('product_ids', []))) }}</textarea>
                <span class="hint">Через запятую или с новой строки. Порядок сохраняется.</span>
            </label>
        </div>

        {{-- Оформление сезонной секции --}}
        <div class="card p-4 space-y-4" x-show="type === 'seasonal'" x-cloak>
            <h3 class="font-semibold text-gray-800">Фон и заголовок</h3>

            @if($section->backgroundUrl())
                <div class="flex items-center gap-3">
                    <img src="{{ $section->backgroundUrl() }}" alt="" class="h-20 w-36 rounded object-cover border border-gray-200">
                    <label class="inline-flex items-center gap-2 text-sm">
                        <input type="checkbox" name="remove_background" value="1" class="checkbox">
                        <span>Удалить фон</span>
                    </label>
                </div>
            @endif

            <label class="block">
                <span class="label">Фоновое фото</span>
                <input type="file" name="background" accept="image/jpeg,image/png,image/webp" class="input">
                <span class="hint">Снимок растягивается на всю ширину секции. До 4 МБ.</span>
            </label>

            <div class="grid gap-4 md:grid-cols-3">
                <label class="block">
                    <span class="label">Цвет маски</span>
                    <input type="color" name="overlay_color" value="{{ old('overlay_color', $section->setting('overlay_color', '#0b2a4a')) }}" class="input h-10 p-1">
                </label>

                <label class="block">
                    <span class="label">Прозрачность маски, %</span>
                    <input type="number" name="overlay_opacity" min="0" max="100" value="{{ old('overlay_opacity', $section->setting('overlay_opacity', 55)) }}" class="input">
                    <span class="hint">0 — фото как есть, 100 — сплошной цвет.</span>
                </label>

                <label class="block">
                    <span class="label">Заголовок</span>
                    <select name="heading_style" class="input">
                        <option value="light" @selected(old('heading_style', $section->setting('heading_style', 'light')) === 'light')>Светлый (на тёмном фоне)</option>
                        <option value="dark" @selected(old('heading_style', $section->setting('heading_style', 'light')) === 'dark')>Тёмный (на светлом фоне)</option>
                    </select>
                </label>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <button type="submit" class="btn-primary">Сохранить</button>
            <a href="{{ route('home-section.index') }}" class="btn-ghost">Отмена</a>
        </div>
    </form>
@endsection
