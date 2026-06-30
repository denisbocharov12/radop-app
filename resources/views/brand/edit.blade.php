@extends('v2.layouts.app')

@section('title', 'Редактирование бренда')
@section('breadcrumb')
    <a href="{{ route('brand.index') }}" class="hover:text-brand-600 transition-colors">Бренды</a>
    <i data-lucide="chevron-right" class="w-3.5 h-3.5 mx-2 text-gray-300"></i>
    <span class="text-gray-700">Редактирование</span>
@endsection

@section('content')
    <x-page-header title="Редактирование бренда" description="{{ $brand->title }}">
        <x-slot:actions>
            <a href="{{ route('brand.index') }}" class="btn-secondary btn-sm"><i data-lucide="arrow-left" class="w-4 h-4"></i> К списку</a>
        </x-slot:actions>
    </x-page-header>

    @if($errors->any())
        <x-alert type="error" class="mb-4">
            <ul class="list-disc list-inside space-y-0.5">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </x-alert>
    @endif

    <x-card>
        <form action="{{ route('brand.update', $brand) }}" enctype="multipart/form-data" method="POST" class="space-y-5">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="form-label" for="title">Название бренда <span class="text-red-500">*</span></label>
                    <input type="text" required name="title" id="title" value="{{ $brand->title }}" class="form-input @error('title') border-red-400 @enderror">
                    @error('title')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="form-label" for="status">Статус <span class="text-red-500">*</span></label>
                    <select required name="status" id="status" class="form-select js-select2">
                        <option value="true" {{ $brand->status ? 'selected' : '' }}>Активный</option>
                        <option value="false" {{ !$brand->status ? 'selected' : '' }}>Неактивный</option>
                    </select>
                </div>
            </div>
            <div>
                <label class="form-label" for="description">Описание бренда</label>
                <textarea name="description" id="description" rows="3" class="form-input resize-none @error('description') border-red-400 @enderror">{{ $brand->description }}</textarea>
                @error('description')<p class="form-error">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="form-label" for="brandAttachments">Добавить фотографии</label>
                <input type="file" name="attachments[]" id="brandAttachments" multiple
                       class="block w-full text-sm text-gray-600 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100">
            </div>
            <div class="flex justify-end pt-2 border-t border-gray-100">
                <button type="submit" class="btn-primary"><i data-lucide="check" class="w-4 h-4"></i> Обновить бренд</button>
            </div>
        </form>
    </x-card>

    @if($brand->getMedia('media')->count())
        <x-card title="Изображения бренда" class="mt-6">
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach($brand->getMedia('media') as $image)
                    <div data-media class="relative rounded-lg border border-gray-200 overflow-hidden">
                        <a href="{{ $image->getUrl() }}" target="_blank"><img src="{{ $image->getUrl() }}" alt="" class="w-full h-32 object-cover"></a>
                        <div class="flex items-center justify-between px-2 py-1.5 text-xs text-gray-500">
                            <span class="truncate">#{{ $image->id }}</span>
                            <button type="button" class="text-red-500 hover:text-red-700"
                                    @click="if (confirm('Удалить изображение?')) { window.axios.post('{{ route('brand.media.delete', $brand) }}', { id: {{ $image->id }} }).then(() => { $el.closest('[data-media]').remove(); window.Alpine.store('toast').add('Изображение удалено','success'); }).catch(() => window.Alpine.store('toast').add('Ошибка удаления','error')); }">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </x-card>
    @endif
@endsection
