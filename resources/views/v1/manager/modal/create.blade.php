{{-- Create manager modal. Controlled by parent Alpine state `createOpen`. --}}
<div x-show="createOpen" x-cloak class="fixed inset-0 z-[1055] flex items-center justify-center p-4" style="display:none">
    <div class="absolute inset-0 bg-gray-900/50" @click="createOpen = false"></div>
    <div class="relative w-full max-w-2xl rounded-2xl bg-white p-6 shadow-xl max-h-[90vh] overflow-y-auto"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100">
        <div class="flex items-start justify-between mb-4">
            <h5 class="text-lg font-semibold text-gray-900">Добавить менеджера</h5>
            <button type="button" @click="createOpen = false" class="text-gray-400 hover:text-gray-600">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <form action="{{ route('manager.list.store') }}" method="POST" class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            @csrf
            <div>
                <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1">Имя</label>
                <input type="text" id="first_name" name="first_name" placeholder="Имя"
                       value="{{ old('first_name') }}"
                       class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 focus:outline-none @error('first_name') border-red-400 @enderror">
                @error('first_name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="last_name" class="block text-sm font-medium text-gray-700 mb-1">Фамилия</label>
                <input type="text" id="last_name" name="last_name" placeholder="Фамилия"
                       value="{{ old('last_name') }}"
                       class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 focus:outline-none @error('last_name') border-red-400 @enderror">
                @error('last_name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input required type="email" id="email" name="email" placeholder="example@mail.ru"
                       value="{{ old('email') }}"
                       class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 focus:outline-none">
                @error('email')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Телефон</label>
                <input required type="text" id="phone" name="phone" placeholder="067676767"
                       value="{{ old('phone') }}"
                       class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 focus:outline-none">
            </div>
            <div x-data="{ show: false }">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Пароль</label>
                <div class="relative">
                    <input required :type="show ? 'text' : 'password'" id="password" name="password" placeholder="Пароль"
                           class="block w-full rounded-lg border border-gray-300 px-3 py-2 pr-10 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 focus:outline-none @error('password') border-red-400 @enderror">
                    <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600">
                        <i data-lucide="eye" x-show="!show" class="w-4 h-4"></i>
                        <i data-lucide="eye-off" x-show="show" class="w-4 h-4" style="display:none"></i>
                    </button>
                </div>
                @error('password')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="city_id" class="block text-sm font-medium text-gray-700 mb-1">Город</label>
                <select name="city_id" id="city_id"
                        class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 focus:outline-none">
                    @foreach($cities as $city)
                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="sm:col-span-2 flex items-center gap-3 pt-2">
                <button type="submit" class="btn-primary">Создать менеджера</button>
                <button type="button" class="btn-secondary" @click="createOpen = false">Отмена</button>
            </div>
        </form>
    </div>
</div>
