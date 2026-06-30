@extends('v2.layouts.app')

@section('content')
    <x-page-header title="Экспорты менеджеров"
                   description="Всего файлов: {{ $files->total() }}" />

    @include('v1.errors.errors')

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
                                <a href="{{ route('manager-export.download', ['file' => rawurlencode($file['name'])]) }}"
                                   class="btn-primary btn-sm">
                                    <i data-lucide="download" class="w-4 h-4"></i> Скачать
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-5 py-8">
                                <x-empty-state icon="file-x" title="Файлы не найдены" text="Экспорты менеджеров пока не сформированы." />
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
@endsection
