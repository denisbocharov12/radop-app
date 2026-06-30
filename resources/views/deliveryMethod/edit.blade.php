@extends('v2.layouts.app')

@section('title', 'Редактирование метода доставки')
@section('breadcrumb')
    <a href="{{ route('deliveryMethod.index') }}" class="hover:text-brand-600 transition-colors">Доставка</a>
    <i data-lucide="chevron-right" class="w-3.5 h-3.5 mx-2 text-gray-300"></i>
    <span class="text-gray-700">Редактирование</span>
@endsection

@section('content')
    <x-page-header title="Редактирование метода доставки" description="{{ $deliveryMethod->name }}">
        <x-slot:actions>
            <a href="{{ route('deliveryMethod.index') }}" class="btn-secondary btn-sm"><i data-lucide="arrow-left" class="w-4 h-4"></i> К списку</a>
        </x-slot:actions>
    </x-page-header>

    @if($errors->any())
        <x-alert type="error" class="mb-4">
            <ul class="list-disc list-inside space-y-0.5">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </x-alert>
    @endif

    <x-card>
        <form action="{{ route('deliveryMethod.update', $deliveryMethod) }}" method="POST" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="form-label" for="name_ro">Название (RO) <span class="text-red-500">*</span></label>
                    <input type="text" required name="name_ro" id="name_ro" value="{{ $deliveryMethod->getTranslation('name', 'ro') }}" class="form-input @error('name_ro') border-red-400 @enderror">
                    @error('name_ro')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="form-label" for="name_ru">Название (RU) <span class="text-red-500">*</span></label>
                    <input type="text" required name="name_ru" id="name_ru" value="{{ $deliveryMethod->getTranslation('name', 'ru') }}" class="form-input @error('name_ru') border-red-400 @enderror">
                    @error('name_ru')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="form-label" for="delivery_price">Стоимость доставки <span class="text-red-500">*</span></label>
                    <input type="text" required name="delivery_price" id="delivery_price" value="{{ $deliveryMethod->delivery_price }}" class="form-input">
                </div>
                <div>
                    <label class="form-label" for="min_cart_sum">Беспл. доставка от суммы <span class="text-red-500">*</span></label>
                    <input type="text" required name="min_cart_sum" id="min_cart_sum" value="{{ $deliveryMethod->min_cart_sum }}" class="form-input">
                </div>
                <div>
                    <label class="form-label" for="status">Статус <span class="text-red-500">*</span></label>
                    <select required name="status" id="status" class="form-select js-select2">
                        <option value="true" {{ $deliveryMethod->status ? 'selected' : '' }}>Активный</option>
                        <option value="false" {{ !$deliveryMethod->status ? 'selected' : '' }}>Неактивный</option>
                    </select>
                </div>
            </div>
            <div class="flex justify-end pt-2 border-t border-gray-100">
                <button type="submit" class="btn-primary"><i data-lucide="check" class="w-4 h-4"></i> Обновить метод</button>
            </div>
        </form>
    </x-card>
@endsection
