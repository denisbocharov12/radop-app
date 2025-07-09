<table style="border-collapse: collapse; width: 100%;">
    <thead>
    <tr></tr>
    <tr>
        <th rowspan="2"></th>
        <th rowspan="2" style="font-weight: 700">№</th>
        <th rowspan="2" style="font-weight: 700">ID</th>
        <th rowspan="2" style="font-weight: 700">{{ __('theme.category-name') }}</th>
        <th rowspan="2" style="font-weight: 700">{{ __('theme.parent-category') }}</th>
        <th rowspan="2" style="font-weight: 700">{{ __('theme.status') }}</th>
        <th rowspan="2" style="font-weight: 700">{{ __('theme.summary') }}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($categories as $index => $category)
        <tr>
            <td></td>
            <td>{{ $index + 1 }}</td>
            <td>{{ $category->onec_id }}</td>
            <td>{{ $category->getTranslation('name', app()->getLocale()) }}</td>
            <td>{{ $category->parent?->getTranslation('name', app()->getLocale()) }}</td>
            <td>{{ $category->status ? __('theme.active') : __('theme.inactive') }}</td>
            <td>{{ $category->getTranslation('summary', app()->getLocale()) }}</td>
        </tr>
    @endforeach
    </tbody>
</table> 