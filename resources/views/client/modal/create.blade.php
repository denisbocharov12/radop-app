<x-modal name="client-create" title="Добавить клиента" maxWidth="max-w-2xl">
    <form action="{{ route('client.store') }}" method="POST" class="space-y-5">
        @csrf
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="form-label" for="first_name">Имя <span class="text-red-500">*</span></label>
                <input type="text" required name="first_name" id="first_name" class="form-input @error('first_name') border-red-400 @enderror" placeholder="Имя">
                @error('first_name')<p class="form-error">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="form-label" for="last_name">Фамилия</label>
                <input type="text" name="last_name" id="last_name" class="form-input" placeholder="Фамилия">
            </div>
            <div>
                <label class="form-label" for="role">Роль <span class="text-red-500">*</span></label>
                <select required name="role" id="role" class="form-select js-select2">
                    <option value="">Выбрать роль</option>
                    @foreach($roles as $role)
                        @if($role->name === 'user')<option value="user">Пользователь</option>
                        @elseif($role->name === 'manager')<option value="manager">Менеджер</option>@endif
                    @endforeach
                </select>
            </div>
            <div>
                <label class="form-label" for="type_id">Тип клиента <span class="text-red-500">*</span></label>
                <select required name="type_id" id="type_id" class="form-select js-select2">
                    <option value="">Выбрать тип</option>
                    @foreach($userTypes as $userType)
                        @if($userType->key_name === 'iur')<option value="{{ $userType->id }}">Юр. лицо</option>
                        @elseif($userType->key_name === 'fiz')<option value="{{ $userType->id }}">Физ. лицо</option>@endif
                    @endforeach
                </select>
            </div>
            <div>
                <label class="form-label" for="email">Email <span class="text-red-500">*</span></label>
                <input type="email" required name="email" id="email" class="form-input @error('email') border-red-400 @enderror" placeholder="example@mail.com">
                @error('email')<p class="form-error">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="form-label" for="phone">Мобильный телефон <span class="text-red-500">*</span></label>
                <input type="text" required name="phone" id="phone" class="form-input" placeholder="373 777 77 777">
            </div>
            <div>
                <label class="form-label" for="city_id">Город <span class="text-red-500">*</span></label>
                <select required name="city_id" id="city_id" class="form-select js-select2">
                    @foreach($cities as $city)<option value="{{ $city->id }}">{{ $city->name }}</option>@endforeach
                </select>
            </div>
            <div>
                <label class="form-label" for="address">Адрес</label>
                <input type="text" name="address" id="address" class="form-input" placeholder="ул. Пушкина 22">
            </div>
            <div>
                <label class="form-label" for="sale">Персональная скидка, %</label>
                <input type="text" name="sale" id="sale" class="form-input" placeholder="15">
            </div>
            <div>
                <label class="form-label" for="status">Статус <span class="text-red-500">*</span></label>
                <select required name="status" id="status" class="form-select js-select2">
                    <option value="true">Активный</option>
                    <option value="false">Неактивный</option>
                </select>
            </div>
            <div x-data="{ show: false }">
                <label class="form-label" for="password">Пароль <span class="text-red-500">*</span></label>
                <div class="relative">
                    <input :type="show ? 'text' : 'password'" required name="password" id="password" class="form-input pr-10 @error('password') border-red-400 @enderror" placeholder="Новый пароль">
                    <button type="button" @click="show = !show" tabindex="-1"
                            class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-700"
                            :aria-label="show ? 'Скрыть пароль' : 'Показать пароль'">
                        <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                        <svg x-show="show" style="display:none;" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"/><path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"/><path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"/><line x1="2" x2="22" y1="2" y2="22"/></svg>
                    </button>
                </div>
                @error('password')<p class="form-error">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="pt-2 border-t border-gray-100">
            <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-3">Для юридических лиц</p>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="form-label" for="organization_name">Название организации</label>
                    <input type="text" name="organization_name" id="organization_name" class="form-input" placeholder="ООО «Компания»">
                </div>
                <div>
                    <label class="form-label" for="cod_fiscal">Фискальный код</label>
                    <input type="text" name="cod_fiscal" id="cod_fiscal" class="form-input" placeholder="1234567891234">
                </div>
                <div>
                    <label class="form-label" for="contact_name">Контактное лицо</label>
                    <input type="text" name="contact_name" id="contact_name" class="form-input" placeholder="Контактное лицо">
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-2 pt-2">
            <button type="button" class="btn-secondary" @click="$dispatch('close-modal', 'client-create')">Отмена</button>
            <button type="submit" class="btn-primary"><i data-lucide="check" class="w-4 h-4"></i> Создать клиента</button>
        </div>
    </form>
</x-modal>
