<x-modal name="product-create" title="Добавить товар" maxWidth="max-w-3xl">
    <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="form-label" for="title_ro">Название (RO) <span class="text-red-500">*</span></label>
                <input type="text" required name="title_ro" id="title_ro" class="form-input @error('title_ro') border-red-400 @enderror" placeholder="Название товара">
                @error('title_ro')<p class="form-error">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="form-label" for="title_ru">Название (RU) <span class="text-red-500">*</span></label>
                <input type="text" required name="title_ru" id="title_ru" class="form-input @error('title_ru') border-red-400 @enderror" placeholder="Название товара">
                @error('title_ru')<p class="form-error">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="form-label" for="price">Цена <span class="text-red-500">*</span></label>
                <input type="text" required name="price" id="price" class="form-input" placeholder="560">
            </div>
            <div>
                <label class="form-label" for="sale_price">Цена на скидке</label>
                <input type="text" name="sale_price" id="sale_price" class="form-input" placeholder="254">
            </div>
            <div>
                <label class="form-label" for="stock">Кол-во на складе <span class="text-red-500">*</span></label>
                <input type="number" required name="stock" id="stock" class="form-input" placeholder="234">
            </div>
            <div>
                <label class="form-label" for="unit">Единица измерения</label>
                <input type="text" name="unit" id="unit" class="form-input" placeholder="шт.">
            </div>
            <div>
                <label class="form-label" for="sku">SKU</label>
                <input type="text" name="sku" id="sku" class="form-input" placeholder="SKU">
            </div>
            <div>
                <label class="form-label" for="shtrih_code">Штрих-код</label>
                <input type="text" name="shtrih_code" id="shtrih_code" class="form-input" placeholder="378820122">
            </div>
            <div>
                <label class="form-label" for="min_order">Минимальный заказ</label>
                <input type="number" name="min_order" id="min_order" class="form-input @error('min_order') border-red-400 @enderror" placeholder="1">
                @error('min_order')<p class="form-error">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="form-label" for="condition">Состояние <span class="text-red-500">*</span></label>
                <select required name="condition" id="condition" class="form-select js-select2">
                    <option value="">Состояние</option>
                    @foreach($productConditions as $key => $condition)
                        <option value="{{ $key }}">{{ $condition }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="form-label" for="brand_id">Бренд <span class="text-red-500">*</span></label>
                <select required name="brand_id" id="brand_id" class="form-select js-select2">
                    <option value="">Бренд</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->onec_id }}">{{ $brand->title }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="form-label" for="status">Статус <span class="text-red-500">*</span></label>
                <select required name="status" id="status" class="form-select js-select2">
                    <option value="true">Активный</option>
                    <option value="false">Неактивный</option>
                </select>
            </div>
            <div class="sm:col-span-2">
                <label class="form-label" for="category_id">Категории <span class="text-red-500">*</span></label>
                <select required multiple name="category_id[]" id="category_id" class="form-select js-select2">
                    @foreach($categories as $category)
                        <option value="{{ $category->onec_id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="sm:col-span-2">
                <label class="form-label" for="upp_sale">Похожие товары</label>
                <select multiple name="upp_sale[]" id="upp_sale" class="form-select js-select2">
                    @foreach($products as $item)
                        <option value="{{ $item->onec_id }}">{{ $item->title }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div>
            <label class="form-label" for="summary_ro">Описание (RO)</label>
            <textarea name="summary_ro" id="summary_ro" rows="4" class="form-input resize-none">{{ old('summary_ro') }}</textarea>
        </div>
        <div>
            <label class="form-label" for="summary_ru">Описание (RU)</label>
            <textarea name="summary_ru" id="summary_ru" rows="4" class="form-input resize-none">{{ old('summary_ru') }}</textarea>
        </div>
        <div>
            <label class="form-label" for="productAttachments">Фотографии</label>
            <input type="file" name="attachments[]" id="productAttachments" multiple
                   class="block w-full text-sm text-gray-600 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100">
        </div>

        <div class="flex justify-end gap-2 pt-2 border-t border-gray-100">
            <button type="button" class="btn-secondary" @click="$dispatch('close-modal', 'product-create')">Отмена</button>
            <button type="submit" class="btn-primary"><i data-lucide="check" class="w-4 h-4"></i> Создать товар</button>
        </div>
    </form>
</x-modal>
