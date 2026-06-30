<thead>
    <tr>
        <th>ID</th>
        <th class="text-center">Порядок</th>
        <th>Изображение RU</th>
        <th>Изображение RO</th>
        <th>Статус</th>
        <th class="hidden lg:table-cell">Ссылка</th>
        <th class="text-right">Действия</th>
    </tr>
</thead>
<tbody>
    @forelse($banners as $banner)
        <tr id="banner-id-{{ $banner->id }}">
            <td class="font-medium text-gray-500">#{{ $banner->id }}</td>
            <td class="text-center">{{ $banner->order }}</td>
            <td>
                @if($banner->image_path_ru)
                    <img src="{{ asset('storage/' . $banner->image_path_ru) }}" alt="RU" class="h-12 w-auto max-w-[160px] rounded border border-gray-200 object-cover">
                @else
                    <span class="text-gray-300">—</span>
                @endif
            </td>
            <td>
                @if($banner->image_path_ro)
                    <img src="{{ asset('storage/' . $banner->image_path_ro) }}" alt="RO" class="h-12 w-auto max-w-[160px] rounded border border-gray-200 object-cover">
                @else
                    <span class="text-gray-300">—</span>
                @endif
            </td>
            <td>
                @if($banner->active)
                    <x-badge type="success">Активный</x-badge>
                @else
                    <x-badge type="danger">Неактивный</x-badge>
                @endif
            </td>
            <td class="hidden lg:table-cell text-gray-500 max-w-xs truncate">
                @if($banner->link)<a href="{{ $banner->link }}" target="_blank" class="text-brand-600 hover:text-brand-700">{{ $banner->link }}</a>@else—@endif
            </td>
            <td class="text-right">
                <x-table-actions :editUrl="route('banner.edit', $banner)"
                                 :deleteUrl="route('banner.delete') . '?banner_id=' . $banner->id"
                                 :deleteName="'баннер #' . $banner->id" />
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="7">
                <x-empty-state icon="image" title="Баннеры не найдены" text="Добавьте новый баннер для главной страницы." />
            </td>
        </tr>
    @endforelse
</tbody>
