<x-modal name="brand-create" title="Добавить бренд" maxWidth="max-w-xl">
    <form action="{{ route('brand.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="form-label" for="b_title">Название бренда <span class="text-red-500">*</span></label>
                <input type="text" required name="title" id="b_title" class="form-input @error('title') border-red-400 @enderror" placeholder="Бренд">
                @error('title')<p class="form-error">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="form-label" for="b_status">Статус <span class="text-red-500">*</span></label>
                <select required name="status" id="b_status" class="form-select js-select2">
                    <option value="true">Активный</option>
                    <option value="false">Неактивный</option>
                </select>
            </div>
        </div>
        <div>
            <label class="form-label" for="b_description">Описание бренда</label>
            <textarea name="description" id="b_description" rows="3" class="form-input resize-none">{{ old('description') }}</textarea>
        </div>
        <div>
            <label class="form-label" for="brandAttachments">Фотография бренда</label>
            <input type="file" name="attachments[]" id="brandAttachments" multiple
                   class="block w-full text-sm text-gray-600 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100">
        </div>
        <div class="flex justify-end gap-2 pt-2">
            <button type="button" class="btn-secondary" @click="$dispatch('close-modal', 'brand-create')">Отмена</button>
            <button type="submit" class="btn-primary"><i data-lucide="check" class="w-4 h-4"></i> Создать бренд</button>
        </div>
    </form>
</x-modal>
