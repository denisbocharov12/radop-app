<x-modal name="discount-create" title="Добавить период скидки" maxWidth="max-w-lg">
    <form action="{{ route('discount-period.store') }}" method="POST" class="space-y-4">
        @csrf
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
                <label class="form-label" for="dp_sum_from">Сумма от <span class="text-red-500">*</span></label>
                <input type="text" required name="sum_from" id="dp_sum_from" class="form-input @error('sum_from') border-red-400 @enderror" placeholder="500">
                @error('sum_from')<p class="form-error">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="form-label" for="dp_sum_to">Сумма до <span class="text-red-500">*</span></label>
                <input type="text" required name="sum_to" id="dp_sum_to" class="form-input @error('sum_to') border-red-400 @enderror" placeholder="1500">
                @error('sum_to')<p class="form-error">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="form-label" for="dp_koef">Коэф. скидки <span class="text-red-500">*</span></label>
                <input type="number" step="0.001" required name="discount_koef" id="dp_koef" class="form-input @error('discount_koef') border-red-400 @enderror" placeholder="1.25">
                @error('discount_koef')<p class="form-error">{{ $message }}</p>@enderror
            </div>
        </div>
        <div class="flex justify-end gap-2 pt-2">
            <button type="button" class="btn-secondary" @click="$dispatch('close-modal', 'discount-create')">Отмена</button>
            <button type="submit" class="btn-primary"><i data-lucide="check" class="w-4 h-4"></i> Создать</button>
        </div>
    </form>
</x-modal>
