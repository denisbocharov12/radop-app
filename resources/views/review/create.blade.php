@extends('v2.layouts.app')

@section('title', 'Создание отзыва')
@section('breadcrumb')
    <a href="{{ route('review.index') }}" class="hover:text-brand-600 transition-colors">Отзывы</a>
    <i data-lucide="chevron-right" class="w-3.5 h-3.5 mx-2 text-gray-300"></i>
    <span class="text-gray-700">Создание</span>
@endsection

@section('content')
    <x-page-header title="Создание отзыва">
        <x-slot:actions>
            <a href="{{ route('review.index') }}" class="btn-secondary btn-sm"><i data-lucide="arrow-left" class="w-4 h-4"></i> К списку</a>
        </x-slot:actions>
    </x-page-header>

    @if($errors->any())
        <x-alert type="error" class="mb-4">
            <ul class="list-disc list-inside space-y-0.5">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </x-alert>
    @endif

    <x-card>
        <form action="{{ route('review.store') }}" method="POST" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="form-label" for="user_id">Пользователь <span class="text-red-500">*</span></label>
                    <select required name="user_id" id="user_id" class="form-select js-select2">
                        <option value="">Выберите пользователя</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                        @endforeach
                    </select>
                    @error('user_id')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="form-label" for="product_onec_id">Товар <span class="text-red-500">*</span></label>
                    <select required name="product_onec_id" id="product_onec_id" class="form-select js-select2">
                        <option value="">Выберите товар</option>
                        @foreach($products as $product)
                            <option value="{{ $product->onec_id }}">{{ $product->title }}</option>
                        @endforeach
                    </select>
                    @error('product_onec_id')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="form-label" for="score">Оценка (0–5) <span class="text-red-500">*</span></label>
                    <input type="number" step="0.5" min="0" max="5" required name="score" id="score" value="5" class="form-input @error('score') border-red-400 @enderror">
                    @error('score')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="form-label" for="status">Статус <span class="text-red-500">*</span></label>
                    <select required name="status" id="status" class="form-select js-select2">
                        <option value="0">На модерации</option>
                        <option value="1">Одобрен</option>
                    </select>
                </div>
                <div>
                    <label class="form-label" for="is_verified">Подтверждённая покупка</label>
                    <select name="is_verified" id="is_verified" class="form-select js-select2">
                        <option value="0">Нет</option>
                        <option value="1">Да</option>
                    </select>
                </div>
            </div>
            <div>
                <label class="form-label" for="text">Текст отзыва <span class="text-red-500">*</span></label>
                <textarea required name="text" id="text" rows="5" class="form-input resize-none @error('text') border-red-400 @enderror" placeholder="Введите текст отзыва"></textarea>
                @error('text')<p class="form-error">{{ $message }}</p>@enderror
            </div>
            <div class="flex justify-end pt-2 border-t border-gray-100">
                <button type="submit" class="btn-primary"><i data-lucide="check" class="w-4 h-4"></i> Создать отзыв</button>
            </div>
        </form>
    </x-card>
@endsection
