@if($filials->count())
    <div class="table-wrap">
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Адрес</th>
                    <th>Телефон</th>
                    <th>Город</th>
                    <th class="text-right">Действия</th>
                </tr>
            </thead>
            <tbody>
                @foreach($filials as $filial)
                    <tr>
                        <td class="font-medium text-gray-500">#{{ $filial->id }}</td>
                        <td class="font-medium text-gray-900">{{ $filial->address ?: '—' }}</td>
                        <td>{{ $filial->phone ?: '—' }}</td>
                        <td>{{ $filial->city?->name ?: '—' }}</td>
                        <td class="text-right">
                            <x-table-actions
                                :editUrl="Route::has('filial.edit') ? route('filial.edit', $filial) : null"
                                :deleteUrl="Route::has('filial.delete') ? route('filial.delete') . '?filial_id=' . $filial->id : null"
                                :deleteName="'филиал #' . $filial->id" />
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@else
    <x-empty-state icon="store" title="Нет филиалов" text="У этого клиента ещё не добавлено ни одного филиала." />
@endif
