<table>
    <tr>
        <td colspan="7" style="text-align: center; font-weight: bold; font-size: 14px;">
            Отчет по просмотрам товаров
        </td>
    </tr>
    <tr>
        <td colspan="7" style="text-align: center;">
            Период: {{ $reportData['period']['start_date'] }} - {{ $reportData['period']['end_date'] }}
        </td>
    </tr>
    <tr></tr>
    <tr>
        <th style="background-color: #f3f3f3; font-weight: bold;">ID</th>
        <th style="background-color: #f3f3f3; font-weight: bold;">Код 1C</th>
        <th style="background-color: #f3f3f3; font-weight: bold;">Название товара</th>
        <th style="background-color: #f3f3f3; font-weight: bold;">Общие просмотры</th>
        <th style="background-color: #f3f3f3; font-weight: bold;">Уникальные просмотры</th>
        <th style="background-color: #f3f3f3; font-weight: bold;">Просмотры за период</th>
        <th style="background-color: #f3f3f3; font-weight: bold;">Точность просмотров</th>
    </tr>
    @foreach($reportData['products'] as $product)
    <tr>
        <td>{{ $product['id'] }}</td>
        <td>{{ $product['onec_id'] ?? '-' }}</td>
        <td style="text-align: left;">{{ $product['title'] }}</td>
        <td>{{ $product['total_views'] }}</td>
        <td>{{ $product['unique_views'] }}</td>
        <td>{{ $product['period_views'] }}</td>
        <td>{{ $product['views_per_unit'] }}</td>
    </tr>
    @endforeach
    <tr></tr>
    <tr>
        <td colspan="3" style="font-weight: bold; text-align: right;">Итого:</td>
        <td style="font-weight: bold;">{{ $reportData['total_views'] }}</td>
        <td style="font-weight: bold;">{{ $reportData['total_unique_views'] }}</td>
        <td colspan="2" style="font-weight: bold;">Товаров: {{ $reportData['count'] }}</td>
    </tr>
</table>

