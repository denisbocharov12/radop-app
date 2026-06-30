@php
    $assignUrl = \Illuminate\Support\Facades\Route::has('order.order.assign-manager')
        ? route('order.order.assign-manager')
        : (\Illuminate\Support\Facades\Route::has('order.assign-manager') ? route('order.assign-manager') : '');
@endphp
<div x-data="assignManager()" @open-assign-manager.window="open($event.detail.id)"
     x-show="show" style="display:none;" class="fixed inset-0 z-[80] flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-gray-900/50" @click="close()" x-show="show" x-transition.opacity></div>
    <div class="relative bg-white rounded-xl shadow-2xl w-full max-w-md" x-show="show"
         x-transition:enter="ease-out duration-150" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
            <h3 class="text-base font-semibold text-gray-900">Назначить менеджера</h3>
            <button type="button" class="btn-icon" @click="close()"><i data-lucide="x" class="w-5 h-5"></i></button>
        </div>
        <form @submit.prevent="submit()" class="p-5 space-y-4">
            <div>
                <label class="form-label">Менеджер <span class="text-gray-400 text-xs">(заказ #<span x-text="orderId"></span>)</span></label>
                <select class="form-select no-select2" x-model="managerId" required>
                    <option value="">Выберите менеджера</option>
                    @foreach($managers as $manager)
                        <option value="{{ $manager->id }}">{{ $manager->profile->first_name }} {{ $manager->profile->last_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" class="btn-secondary" @click="close()">Отмена</button>
                <button type="submit" class="btn-primary" :disabled="loading || !managerId">
                    <span x-show="!loading">Назначить</span>
                    <span x-show="loading" style="display:none;">Сохранение…</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function assignManager() {
        return {
            show: false, orderId: null, managerId: '', loading: false,
            assignUrl: @json($assignUrl),
            open(id) { this.orderId = id; this.managerId = ''; this.show = true; },
            close() { this.show = false; this.loading = false; },
            async submit() {
                if (!this.managerId || !this.assignUrl) return;
                this.loading = true;
                try {
                    const r = await window.axios.post(this.assignUrl, { order_id: this.orderId, manager_id: this.managerId });
                    window.Alpine.store('toast').add((r.data && r.data.message) || 'Менеджер назначен', 'success');
                    setTimeout(() => location.reload(), 700);
                } catch (e) {
                    window.Alpine.store('toast').add((e.response && e.response.data && e.response.data.message) || 'Ошибка при назначении', 'error');
                    this.loading = false;
                }
            },
        };
    }
</script>
