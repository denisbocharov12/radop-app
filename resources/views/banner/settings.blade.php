@extends('v1.layouts.layout')

@section('content')
    @if(session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif

    <div class="theme-card mt-4 p-4">
        <h3 class="theme-title pt-4">Настройки скорости переключения баннера</h3>

        <form method="POST" action="{{ route('banner.banner-settings.update') }}">
            @csrf

            <div class="form-group mb-3">
                <label for="rotation_speed" class="form-label">Скорость переключения (ms)</label>
                <input
                        type="number"
                        id="rotation_speed"
                        name="rotation_speed"
                        class="form-control"
                        value="{{ old('rotation_speed', $settings->rotation_speed) }}"
                        min="100"
                        step="100"
                >
                @error('rotation_speed')
                <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary theme-btn">
                <i class="icon-save"></i> Сохранить
            </button>
        </form>
    </div>
@endsection
