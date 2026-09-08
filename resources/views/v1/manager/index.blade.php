@extends('v2.layouts.app')

@section('content')
<div x-data="{ createOpen: false }">
    <x-page-header title="Менеджеры"
                   description="Всего: {{ $managers->total() }} {{ trans_choice('менеджер|менеджеров', $managers->total()) }}">
        <x-slot:actions>
            <button type="button" class="btn-primary btn-sm" @click="createOpen = true">
                <i data-lucide="plus" class="w-4 h-4"></i> Добавить менеджера
            </button>
        </x-slot:actions>
    </x-page-header>

    @include('v1.errors.errors')
    @if(session('success'))
        <x-alert type="success" class="mb-4">{{ session('success') }}</x-alert>
    @endif

    <x-card :padding="false">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100 text-sm">
                <thead class="bg-gray-50">
                    <tr class="text-left text-xs font-medium uppercase tracking-wide text-gray-500">
                        <th class="px-5 py-3">#</th>
                        <th class="px-5 py-3">Фамилия имя</th>
                        <th class="px-5 py-3">Email</th>
                        <th class="px-5 py-3">Телефон</th>
                        <th class="px-5 py-3">Статус</th>
                        <th class="px-5 py-3 text-right">Действия</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($managers as $manager)
                        <tr id="model-id-{{ $manager->id }}" class="hover:bg-brand-50/40 transition-colors">
                            <td class="px-5 py-3 text-gray-500">{{ $manager->id }}</td>
                            <td class="px-5 py-3 font-medium text-gray-800">{{ $manager?->profile->last_name }} {{ $manager?->profile->first_name }}</td>
                            <td class="px-5 py-3 text-gray-600">{{ $manager->email }}</td>
                            <td class="px-5 py-3 text-gray-600">{{ $manager?->profile->phone }}</td>
                            <td class="px-5 py-3">
                                @if($manager->status)
                                    <span class="inline-flex items-center rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-medium text-emerald-700">Активный</span>
                                @else
                                    <span class="inline-flex items-center rounded-full bg-red-50 px-2.5 py-0.5 text-xs font-medium text-red-700">Неактивный</span>
                                @endif
                            </td>
                            <td class="px-5 py-3">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('manager.list.show', $manager->id) }}" class="btn-secondary btn-sm" title="Просмотр">
                                        <i data-lucide="eye" class="w-4 h-4"></i>
                                    </a>
                                    <a href="{{ route('manager.list.edit.form', $manager->id) }}" class="btn-secondary btn-sm" title="Редактировать">
                                        <i data-lucide="pencil" class="w-4 h-4"></i>
                                    </a>
                                    <a href="#" data-id="{{ $manager->id }}" class="btn-danger btn-sm model-delete" title="Удалить">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-8">
                                <x-empty-state icon="users" title="Менеджеры не найдены" text="Добавьте первого менеджера." />
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($managers->hasPages())
            <div class="border-t border-gray-100 px-5 py-3">
                <x-pager :paginator="$managers" />
            </div>
        @endif
    </x-card>

    @include('v1.manager.modal.create')
</div>
@endsection

@section('scripts')
    <script>
        function askToDeleteModel(model_id, token, path) {
            Swal.fire({
                title: 'Вы хотите удалить менеджера - #' + model_id + ' ?',
                showDenyButton: true,
                showCancelButton: true,
                cancelButtonText: 'Отмена',
                confirmButtonText: 'Удалить',
                denyButtonText: `Не удалять`,
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: path,
                        type: "DELETE",
                        dataType: "JSON",
                        data: {
                            user_id: model_id,
                            _token: token
                        }
                    });
                    Swal.fire('Менеджер ' + model_id + ' успешно удален', '', 'success');
                    $('#model-id-' + model_id).fadeOut(1000);
                } else if (result.isDenied) {
                    Swal.fire('Вы отменили удаление менеджера ' + model_id, '', 'info')
                }
            })
        }

        $(document).on('click', '.model-delete', function (e) {
            e.preventDefault();
            var model_id = $(this).data('id');
            var token = "{{csrf_token()}}";
            var path = "{{route('manager.list.delete')}}";
            askToDeleteModel(model_id, token, path)
        });
    </script>
@endsection
