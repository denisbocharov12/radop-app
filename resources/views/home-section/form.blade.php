@extends('v2.layouts.app')

@php($isNew = ! $section->exists)

@section('title', $isNew ? 'Новая секция главной' : 'Редактирование секции')
@section('breadcrumb')
    <a href="{{ route('home-section.index') }}" class="hover:text-brand-600 transition-colors">Секции главной</a>
    <i data-lucide="chevron-right" class="w-3.5 h-3.5 mx-2 text-gray-300"></i>
    <span class="text-gray-700">{{ $isNew ? 'Новая' : '#' . $section->id }}</span>
@endsection

@section('content')
    <x-page-header
        :title="$isNew ? 'Новая секция главной' : 'Редактирование секции'"
        description="Заголовки переводимые: пустой перевод подменяется румынским"
    >
        <x-slot:actions>
            <a href="{{ route('home-section.index') }}" class="btn-secondary btn-sm">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> К списку
            </a>
        </x-slot:actions>
    </x-page-header>

    @if($errors->any())
        <x-alert type="error" class="mb-4">
            <ul class="list-disc list-inside space-y-0.5">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </x-alert>
    @endif

    <form
        action="{{ $isNew ? route('home-section.store') : route('home-section.update', $section) }}"
        method="POST"
        enctype="multipart/form-data"
        x-data="{
            type: @js(old('type', $section->type ?: 'product_rail')),
            source: @js(old('source', $section->setting('source', 'new')))
        }"
        class="space-y-5"
    >
        @csrf

        <x-card>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="form-label" for="type">Тип секции <span class="text-red-500">*</span></label>
                    <select required name="type" id="type" x-model="type" class="form-select @error('type') border-red-400 @enderror">
                        @foreach($types as $value => $label)
                            <option value="{{ $value }}" @selected(old('type', $section->type) === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('type')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="form-label" for="order">Порядок отображения <span class="text-red-500">*</span></label>
                    <input type="number" required name="order" id="order" min="0" max="10000"
                           value="{{ old('order', $section->order ?: 100) }}"
                           class="form-input @error('order') border-red-400 @enderror">
                    @error('order')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="form-label" for="is_active">Статус <span class="text-red-500">*</span></label>
                    <select name="is_active" id="is_active" class="form-select">
                        <option value="1" @selected(old('is_active', $section->is_active ?? true))>Активная</option>
                        <option value="0" @selected(! old('is_active', $section->is_active ?? true))>Скрытая</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-4 mt-4 border-t border-gray-100">
                <div>
                    <label class="form-label" for="title_ro">Заголовок (RO)</label>
                    <input type="text" name="title_ro" id="title_ro" class="form-input"
                           value="{{ old('title_ro', $section->getTranslation('title', 'ro', false)) }}">
                </div>
                <div>
                    <label class="form-label" for="title_ru">Заголовок (RU)</label>
                    <input type="text" name="title_ru" id="title_ru" class="form-input"
                           value="{{ old('title_ru', $section->getTranslation('title', 'ru', false)) }}">
                </div>
                <div>
                    <label class="form-label" for="subtitle_ro">Подпись (RO)</label>
                    <input type="text" name="subtitle_ro" id="subtitle_ro" class="form-input"
                           value="{{ old('subtitle_ro', $section->getTranslation('subtitle', 'ro', false)) }}">
                </div>
                <div>
                    <label class="form-label" for="subtitle_ru">Подпись (RU)</label>
                    <input type="text" name="subtitle_ru" id="subtitle_ru" class="form-input"
                           value="{{ old('subtitle_ru', $section->getTranslation('subtitle', 'ru', false)) }}">
                </div>
                <div>
                    <label class="form-label" for="link">Ссылка «Смотреть все»</label>
                    <input type="text" name="link" id="link" class="form-input" placeholder="/shop/new"
                           value="{{ old('link', $section->link) }}">
                </div>
                <div>
                    <label class="form-label" for="link_title_ru">Текст ссылки (RU)</label>
                    <input type="text" name="link_title_ru" id="link_title_ru" class="form-input"
                           value="{{ old('link_title_ru', $section->getTranslation('link_title', 'ru', false)) }}">
                </div>
            </div>
        </x-card>

        <template x-if="type === 'product_rail' || type === 'seasonal'">
            <x-card>
                <h3 class="text-sm font-semibold text-gray-700 mb-4">Товары секции</h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="form-label" for="source">Откуда брать товары</label>
                        <select name="source" id="source" x-model="source" class="form-select">
                            @foreach($sources as $value => $label)
                                <option value="{{ $value }}" @selected(old('source', $section->setting('source', 'new')) === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                        <p class="form-hint">Если по условию товаров нет, секция не выводится на сайт.</p>
                    </div>

                    <div>
                        <label class="form-label" for="limit">Сколько показывать</label>
                        <input type="number" name="limit" id="limit" min="1" max="40" class="form-input"
                               value="{{ old('limit', $section->setting('limit', 12)) }}">
                    </div>
                </div>

                <div class="mt-4" x-show="source === 'manual'" x-cloak>
                    <label class="form-label" for="product_codes">Коды товаров 1С</label>
                    <textarea name="product_codes" id="product_codes" rows="4" class="form-input"
                              placeholder="50000029, 13050124">{{ old('product_codes', implode(', ', (array) $section->setting('product_ids', []))) }}</textarea>
                    <p class="form-hint">Через запятую или с новой строки. Порядок сохраняется.</p>
                </div>
            </x-card>
        </template>

        <template x-if="type === 'seasonal'">
            <x-card>
                <h3 class="text-sm font-semibold text-gray-700 mb-4">Фон и заголовок</h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="form-label">Фоновое фото</label>
                        @if($section->backgroundUrl())
                            <img src="{{ $section->backgroundUrl() }}" alt="Фон секции"
                                 class="mb-2 h-32 w-auto rounded-lg border border-gray-200 object-cover">
                            <label class="inline-flex items-center gap-2 text-sm text-gray-600 mb-2">
                                <input type="checkbox" name="remove_background" value="1" class="form-checkbox">
                                <span>Удалить фон</span>
                            </label>
                        @else
                            <p class="text-sm text-gray-400 mb-2">Нет изображения</p>
                        @endif
                        <input type="file" name="background" accept="image/jpeg,image/png,image/webp"
                               class="block w-full text-sm text-gray-600 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100">
                        <p class="form-hint">Снимок растягивается на всю ширину секции. До 4 МБ.</p>
                    </div>

                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label class="form-label" for="overlay_color">Цвет маски</label>
                            <input type="color" name="overlay_color" id="overlay_color"
                                   value="{{ old('overlay_color', $section->setting('overlay_color', '#0b2a4a')) }}"
                                   class="form-input h-10 p-1">
                        </div>
                        <div>
                            <label class="form-label" for="overlay_opacity">Прозрачность маски, %</label>
                            <input type="number" name="overlay_opacity" id="overlay_opacity" min="0" max="100"
                                   value="{{ old('overlay_opacity', $section->setting('overlay_opacity', 55)) }}"
                                   class="form-input">
                            <p class="form-hint">0 — фото как есть, 100 — сплошной цвет.</p>
                        </div>
                        <div>
                            <label class="form-label" for="heading_style">Заголовок</label>
                            <select name="heading_style" id="heading_style" class="form-select">
                                <option value="light" @selected(old('heading_style', $section->setting('heading_style', 'light')) === 'light')>Светлый (на тёмном фоне)</option>
                                <option value="dark" @selected(old('heading_style', $section->setting('heading_style', 'light')) === 'dark')>Тёмный (на светлом фоне)</option>
                            </select>
                        </div>
                    </div>
                </div>
            </x-card>
        </template>

        <div class="flex justify-end">
            <button type="submit" class="btn-primary">
                <i data-lucide="check" class="w-4 h-4"></i> {{ $isNew ? 'Создать секцию' : 'Сохранить' }}
            </button>
        </div>
    </form>
@endsection
