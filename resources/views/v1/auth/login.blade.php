<!DOCTYPE html>
<html lang="{{ App::currentLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <title>Вход — Radop</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/admin.css', 'resources/js/admin.js'])
</head>
<body class="font-sans bg-gray-50 text-gray-700 antialiased min-h-screen flex flex-col">
    <main class="flex-1 flex items-center justify-center px-4 py-12">
        <div class="w-full max-w-md">
            {{-- Brand --}}
            <div class="flex justify-center mb-6">
                <img src="{{ asset('/v1/dashboard/assets/images/logo_colored_radop.svg') }}" alt="Radop" class="h-20 w-auto">
            </div>

            <div class="card p-8">
                <h1 class="text-xl font-bold text-gray-900">Вход</h1>
                <p class="text-sm text-gray-500 mt-1 mb-6">Панель управления Radop</p>

                @if($errors->has('auth') || $errors->has('role_permission'))
                    <x-alert type="error" class="mb-4">
                        {{ $errors->first('auth') ?: $errors->first('role_permission') }}
                    </x-alert>
                @endif

                <form method="POST" action="{{ route('auth') }}" class="space-y-4" x-data="{ show: false }">
                    @csrf
                    <div>
                        <label class="form-label" for="username">Email или Login</label>
                        <input type="text" id="username" name="username" value="{{ old('username') }}" autofocus
                               class="form-input @error('username') border-red-400 @enderror"
                               placeholder="Введите email или логин">
                        @error('username')<p class="form-error">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <label class="form-label !mb-0" for="password">Пароль</label>
                            <a href="#" class="text-sm text-brand-600 hover:text-brand-700">Забыли пароль?</a>
                        </div>
                        <div class="relative">
                            <input :type="show ? 'text' : 'password'" id="password" name="password"
                                   class="form-input pr-10 @error('password') border-red-400 @enderror"
                                   placeholder="Введите пароль">
                            <button type="button" @click="show = !show" tabindex="-1"
                                    class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 p-1">
                                <span x-show="!show"><i data-lucide="eye" class="w-4 h-4"></i></span>
                                <span x-show="show" style="display:none;"><i data-lucide="eye-off" class="w-4 h-4"></i></span>
                            </button>
                        </div>
                        @error('password')<p class="form-error">{{ $message }}</p>@enderror
                    </div>

                    <button type="submit" class="btn-primary w-full justify-center">
                        <i data-lucide="log-in" class="w-4 h-4"></i> Войти
                    </button>
                </form>
            </div>

            <p class="text-center text-xs text-gray-400 mt-6">&copy; {{ date('Y') }} RĂDOP. All Rights Reserved.</p>
        </div>
    </main>
</body>
</html>
