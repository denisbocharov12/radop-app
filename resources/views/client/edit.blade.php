@extends('v2.layouts.app')

@section('title', 'Редактирование клиента')
@section('breadcrumb')
    <a href="{{ route('client.index') }}" class="hover:text-brand-600 transition-colors">Клиенты</a>
    <i data-lucide="chevron-right" class="w-3.5 h-3.5 mx-2 text-gray-300"></i>
    <span class="text-gray-700">Редактирование</span>
@endsection

@section('content')
    <x-page-header title="Редактирование клиента"
                   description="{{ trim(($user->profile->first_name ?? '') . ' ' . ($user->profile->last_name ?? '')) ?: $user->name }}">
        <x-slot:actions>
            <a href="{{ route('client.show', $user) }}" class="btn-secondary btn-sm"><i data-lucide="eye" class="w-4 h-4"></i> Просмотр</a>
        </x-slot:actions>
    </x-page-header>

    @if($errors->any())
        <x-alert type="error" class="mb-4">
            <ul class="list-disc list-inside space-y-0.5">
                @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
            </ul>
        </x-alert>
    @endif

    <x-card>
        <form action="{{ route('client.update', $user) }}" enctype="multipart/form-data" method="POST" class="space-y-5">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="form-label" for="first_name">Имя</label>
                    <input type="text" name="first_name" id="first_name" value="{{ old('first_name', $user->profile->first_name) }}" class="form-input @error('first_name') border-red-400 @enderror">
                    @error('first_name')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="form-label" for="last_name">Фамилия</label>
                    <input type="text" name="last_name" id="last_name" value="{{ old('last_name', $user->profile->last_name) }}" class="form-input">
                </div>
                <div>
                    <label class="form-label" for="role">Роль</label>
                    <select name="role" id="role" class="form-select js-select2">
                        <option value="">Роль</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}" {{ $role->name == optional($user->roles->first())->name ? 'selected' : '' }}>
                                @if($role->name === 'user')Пользователь @elseif($role->name === 'manager')Менеджер @else{{ $role->name }}@endif
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label" for="type_id">Тип клиента</label>
                    <select required name="type_id" id="type_id" class="form-select js-select2">
                        <option value="">Выбрать тип</option>
                        @foreach($userTypes as $userType)
                            <option value="{{ $userType->id }}" {{ $userType->id == $user->type_id ? 'selected' : '' }}>
                                @if($userType->key_name === 'fiz')Физ. лицо @elseif($userType->key_name === 'iur')Юр. лицо @endif
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label" for="email">Email</label>
                    <input type="text" name="email" id="email" value="{{ old('email', $user->email) }}" class="form-input @error('email') border-red-400 @enderror">
                    @error('email')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="form-label" for="phone">Мобильный телефон</label>
                    <input type="text" required name="phone" id="phone" value="{{ old('phone', $user->profile->phone) }}" class="form-input">
                </div>
                <div>
                    <label class="form-label" for="city_id">Город</label>
                    <select required name="city_id" id="city_id" class="form-select js-select2">
                        @foreach($cities as $city)
                            <option value="{{ $city->id }}" {{ $city->id === $user->city_id ? 'selected' : '' }}>{{ $city->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label" for="address">Адрес</label>
                    <input type="text" name="address" id="address" value="{{ old('address', $user->profile->address) }}" class="form-input">
                </div>
                <div>
                    <label class="form-label" for="sale">Персональная скидка, %</label>
                    <input type="text" name="sale" id="sale" value="{{ old('sale', $user->sale) }}" class="form-input">
                </div>
                <div>
                    <label class="form-label" for="status">Статус</label>
                    <select required name="status" id="status" class="form-select js-select2">
                        <option value="true" {{ $user->status ? 'selected' : '' }}>Активный</option>
                        <option value="false" {{ !$user->status ? 'selected' : '' }}>Неактивный</option>
                    </select>
                </div>
                <div>
                    <label class="form-label" for="manager_id">Менеджер</label>
                    <select name="manager_id" id="manager_id" class="form-select js-select2">
                        <option value="">Без менеджера</option>
                        @foreach($managers as $manager)
                            <option value="{{ $manager->id }}" {{ $user->manager_id == $manager->id ? 'selected' : '' }}>
                                {{ $manager->profile->first_name }} {{ $manager->profile->last_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="pt-2 border-t border-gray-100">
                <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-3">Для юридических лиц</p>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="form-label" for="organization_name">Название организации</label>
                        <input type="text" name="organization_name" id="organization_name" value="{{ old('organization_name', $user->profile->organization_name) }}" class="form-input">
                    </div>
                    <div>
                        <label class="form-label" for="cod_fiscal">Фискальный код</label>
                        <input type="text" name="cod_fiscal" id="cod_fiscal" value="{{ old('cod_fiscal', $user->profile->cod_fiscal) }}" class="form-input">
                    </div>
                    <div>
                        <label class="form-label" for="contact_name">Контактное лицо</label>
                        <input type="text" name="contact_name" id="contact_name" value="{{ old('contact_name', $user->profile->contact_name) }}" class="form-input">
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-4 pt-2 border-t border-gray-100">
                <label class="inline-flex items-center gap-2 text-sm text-gray-600 cursor-pointer select-none">
                    <input type="checkbox" name="with_sale" id="with_sale" value="1" {{ $user->with_sale ? 'checked' : '' }} class="w-4 h-4 rounded border-gray-300 accent-brand-600">
                    Применить оптовую цену
                </label>
                <div class="sm:ml-auto flex items-center gap-2">
                    @if(Route::has('client.generate'))
                        <a href="{{ route('client.generate', $user) }}" class="btn-secondary"><i data-lucide="printer" class="w-4 h-4"></i> Новый пароль</a>
                    @endif
                    <button type="submit" class="btn-primary"><i data-lucide="check" class="w-4 h-4"></i> Сохранить</button>
                </div>
            </div>
        </form>
    </x-card>
@endsection
