@extends('v2.layouts.app')

@section('title', 'Редактирование периода скидки')
@section('breadcrumb')
    <a href="{{ route('discount-period.index') }}" class="hover:text-brand-600 transition-colors">Период скидок</a>
    <i data-lucide="chevron-right" class="w-3.5 h-3.5 mx-2 text-gray-300"></i>
    <span class="text-gray-700">#{{ $discountPeriod->id }}</span>
@endsection

@section('content')
    <x-page-header title="Редактирование периода скидки" description="#{{ $discountPeriod->id }}">
        <x-slot:actions>
            <a href="{{ route('discount-period.index') }}" class="btn-secondary btn-sm"><i data-lucide="arrow-left" class="w-4 h-4"></i> К списку</a>
        </x-slot:actions>
    </x-page-header>

    @if($errors->any())
        <x-alert type="error" class="mb-4">
            <ul class="list-disc list-inside space-y-0.5">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </x-alert>
    @endif

    <x-card>
        <form action="{{ route('discount-period.update', $discountPeriod) }}" method="POST" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="form-label" for="sum_from">Сумма от <span class="text-red-500">*</span></label>
                    <input type="text" required name="sum_from" id="sum_from" value="{{ (float) $discountPeriod->sum_from }}" class="form-input @error('sum_from') border-red-400 @enderror">
                    @error('sum_from')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="form-label" for="sum_to">Сумма до <span class="text-red-500">*</span></label>
                    <input type="text" required name="sum_to" id="sum_to" value="{{ (float) $discountPeriod->sum_to }}" class="form-input @error('sum_to') border-red-400 @enderror">
                    @error('sum_to')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="form-label" for="discount_koef">Коэф. скидки <span class="text-red-500">*</span></label>
                    <input type="number" step="0.001" required name="discount_koef" id="discount_koef" value="{{ (float) $discountPeriod->discount_koef }}" class="form-input @error('discount_koef') border-red-400 @enderror">
                    @error('discount_koef')<p class="form-error">{{ $message }}</p>@enderror
                </div>
            </div>
            <div class="flex justify-end pt-2 border-t border-gray-100">
                <button type="submit" class="btn-primary"><i data-lucide="check" class="w-4 h-4"></i> Обновить</button>
            </div>
        </form>
    </x-card>
@endsection
