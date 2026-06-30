@extends('v2.layouts.app')

@section('title', 'Редактирование филиала')
@section('breadcrumb')
    <a href="{{ route('filial.index') }}" class="hover:text-brand-600 transition-colors">Филиалы</a>
    <i data-lucide="chevron-right" class="w-3.5 h-3.5 mx-2 text-gray-300"></i>
    <span class="text-gray-700">Редактирование</span>
@endsection

@section('content')
    <x-page-header title="Редактирование филиала" description="#{{ $filial->id }}">
        <x-slot:actions>
            <a href="{{ route('filial.index') }}" class="btn-secondary btn-sm"><i data-lucide="arrow-left" class="w-4 h-4"></i> К списку</a>
        </x-slot:actions>
    </x-page-header>

    @if($errors->any())
        <x-alert type="error" class="mb-4">
            <ul class="list-disc list-inside space-y-0.5">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </x-alert>
    @endif

    <x-card>
        <form action="{{ route('filial.update', $filial) }}" method="POST" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="form-label" for="address">Адрес <span class="text-red-500">*</span></label>
                    <input type="text" required name="address" id="address" value="{{ $filial->address }}" class="form-input @error('address') border-red-400 @enderror">
                    @error('address')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="form-label" for="phone">Телефон</label>
                    <input type="text" name="phone" id="phone" value="{{ $filial->phone }}" class="form-input @error('phone') border-red-400 @enderror">
                    @error('phone')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="form-label" for="city_id">Город <span class="text-red-500">*</span></label>
                    <select required name="city_id" id="city_id" class="form-select js-select2">
                        @foreach($cities as $city)
                            <option value="{{ $city->id }}" {{ $city->id === $filial->city_id ? 'selected' : '' }}>{{ $city->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="flex justify-end pt-2 border-t border-gray-100">
                <button type="submit" class="btn-primary"><i data-lucide="check" class="w-4 h-4"></i> Обновить филиал</button>
            </div>
        </form>
    </x-card>
@endsection
