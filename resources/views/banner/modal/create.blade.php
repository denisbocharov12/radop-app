<x-modal name="banner-create" title="Добавить баннер" maxWidth="max-w-xl">
    <form action="{{ route('banner.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
                <label class="form-label" for="bn_order">Порядок <span class="text-red-500">*</span></label>
                <input type="number" name="order" id="bn_order" value="{{ old('order', 1) }}" min="1" class="form-input @error('order') border-red-400 @enderror">
                @error('order')<p class="form-error">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="form-label" for="bn_active">Статус <span class="text-red-500">*</span></label>
                <select required name="active" id="bn_active" class="form-select js-select2">
                    <option value="1">Активный</option>
                    <option value="0">Неактивный</option>
                </select>
            </div>
            <div>
                <label class="form-label" for="bn_link_ru">Ссылка (RU)</label>
                <input type="text" name="link_ru" id="bn_link_ru" value="{{ old('link_ru') }}" class="form-input @error('link_ru') border-red-400 @enderror" placeholder="/ru/catalog/...">
                @error('link_ru')<p class="form-error">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="form-label" for="bn_link_ro">Ссылка (RO)</label>
                <input type="text" name="link_ro" id="bn_link_ro" value="{{ old('link_ro') }}" class="form-input @error('link_ro') border-red-400 @enderror" placeholder="/ro/catalog/...">
                @error('link_ro')<p class="form-error">{{ $message }}</p>@enderror
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="form-label" for="bannerImageRu">Изображение RU (JPEG) <span class="text-red-500">*</span></label>
                <input type="file" name="image_ru" id="bannerImageRu" accept="image/jpeg" required
                       class="block w-full text-sm text-gray-600 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100">
                @error('image_ru')<p class="form-error">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="form-label" for="bannerImageRo">Изображение RO (JPEG) <span class="text-red-500">*</span></label>
                <input type="file" name="image_ro" id="bannerImageRo" accept="image/jpeg" required
                       class="block w-full text-sm text-gray-600 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100">
                @error('image_ro')<p class="form-error">{{ $message }}</p>@enderror
            </div>
        </div>
        <div class="flex justify-end gap-2 pt-2">
            <button type="button" class="btn-secondary" @click="$dispatch('close-modal', 'banner-create')">Отмена</button>
            <button type="submit" class="btn-primary"><i data-lucide="check" class="w-4 h-4"></i> Сохранить баннер</button>
        </div>
    </form>
</x-modal>
