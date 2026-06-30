<x-modal name="filial-create" title="Добавить филиал" maxWidth="max-w-xl">
    <form action="{{ route('filial.store') }}" method="POST" class="space-y-4">
        @csrf
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="form-label" for="f_address">Адрес <span class="text-red-500">*</span></label>
                <input type="text" required name="address" id="f_address" class="form-input @error('address') border-red-400 @enderror" placeholder="Адрес">
                @error('address')<p class="form-error">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="form-label" for="f_phone">Телефон</label>
                <input type="text" name="phone" id="f_phone" class="form-input @error('phone') border-red-400 @enderror" placeholder="06255122">
                @error('phone')<p class="form-error">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="form-label" for="f_city_id">Город <span class="text-red-500">*</span></label>
                <select required name="city_id" id="f_city_id" class="form-select js-select2">
                    @foreach($cities as $city)
                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="form-label" for="f_user_id">Клиент</label>
                <select name="user_id" id="f_user_id" class="form-select js-select2">
                    <option value="">Выберите клиента</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->profile?->organization_name ?: ('#' . $user->id) }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="flex justify-end gap-2 pt-2">
            <button type="button" class="btn-secondary" @click="$dispatch('close-modal', 'filial-create')">Отмена</button>
            <button type="submit" class="btn-primary"><i data-lucide="check" class="w-4 h-4"></i> Создать филиал</button>
        </div>
    </form>
</x-modal>
