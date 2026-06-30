@php $catExportBase = url('/admin/categories'); @endphp
<div x-data="categoryExport(@js($catExportBase))" @open-category-export.window="open($event.detail.id)"
     x-show="show" style="display:none;" class="fixed inset-0 z-[80] flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-gray-900/50" @click="close()" x-show="show" x-transition.opacity></div>
    <div class="relative bg-white rounded-xl shadow-2xl w-full max-w-sm" x-show="show"
         x-transition:enter="ease-out duration-150" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
            <h3 class="text-base font-semibold text-gray-900">Язык экспорта</h3>
            <button type="button" class="btn-icon" @click="close()"><i data-lucide="x" class="w-5 h-5"></i></button>
        </div>
        <div class="p-5 space-y-3">
            <label class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer"><input type="radio" value="ru" x-model="locale" class="w-4 h-4 accent-brand-600"> Русский (Ru)</label>
            <label class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer"><input type="radio" value="ro" x-model="locale" class="w-4 h-4 accent-brand-600"> Румынский (Ro)</label>
            <div class="flex justify-end gap-2 pt-3">
                <button type="button" class="btn-secondary" @click="close()">Отмена</button>
                <button type="button" class="btn-primary" :disabled="loading" @click="confirm()">
                    <span x-show="!loading"><i data-lucide="file-spreadsheet" class="w-4 h-4"></i> Экспортировать</span>
                    <span x-show="loading" style="display:none;">Формирование…</span>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function categoryExport(base) {
        return {
            show: false, id: null, locale: 'ru', loading: false, base: base,
            open(id) { this.id = id; this.locale = 'ru'; this.show = true; },
            close() { this.show = false; this.loading = false; },
            async confirm() {
                if (!this.id) return;
                this.loading = true;
                try {
                    const r = await window.axios.post(this.base + '/' + this.id + '/export/onec-prices', { locale: this.locale });
                    const ok = !(r.data && r.data.success === false);
                    window.Alpine.store('toast').add((r.data && r.data.message) || 'Экспорт сформирован', ok ? 'success' : 'error');
                } catch (e) {
                    window.Alpine.store('toast').add((e.response && e.response.data && e.response.data.message) || 'Ошибка при экспорте', 'error');
                }
                this.close();
            },
        };
    }
</script>
