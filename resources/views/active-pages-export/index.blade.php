@extends('v2.layouts.app')

@section('content')
<div x-data="activePagesExport()">
    <x-page-header title="Экспорт активных страниц"
                   description="New, Sale, Popular — всего файлов: {{ $files->total() }}">
        <x-slot:actions>
            <button type="button" class="btn-primary btn-sm" @click="openModal('new')">
                <i data-lucide="plus" class="w-4 h-4"></i> New
            </button>
            <button type="button" class="btn-primary btn-sm" @click="openModal('popular')">
                <i data-lucide="plus" class="w-4 h-4"></i> Popular
            </button>
            <button type="button" class="btn-primary btn-sm" @click="openModal('sale')">
                <i data-lucide="plus" class="w-4 h-4"></i> Sale
            </button>
        </x-slot:actions>
    </x-page-header>

    @include('v1.errors.errors')
    @if(session('error'))
        <x-alert type="error" class="mb-4">{{ session('error') }}</x-alert>
    @endif
    @if(session('success'))
        <x-alert type="success" class="mb-4">{{ session('success') }}</x-alert>
    @endif

    <x-card :padding="false">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100 text-sm">
                <thead class="bg-gray-50">
                    <tr class="text-left text-xs font-medium uppercase tracking-wide text-gray-500">
                        <th class="px-5 py-3">Имя файла</th>
                        <th class="px-5 py-3">Размер</th>
                        <th class="px-5 py-3">Дата создания</th>
                        <th class="px-5 py-3 text-right">Действия</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($files as $file)
                        <tr class="hover:bg-brand-50/40 transition-colors">
                            <td class="px-5 py-3 font-medium text-gray-800">{{ $file['name'] }}</td>
                            <td class="px-5 py-3 text-gray-600">{{ number_format($file['size'] / 1048576, 2) }} MB</td>
                            <td class="px-5 py-3 text-gray-600">{{ date('d.m.Y H:i', $file['modified']) }}</td>
                            <td class="px-5 py-3 text-right">
                                <a href="{{ route('active-pages-export.download', ['file' => rawurlencode($file['name'])]) }}"
                                   class="btn-primary btn-sm">
                                    <i data-lucide="download" class="w-4 h-4"></i> Скачать
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-5 py-8">
                                <x-empty-state icon="file-x" title="Файлы не найдены" text="Экспорты активных страниц пока не сформированы." />
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($files->hasPages())
            <div class="border-t border-gray-100 px-5 py-3">
                <x-pager :paginator="$files" />
            </div>
        @endif
    </x-card>

    {{-- Locale selection modal --}}
    <div x-show="open" x-cloak class="fixed inset-0 z-[1055] flex items-center justify-center p-4" style="display:none">
        <div class="absolute inset-0 bg-gray-900/50" @click="open = false"></div>
        <div class="relative w-full max-w-md rounded-2xl bg-white p-6 shadow-xl"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100">
            <div class="flex items-start justify-between mb-4">
                <h5 class="text-lg font-semibold text-gray-900">Выберите язык экспорта</h5>
                <button type="button" @click="open = false" class="text-gray-400 hover:text-gray-600">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            <div class="space-y-2">
                <label class="flex items-center gap-2 cursor-pointer rounded-lg border border-gray-200 px-3 py-2 hover:bg-gray-50">
                    <input type="radio" name="active_export_locale" value="ru" x-model="locale" class="text-brand-600 focus:ring-brand-500">
                    <span class="text-sm text-gray-800">Русский (Ru)</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer rounded-lg border border-gray-200 px-3 py-2 hover:bg-gray-50">
                    <input type="radio" name="active_export_locale" value="ro" x-model="locale" class="text-brand-600 focus:ring-brand-500">
                    <span class="text-sm text-gray-800">Румынский (Ro)</span>
                </label>
            </div>
            <div class="mt-6 flex items-center gap-3">
                <button type="button" class="btn-primary" @click="submitExport()">Экспортировать</button>
                <button type="button" class="btn-secondary" @click="open = false">Отмена</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function activePagesExport() {
    return {
        open: false,
        exportType: null,
        locale: 'ru',
        openModal(type) {
            this.exportType = type;
            this.locale = 'ru';
            this.open = true;
        },
        submitExport() {
            if (!this.locale) {
                Swal.fire({ icon: 'error', title: 'Ошибка', text: 'Пожалуйста, выберите язык экспорта' });
                return;
            }
            this.open = false;
            $.ajax({
                url: '{{ route("active-pages-export.generate") }}',
                type: 'POST',
                dataType: 'json',
                data: {
                    type: this.exportType,
                    locale: this.locale,
                    _token: '{{ csrf_token() }}'
                },
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                success: function (response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Успешно!',
                            text: response.message,
                            timer: 3000,
                            showConfirmButton: false
                        }).then(function () { location.reload(); });
                    } else {
                        Swal.fire({ icon: 'error', title: 'Ошибка', text: response.message || 'Ошибка при экспорте' });
                    }
                },
                error: function (xhr) {
                    var errorMessage = 'Произошла ошибка при формировании экспорта';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    } else if (xhr.status === 404) {
                        errorMessage = 'Маршрут не найден.';
                    } else if (xhr.status === 403) {
                        errorMessage = 'Нет доступа к этой операции.';
                    }
                    Swal.fire({ icon: 'error', title: 'Ошибка', text: errorMessage });
                }
            });
        }
    };
}
</script>
@endsection
