@extends('v2.layouts.app')

@section('title', 'Редактирование города')
@section('breadcrumb')
    <a href="{{ route('city.index') }}" class="hover:text-brand-600 transition-colors">Города</a>
    <i data-lucide="chevron-right" class="w-3.5 h-3.5 mx-2 text-gray-300"></i>
    <span class="text-gray-700">Редактирование</span>
@endsection

@section('content')
    <x-page-header title="Редактирование города" description="{{ $city->name }}">
        <x-slot:actions>
            <a href="{{ route('city.index') }}" class="btn-secondary btn-sm"><i data-lucide="arrow-left" class="w-4 h-4"></i> К списку</a>
        </x-slot:actions>
    </x-page-header>

    @if($errors->any())
        <x-alert type="error" class="mb-4">
            <ul class="list-disc list-inside space-y-0.5">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </x-alert>
    @endif

    <x-card>
        <form action="{{ route('city.update', $city) }}" method="POST" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="form-label" for="name_ro">Название (RO) <span class="text-red-500">*</span></label>
                    <input type="text" required name="name_ro" id="name_ro" value="{{ $city->getTranslation('name', 'ro') }}" class="form-input @error('name_ro') border-red-400 @enderror">
                    @error('name_ro')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="form-label" for="name_ru">Название (RU) <span class="text-red-500">*</span></label>
                    <input type="text" required name="name_ru" id="name_ru" value="{{ $city->getTranslation('name', 'ru') }}" class="form-input @error('name_ru') border-red-400 @enderror">
                    @error('name_ru')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="form-label" for="delivery_sum">Сумма доставки (MDL) <span class="text-red-500">*</span></label>
                    <input type="number" required name="delivery_sum" id="delivery_sum" value="{{ $city->delivery_sum }}" class="form-input">
                </div>
                <div>
                    <label class="form-label" for="required_sum">Мин. сумма заказа (MDL) <span class="text-red-500">*</span></label>
                    <input type="number" required name="required_sum" id="required_sum" value="{{ $city->required_sum }}" class="form-input">
                </div>
            </div>
            <div class="flex justify-end pt-2 border-t border-gray-100">
                <button type="submit" class="btn-primary"><i data-lucide="check" class="w-4 h-4"></i> Обновить город</button>
            </div>
        </form>
    </x-card>
@endsection
