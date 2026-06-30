@extends('v2.layouts.app')

@section('content')
    <x-page-header title="Добавить SEO-запись" description="Создание новой SEO записи для страницы">
        <x-slot:actions>
            <a href="{{ route('seo_meta.index') }}" class="btn-secondary">
                <i data-lucide="arrow-left" class="h-4 w-4"></i>
                <span>Назад</span>
            </a>
        </x-slot:actions>
    </x-page-header>

    @if ($errors->any())
        <x-alert type="error" class="mb-5">
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </x-alert>
    @endif

    <x-card>
        <form action="{{ route('seo_meta.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <div>
                <label for="page_type" class="mb-1 block text-sm font-medium text-gray-700">Тип страницы</label>
                <select id="page_type" name="page_type" required
                        class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 focus:outline-none @error('page_type') border-red-400 @enderror">
                    <option value="">Выберите тип страницы</option>
                    @foreach($pageTypes as $value => $label)
                        <option value="{{ $value }}" {{ old('page_type') == $value ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @error('page_type')<span class="mt-1 block text-xs text-red-600">{{ $message }}</span>@enderror
            </div>

            <div id="page_id_container" style="display: none;">
                <label for="page_id" class="mb-1 block text-sm font-medium text-gray-700">ID страницы</label>
                <input type="text" id="page_id" name="page_id" value="{{ old('page_id') }}" placeholder="Введите ID страницы"
                       class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 focus:outline-none @error('page_id') border-red-400 @enderror">
                @error('page_id')<span class="mt-1 block text-xs text-red-600">{{ $message }}</span>@enderror
            </div>

            <div>
                <label for="locale" class="mb-1 block text-sm font-medium text-gray-700">Язык</label>
                <select id="locale" name="locale" required
                        class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 focus:outline-none @error('locale') border-red-400 @enderror">
                    <option value="">Выберите язык</option>
                    <option value="ru" {{ old('locale') == 'ru' ? 'selected' : '' }}>Русский</option>
                    <option value="ro" {{ old('locale') == 'ro' ? 'selected' : '' }}>Română</option>
                </select>
                @error('locale')<span class="mt-1 block text-xs text-red-600">{{ $message }}</span>@enderror
            </div>

            <div>
                <label for="title" class="mb-1 block text-sm font-medium text-gray-700">Заголовок страницы</label>
                <input type="text" id="title" name="title" value="{{ old('title') }}"
                       class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 focus:outline-none @error('title') border-red-400 @enderror">
                @error('title')<span class="mt-1 block text-xs text-red-600">{{ $message }}</span>@enderror
            </div>

            <div>
                <label for="description" class="mb-1 block text-sm font-medium text-gray-700">Описание страницы</label>
                <textarea id="description" name="description" rows="4"
                          class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 focus:outline-none @error('description') border-red-400 @enderror">{{ old('description') }}</textarea>
                @error('description')<span class="mt-1 block text-xs text-red-600">{{ $message }}</span>@enderror
            </div>

            <div>
                <label for="keywords" class="mb-1 block text-sm font-medium text-gray-700">Ключевые слова (без пробелов через запятую до 5 ед.)</label>
                <input type="text" id="keywords" name="keywords" value="{{ old('keywords') }}"
                       class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 focus:outline-none @error('keywords') border-red-400 @enderror">
                @error('keywords')<span class="mt-1 block text-xs text-red-600">{{ $message }}</span>@enderror
            </div>

            <div>
                <label for="canonical" class="mb-1 block text-sm font-medium text-gray-700">Каноническая ссылка</label>
                <input type="text" id="canonical" name="canonical" value="{{ old('canonical') }}"
                       class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 focus:outline-none @error('canonical') border-red-400 @enderror">
                @error('canonical')<span class="mt-1 block text-xs text-red-600">{{ $message }}</span>@enderror
            </div>

            <div>
                <label for="robots" class="mb-1 block text-sm font-medium text-gray-700">Инструкции для роботов</label>
                <input type="text" id="robots" name="robots" value="{{ old('robots') }}"
                       class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 focus:outline-none @error('robots') border-red-400 @enderror">
                @error('robots')<span class="mt-1 block text-xs text-red-600">{{ $message }}</span>@enderror
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-gray-700">Изображениe (Рекомендуемый размер: 1200x630)</label>
                <input type="file" name="attachments[]" multiple id="seoMetaAttachments"
                       class="block w-full text-sm text-gray-600 file:mr-4 file:rounded-lg file:border-0 file:bg-brand-50 file:px-4 file:py-2 file:text-sm file:font-medium file:text-brand-700 hover:file:bg-brand-100">
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="btn-primary">
                    <i data-lucide="save" class="h-4 w-4"></i>
                    <span>Сохранить</span>
                </button>
                <a href="{{ route('seo_meta.index') }}" class="btn-secondary">
                    <i data-lucide="arrow-left" class="h-4 w-4"></i>
                    <span>Назад</span>
                </a>
            </div>
        </form>
    </x-card>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const pageTypeSelect = document.getElementById('page_type');
    const pageIdContainer = document.getElementById('page_id_container');
    const pageIdInput = document.getElementById('page_id');

    const staticPages = @json(array_keys($staticPages));
    const dynamicPages = @json(array_keys($dynamicPages));

    function togglePageIdField() {
        const selectedValue = pageTypeSelect.value;

        if (dynamicPages.includes(selectedValue)) {
            pageIdContainer.style.display = 'block';
            pageIdInput.required = true;
            pageIdInput.placeholder = 'Введите ID страницы';
        } else {
            pageIdContainer.style.display = 'none';
            pageIdInput.required = false;
            pageIdInput.value = '';
        }
    }

    pageTypeSelect.addEventListener('change', togglePageIdField);
    togglePageIdField();
});
</script>
@endsection
