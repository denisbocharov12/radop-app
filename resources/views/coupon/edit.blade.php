@extends('v2.layouts.app')

@section('title', 'Редактирование купона')
@section('breadcrumb')
    <a href="{{ route('coupon.index') }}" class="hover:text-brand-600 transition-colors">Купоны</a>
    <i data-lucide="chevron-right" class="w-3.5 h-3.5 mx-2 text-gray-300"></i>
    <span class="text-gray-700">Редактирование</span>
@endsection

@section('content')
    <x-page-header title="Редактирование купона" description="{{ $coupon->code }}">
        <x-slot:actions>
            <a href="{{ route('coupon.index') }}" class="btn-secondary btn-sm"><i data-lucide="arrow-left" class="w-4 h-4"></i> К списку</a>
        </x-slot:actions>
    </x-page-header>

    @if($errors->any())
        <x-alert type="error" class="mb-4">
            <ul class="list-disc list-inside space-y-0.5">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </x-alert>
    @endif

    <x-card>
        <form action="{{ route('coupon.update', $coupon) }}" method="POST" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="form-label" for="code">Код <span class="text-red-500">*</span></label>
                    <input type="text" required name="code" id="code" value="{{ $coupon->code }}" class="form-input @error('code') border-red-400 @enderror">
                    @error('code')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="form-label" for="type">Тип купона</label>
                    <select name="type" id="type" class="form-select js-select2">
                        <option value="percent" {{ $coupon->type === 'percent' ? 'selected' : '' }}>Процентная ставка</option>
                        <option value="fixed" {{ $coupon->type === 'fixed' ? 'selected' : '' }}>Фиксированная ставка</option>
                    </select>
                </div>
                <div>
                    <label class="form-label" for="value">Значение % <span class="text-red-500">*</span></label>
                    <input type="number" required name="value" id="value" value="{{ $coupon->value }}" class="form-input @error('value') border-red-400 @enderror">
                    @error('value')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="form-label" for="minimal_total">Мин. сумма для активации <span class="text-red-500">*</span></label>
                    <input type="number" required name="minimal_total" id="minimal_total" value="{{ $coupon->minimal_total }}" class="form-input @error('minimal_total') border-red-400 @enderror">
                    @error('minimal_total')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="form-label" for="user_id">Клиент</label>
                    <select name="user_id" id="user_id" class="form-select js-select2">
                        <option value="">Все клиенты</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ $coupon->user_id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label" for="status">Статус <span class="text-red-500">*</span></label>
                    <select required name="status" id="status" class="form-select js-select2">
                        <option value="true" {{ $coupon->status ? 'selected' : '' }}>Активный</option>
                        <option value="false" {{ !$coupon->status ? 'selected' : '' }}>Неактивный</option>
                    </select>
                </div>
                <div>
                    <label class="form-label" for="start_date">Начало действия</label>
                    <input type="text" name="start_date" id="start_date" value="{{ $coupon->start_date ? $coupon->start_date->format('d.m.Y') : old('start_date') }}" class="form-input" placeholder="дд.мм.гггг">
                </div>
                <div>
                    <label class="form-label" for="end_date">Конец действия</label>
                    <input type="text" name="end_date" id="end_date" value="{{ $coupon->end_date ? $coupon->end_date->format('d.m.Y') : old('end_date') }}" class="form-input" placeholder="дд.мм.гггг">
                </div>
            </div>
            <div class="flex justify-end pt-2 border-t border-gray-100">
                <button type="submit" class="btn-primary"><i data-lucide="check" class="w-4 h-4"></i> Обновить купон</button>
            </div>
        </form>
    </x-card>
@endsection
