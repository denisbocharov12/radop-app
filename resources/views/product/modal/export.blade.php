<x-modal name="product-export" title="Экспорт товаров в Excel" maxWidth="max-w-lg">
    <form action="{{ route('product.export-excel') }}" method="GET" class="space-y-4">
        <p class="text-sm text-gray-500">
            Выберите фильтры — в файл попадут только товары, соответствующие условиям.
            Кратные пробелы в наименованиях сохраняются в Excel без изменений.
        </p>

        <div>
            <label class="form-label">Состояние</label>
            <select name="filter[condition]" class="form-select no-select2 w-full">
                <option value="">Все</option>
                <option value="new">Новинки</option>
                <option value="popular">Популярные</option>
                <option value="hot">Hit</option>
                <option value="featured">Рекомендуемые</option>
                <option value="sale">Со скидкой</option>
            </select>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="form-label">Статус выгрузки</label>
                <select name="filter[status]" class="form-select no-select2 w-full">
                    <option value="">Активные (по умолчанию)</option>
                    <option value="1">Только активные</option>
                    <option value="0">Только неактивные</option>
                </select>
            </div>
            <div>
                <label class="form-label">Статус сайта</label>
                <select name="filter[site_status]" class="form-select no-select2 w-full">
                    <option value="">Все</option>
                    <option value="1">Только активные</option>
                    <option value="0">Только неактивные</option>
                </select>
            </div>
        </div>

        <div>
            <label class="form-label">Категория</label>
            <select name="filter[category]" class="form-select w-full" data-placeholder="Все категории">
                <option value="">Все категории</option>
                @foreach(($categoryOptions ?? []) as $opt)
                    <option value="{{ $opt['onec_id'] }}">{{ $opt['label'] }}</option>
                @endforeach
            </select>
        </div>

        <p class="text-xs text-gray-400">
            «Активные (по умолчанию)» соответствует поведению списка: без явного выбора экспортируются
            товары со статусом выгрузки «Активный».
        </p>

        <div class="flex justify-end gap-2 pt-2 border-t border-gray-100">
            <button type="button" class="btn-secondary" @click="$dispatch('close-modal', 'product-export')">Отмена</button>
            <button type="submit" class="btn-primary"><i data-lucide="download" class="w-4 h-4"></i> Скачать Excel</button>
        </div>
    </form>
</x-modal>
