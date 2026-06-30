@extends('v2.layouts.app')

@section('content')
    <x-page-header title="Редактировать менеджера #{{ $manager->id }}">
        <x-slot:actions>
            <a href="{{ route('manager.list.index') }}" class="btn-secondary btn-sm">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> Назад
            </a>
        </x-slot:actions>
    </x-page-header>

    @include('v1.errors.errors')

    <x-card class="max-w-3xl">
        <form action="{{ route('manager.list.update.form', $manager->id) }}" method="POST"
              class="grid grid-cols-1 gap-5 sm:grid-cols-2">
            @csrf
            <div>
                <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1">Имя</label>
                <input type="text" id="first_name" name="first_name" placeholder="Имя"
                       value="{{ old('first_name', $manager->profile->first_name) }}"
                       class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 focus:outline-none @error('first_name') border-red-400 @enderror">
                @error('first_name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="last_name" class="block text-sm font-medium text-gray-700 mb-1">Фамилия</label>
                <input type="text" id="last_name" name="last_name" placeholder="Фамилия"
                       value="{{ old('last_name', $manager->profile->last_name) }}"
                       class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 focus:outline-none @error('last_name') border-red-400 @enderror">
                @error('last_name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input required type="email" id="email" name="email" placeholder="Email"
                       value="{{ old('email', $manager->email) }}"
                       class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 focus:outline-none @error('email') border-red-400 @enderror">
                @error('email')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Телефон</label>
                <input required type="text" id="phone" name="phone" placeholder="Телефон"
                       value="{{ old('phone', $manager->profile->phone) }}"
                       class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 focus:outline-none @error('phone') border-red-400 @enderror">
                @error('phone')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="city_id" class="block text-sm font-medium text-gray-700 mb-1">Город</label>
                <select name="city_id" id="city_id"
                        class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 focus:outline-none">
                    @foreach($cities as $city)
                        <option value="{{ $city->id }}" {{ $city->id === $manager->city_id ? 'selected' : '' }}>{{ $city->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Статус</label>
                <select required name="status" id="status"
                        class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 focus:outline-none">
                    <option {{ $manager->status == true ? 'selected' : '' }} value="true">Активный</option>
                    <option {{ $manager->status == false ? 'selected' : '' }} value="false">Неактивный</option>
                </select>
            </div>
            <div class="sm:col-span-2 flex flex-wrap items-center gap-3 pt-2">
                <button type="submit" class="btn-primary">Обновить менеджера</button>
                <a href="{{ route('client.generate', $manager) }}" class="btn-secondary">
                    <i data-lucide="printer" class="w-4 h-4"></i> Распечатать новый пароль
                </a>
            </div>
        </form>
    </x-card>
@endsection
