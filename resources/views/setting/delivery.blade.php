@extends('v2.layouts.app')

@section('title', 'Доставка — дозаказ')

@section('content')
    <x-page-header title="Доставка (дозаказ)"
                   description="Период дня, в течение которого дополнительный заказ (дозаказ) оформляется с бесплатной доставкой и без проверки минимальной суммы.">
    </x-page-header>

    @if(session('success'))
        <x-alert type="success" class="mb-4">{{ session('success') }}</x-alert>
    @endif

    @if($errors->any())
        <x-alert type="error" class="mb-4">
            <ul class="list-disc list-inside space-y-0.5">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </x-alert>
    @endif

    <x-card class="max-w-xl">
        <form method="POST" action="{{ route('setting.delivery.update') }}" class="space-y-5">
            @csrf

            <label class="flex items-center gap-3">
                <input type="checkbox" name="supplement_free_enabled" value="1"
                       {{ old('supplement_free_enabled', $settings->supplement_free_enabled) ? 'checked' : '' }}
                       class="w-4 h-4 rounded border-gray-300 accent-brand-600">
                <span class="text-sm font-medium text-gray-700">Включить бесплатный дозаказ в указанном периоде</span>
            </label>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="supplement_free_start" class="block text-sm font-medium text-gray-700 mb-1">
                        Начало периода
                    </label>
                    <input type="time" id="supplement_free_start" name="supplement_free_start"
                           value="{{ old('supplement_free_start', $settings->startLabel()) }}"
                           class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 focus:outline-none">
                    @error('supplement_free_start')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="supplement_free_end" class="block text-sm font-medium text-gray-700 mb-1">
                        Конец периода
                    </label>
                    <input type="time" id="supplement_free_end" name="supplement_free_end"
                           value="{{ old('supplement_free_end', $settings->endLabel()) }}"
                           class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 focus:outline-none">
                    @error('supplement_free_end')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="flex items-start gap-2 rounded-lg bg-gray-50 border border-gray-100 px-3 py-2 text-sm text-gray-500">
                <i data-lucide="info" class="w-4 h-4 mt-0.5 flex-shrink-0 text-brand-500"></i>
                <span>
                    Если у авторизованного клиента уже есть заказ за сегодня и текущее время попадает в период —
                    новый заказ присоединяется к нему как дополнение с бесплатной доставкой и без минимальной суммы.
                    После конца периода заказ оформляется по обычным правилам.
                </span>
            </div>

            <button type="submit" class="btn-primary">
                <i data-lucide="save" class="w-4 h-4"></i> Сохранить
            </button>
        </form>
    </x-card>
@endsection
