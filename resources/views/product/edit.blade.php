@extends('v2.layouts.app')

@section('title', 'Редактирование товара')
@section('breadcrumb')
    <a href="{{ route('product.index') }}" class="hover:text-brand-600 transition-colors">Товары</a>
    <i data-lucide="chevron-right" class="w-3.5 h-3.5 mx-2 text-gray-300"></i>
    <span class="text-gray-700">Редактирование</span>
@endsection

@section('styles')
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.3.1/ckeditor5.css">
@endsection

@section('content')
    <x-page-header title="Редактирование товара" description="{{ $product->title }}">
        <x-slot:actions>
            <a href="{{ route('product.index') }}" class="btn-secondary btn-sm"><i data-lucide="arrow-left" class="w-4 h-4"></i> К списку</a>
        </x-slot:actions>
    </x-page-header>

    @if($errors->any())
        <x-alert type="error" class="mb-4">
            <ul class="list-disc list-inside space-y-0.5">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </x-alert>
    @endif

    <x-card class="mb-6">
        <form action="{{ route('product.update', $product) }}" enctype="multipart/form-data" method="POST" class="space-y-5">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="form-label" for="title_ro">Название (RO) <span class="text-red-500">*</span></label>
                    <input type="text" required name="title_ro" id="title_ro" value="{{ $product->getTranslation('title', 'ro') }}" class="form-input @error('title_ro') border-red-400 @enderror">
                    @error('title_ro')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="form-label" for="title_ru">Название (RU) <span class="text-red-500">*</span></label>
                    <input type="text" required name="title_ru" id="title_ru" value="{{ $product->getTranslation('title', 'ru') }}" class="form-input @error('title_ru') border-red-400 @enderror">
                    @error('title_ru')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="form-label" for="price">Цена <span class="text-red-500">*</span></label>
                    <input type="text" required name="price" id="price" value="{{ $product->price }}" class="form-input @error('price') border-red-400 @enderror">
                    @error('price')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="form-label" for="sale_price">Цена на скидке</label>
                    <input type="number" step="0.01" name="sale_price" id="sale_price" value="{{ $product->sale_price }}" class="form-input @error('sale_price') border-red-400 @enderror">
                    @error('sale_price')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="form-label" for="article">Артикул</label>
                    <input type="text" name="article" id="article" value="{{ $product->article }}" class="form-input">
                </div>
                <div>
                    <label class="form-label" for="shtrih_code">Штрих-код</label>
                    <input type="text" name="shtrih_code" id="shtrih_code" value="{{ $product->shtrih_code }}" class="form-input">
                </div>
                <div>
                    <label class="form-label" for="sku">SKU <span class="text-red-500">*</span></label>
                    <input type="text" required name="sku" id="sku" value="{{ $product->data?->sku }}" class="form-input">
                </div>
                <div>
                    <label class="form-label" for="unit">Единица измерения</label>
                    <input type="text" name="unit" id="unit" value="{{ $product->unit }}" class="form-input">
                </div>
                <div>
                    <label class="form-label" for="stock">Кол-во на складе <span class="text-red-500">*</span></label>
                    <input type="number" required name="stock" id="stock" value="{{ $product->stock }}" class="form-input @error('stock') border-red-400 @enderror">
                    @error('stock')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="form-label" for="min_order">Минимальный заказ</label>
                    <input type="number" name="min_order" id="min_order" value="{{ $product->min_order }}" class="form-input @error('min_order') border-red-400 @enderror">
                    @error('min_order')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="form-label" for="brand_id">Бренд <span class="text-red-500">*</span></label>
                    <select required name="brand_id" id="brand_id" class="form-select js-select2">
                        <option value="">Бренд</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->onec_id }}" {{ $product->brand_id === $brand->onec_id ? 'selected' : '' }}>{{ $brand->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label" for="condition">Состояние <span class="text-red-500">*</span></label>
                    <select required name="condition" id="condition" class="form-select js-select2">
                        <option value="">Состояние</option>
                        @foreach($productConditions as $item => $condition)
                            <option value="{{ $item }}" {{ $product->data?->condition === $item ? 'selected' : '' }}>{{ $condition }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label" for="status">Статус выгрузки <span class="text-red-500">*</span></label>
                    <select required name="status" id="status" class="form-select js-select2">
                        <option value="true" {{ $product->status ? 'selected' : '' }}>Активный</option>
                        <option value="false" {{ !$product->status ? 'selected' : '' }}>Неактивный</option>
                    </select>
                </div>
                <div>
                    <label class="form-label" for="site_status">Статус сайта <span class="text-red-500">*</span></label>
                    <select required name="site_status" id="site_status" class="form-select js-select2">
                        <option value="true" {{ $product->site_status ? 'selected' : '' }}>Активный</option>
                        <option value="false" {{ !$product->site_status ? 'selected' : '' }}>Неактивный</option>
                    </select>
                </div>
                <div class="sm:col-span-2">
                    <label class="form-label" for="upp_sale">Похожие товары</label>
                    <select multiple name="upp_sale[]" id="upp_sale" class="form-select js-select2">
                        @php $upp = is_array(json_decode($product->data?->upp_sale)) ? json_decode($product->data->upp_sale) : []; @endphp
                        @foreach($products as $p)
                            <option value="{{ $p->onec_id }}" {{ in_array($p->onec_id, $upp) ? 'selected' : '' }}>{{ $p->title }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label class="form-label" for="summary_ro">Описание (RO)</label>
                <textarea name="summary_ro" id="summary_ro" class="form-input">{{ $product->data?->getTranslation('summary', 'ro') }}</textarea>
                @error('summary_ro')<p class="form-error">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="form-label" for="summary_ru">Описание (RU)</label>
                <textarea name="summary_ru" id="summary_ru" class="form-input">{{ $product->data?->getTranslation('summary', 'ru') }}</textarea>
                @error('summary_ru')<p class="form-error">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="form-label" for="productAttachments">Добавить фотографии</label>
                <input type="file" name="attachments[]" id="productAttachments" multiple
                       class="block w-full text-sm text-gray-600 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100">
            </div>

            <div class="flex justify-end pt-2 border-t border-gray-100">
                <button type="submit" class="btn-primary"><i data-lucide="check" class="w-4 h-4"></i> Обновить товар</button>
            </div>
        </form>
    </x-card>

    {{-- Product images --}}
    @php
        try { $imagesArray = \App\Services\Product\ProductImagesManager::getProductImagesFromAbsolutePath($product->onec_id); }
        catch (\Throwable $e) { $imagesArray = []; }
    @endphp
    <x-card title="Изображения товара">
        <x-slot:header>
            @if(Route::has('product.regenerate.images'))
                <button type="button" id="regenerate-images-btn" class="btn-secondary btn-sm" data-product-id="{{ $product->id }}">
                    <i data-lucide="refresh-cw" class="w-4 h-4"></i> Регенерировать фото
                </button>
            @endif
        </x-slot:header>
        @if(count($imagesArray))
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach($imagesArray as $key => $file)
                    <a href="/{{ $file }}" target="_blank" class="block rounded-lg border border-gray-200 overflow-hidden hover:border-brand-300 transition-colors">
                        <img src="/{{ $file }}" alt="" class="w-full h-32 object-cover">
                    </a>
                @endforeach
            </div>
        @else
            <x-empty-state icon="image" title="Нет изображений" text="Загрузите фото через форму выше или нажмите «Регенерировать фото»." />
        @endif
    </x-card>
@endsection

@section('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/43.3.1/ckeditor5.umd.js"></script>
    <script>
        (function () {
            if (!window.CKEDITOR) return;
            const {
                ClassicEditor, Essentials, Bold, Italic, Font, Paragraph, Heading, List, Link,
                Image, ImageToolbar, ImageCaption, ImageStyle, ImageResize, LinkImage,
                Table, TableToolbar, BlockQuote, MediaEmbed, Alignment, Indent, IndentBlock,
                Underline, Strikethrough, Code, CodeBlock, HorizontalLine, RemoveFormat, SourceEditing
            } = CKEDITOR;

            const config = {
                plugins: [
                    Essentials, Bold, Italic, Font, Paragraph, Heading, List, Link,
                    Image, ImageToolbar, ImageCaption, ImageStyle, ImageResize, LinkImage,
                    Table, TableToolbar, BlockQuote, MediaEmbed, Alignment, Indent, IndentBlock,
                    Underline, Strikethrough, Code, CodeBlock, HorizontalLine, RemoveFormat, SourceEditing
                ],
                toolbar: {
                    items: [
                        'undo', 'redo', '|', 'sourceEditing', '|', 'heading',
                        '|', 'bold', 'italic', 'underline', 'strikethrough',
                        '|', 'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor',
                        '|', 'link', 'insertTable', 'blockQuote', 'mediaEmbed', 'codeBlock',
                        '|', 'alignment', '|', 'bulletedList', 'numberedList',
                        '|', 'outdent', 'indent', '|', 'horizontalLine', '|', 'removeFormat'
                    ],
                    shouldNotGroupWhenFull: true
                },
                table: { contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells'] }
            };

            ['#summary_ro', '#summary_ru'].forEach(function (sel) {
                const el = document.querySelector(sel);
                if (el) ClassicEditor.create(el, config).catch(function (e) { console.error(e); });
            });
        })();

        @if(Route::has('product.regenerate.images'))
        $(document).on('click', '#regenerate-images-btn', function (e) {
            e.preventDefault();
            var btn = $(this);
            if (!confirm('Регенерировать фотографии? Существующие будут удалены и загружены заново.')) return;
            btn.prop('disabled', true).text('Обработка…');
            $.ajax({
                url: "{{ route('product.regenerate.images', $product) }}", type: "POST", dataType: "JSON",
                data: { _token: "{{ csrf_token() }}" },
                success: function (r) {
                    window.Alpine.store('toast').add(r.status ? 'Задача регенерации поставлена в очередь' : 'Ошибка постановки задачи', r.status ? 'success' : 'error');
                    btn.prop('disabled', false).html('<i data-lucide="refresh-cw" class="w-4 h-4"></i> Регенерировать фото');
                    window.renderIcons && window.renderIcons();
                },
                error: function (xhr) {
                    window.Alpine.store('toast').add((xhr.responseJSON && xhr.responseJSON.message) || 'Ошибка', 'error');
                    btn.prop('disabled', false).html('<i data-lucide="refresh-cw" class="w-4 h-4"></i> Регенерировать фото');
                    window.renderIcons && window.renderIcons();
                }
            });
        });
        @endif
    </script>
@endsection
