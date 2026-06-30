<x-modal name="category-create" title="Добавить категорию" maxWidth="max-w-2xl">
    <form action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="form-label" for="c_name_ro">Название (RO) <span class="text-red-500">*</span></label>
                <input type="text" required name="name_ro" id="c_name_ro" class="form-input @error('name_ro') border-red-400 @enderror" placeholder="Categoria">
                @error('name_ro')<p class="form-error">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="form-label" for="c_name_ru">Название (RU) <span class="text-red-500">*</span></label>
                <input type="text" required name="name_ru" id="c_name_ru" class="form-input @error('name') border-red-400 @enderror" placeholder="Категория">
                @error('name')<p class="form-error">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="form-label" for="c_parent_id">Родительская категория</label>
                <select name="parent_id" id="c_parent_id" class="form-select js-select2">
                    <option value="">Без родителя</option>
                    @foreach($categories as $item)
                        <option value="{{ $item->onec_id }}">{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="form-label" for="c_status">Статус <span class="text-red-500">*</span></label>
                <select required name="status" id="c_status" class="form-select js-select2">
                    <option value="true">Активная</option>
                    <option value="false">Неактивная</option>
                </select>
            </div>
        </div>
        <div>
            <label class="form-label" for="c_summary">Краткое описание</label>
            <textarea name="summary" id="c_summary" rows="3" class="form-input resize-none">{{ old('summary') }}</textarea>
        </div>
        <div>
            <label class="form-label" for="c_attachments">Фотография категории</label>
            <input type="file" name="attachments[]" id="c_attachments" multiple
                   class="block w-full text-sm text-gray-600 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100">
        </div>
        <div class="flex justify-end gap-2 pt-2">
            <button type="button" class="btn-secondary" @click="$dispatch('close-modal', 'category-create')">Отмена</button>
            <button type="submit" class="btn-primary"><i data-lucide="check" class="w-4 h-4"></i> Создать категорию</button>
        </div>
    </form>
</x-modal>
