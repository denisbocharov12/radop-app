@extends('v2.layouts.app')

@section('title', 'Редактирование баннера')
@section('breadcrumb')
    <a href="{{ route('banner.index') }}" class="hover:text-brand-600 transition-colors">Баннеры</a>
    <i data-lucide="chevron-right" class="w-3.5 h-3.5 mx-2 text-gray-300"></i>
    <span class="text-gray-700">#{{ $banner->id }}</span>
@endsection

@section('content')
    <x-page-header title="Редактирование баннера" description="#{{ $banner->id }}">
        <x-slot:actions>
            <a href="{{ route('banner.index') }}" class="btn-secondary btn-sm"><i data-lucide="arrow-left" class="w-4 h-4"></i> К списку</a>
        </x-slot:actions>
    </x-page-header>

    @if($errors->any())
        <x-alert type="error" class="mb-4">
            <ul class="list-disc list-inside space-y-0.5">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </x-alert>
    @endif

    <x-card>
        <form action="{{ route('banner.update', $banner) }}" enctype="multipart/form-data" method="POST" class="space-y-5">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="form-label" for="order">Порядок отображения <span class="text-red-500">*</span></label>
                    <input type="number" required name="order" id="order" value="{{ $banner->order }}" class="form-input @error('order') border-red-400 @enderror">
                    @error('order')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="form-label" for="active">Статус <span class="text-red-500">*</span></label>
                    <select required name="active" id="active" class="form-select js-select2">
                        <option value="1" {{ $banner->active ? 'selected' : '' }}>Активный</option>
                        <option value="0" {{ !$banner->active ? 'selected' : '' }}>Неактивный</option>
                    </select>
                </div>
                <div>
                    <label class="form-label" for="link">Ссылка</label>
                    <input type="text" name="link" id="link" value="{{ $banner->link }}" class="form-input">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pt-2 border-t border-gray-100">
                <div>
                    <label class="form-label">Изображение RU</label>
                    @if($banner->image_path_ru)
                        <img src="{{ asset('storage/' . $banner->image_path_ru) }}" alt="RU" class="mb-2 h-32 w-auto rounded-lg border border-gray-200 object-cover">
                    @else
                        <p class="text-sm text-gray-400 mb-2">Нет изображения</p>
                    @endif
                    <input type="file" name="image_ru" accept="image/jpeg"
                           class="block w-full text-sm text-gray-600 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100">
                </div>
                <div>
                    <label class="form-label">Изображение RO</label>
                    @if($banner->image_path_ro)
                        <img src="{{ asset('storage/' . $banner->image_path_ro) }}" alt="RO" class="mb-2 h-32 w-auto rounded-lg border border-gray-200 object-cover">
                    @else
                        <p class="text-sm text-gray-400 mb-2">Нет изображения</p>
                    @endif
                    <input type="file" name="image_ro" accept="image/jpeg"
                           class="block w-full text-sm text-gray-600 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100">
                </div>
            </div>

            <div class="flex justify-end pt-2 border-t border-gray-100">
                <button type="submit" class="btn-primary"><i data-lucide="check" class="w-4 h-4"></i> Обновить баннер</button>
            </div>
        </form>
    </x-card>
@endsection
