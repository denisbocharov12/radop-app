<!-- Quick Add Menu modal -->
<div x-show="addMenuOpen" x-cloak
     class="fixed inset-0 z-50 flex items-center justify-center p-4"
     x-transition.opacity>
    <div class="absolute inset-0 bg-black/40" @click="addMenuOpen = false"></div>
    <div class="relative z-10 w-full max-w-2xl rounded-xl bg-white shadow-xl"
         x-transition>
        <div class="flex items-center justify-between border-b border-gray-100 px-6 py-4">
            <h5 class="text-base font-semibold text-gray-900">Добавить меню</h5>
            <button type="button" @click="addMenuOpen = false" class="text-gray-400 hover:text-gray-600">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>
        <form action="{{ route('admin.menus.store') }}" method="POST" class="px-6 py-5">
            @csrf
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                    <label for="modal_code" class="block text-sm font-medium text-gray-700 mb-1">Код меню<span class="text-red-500">*</span></label>
                    <input type="text" required id="modal_code" name="code" placeholder="main_menu"
                           class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 focus:outline-none">
                </div>
                <div>
                    <label for="modal_name" class="block text-sm font-medium text-gray-700 mb-1">Название меню<span class="text-red-500">*</span></label>
                    <input type="text" required id="modal_name" name="name" placeholder="Главное меню"
                           class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 focus:outline-none">
                </div>
                <div>
                    <label for="modal_link" class="block text-sm font-medium text-gray-700 mb-1">Ссылка</label>
                    <input type="text" id="modal_link" name="link" placeholder="/catalog"
                           class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 focus:outline-none">
                </div>
                <div>
                    <label for="modal_is_active" class="block text-sm font-medium text-gray-700 mb-1">Статус</label>
                    <select required name="is_active" id="modal_is_active"
                            class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 focus:outline-none">
                        <option value="1" selected>Активное</option>
                        <option value="0">Неактивное</option>
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label for="modal_description" class="block text-sm font-medium text-gray-700 mb-1">Описание</label>
                    <textarea id="modal_description" name="description" rows="3" placeholder="Описание меню"
                              class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 focus:outline-none"></textarea>
                </div>
            </div>
            <div class="mt-6 flex items-center gap-3">
                <button type="submit" class="btn-primary">Создать меню</button>
                <button type="button" @click="addMenuOpen = false" class="btn-secondary">Отмена</button>
            </div>
        </form>
    </div>
</div>
