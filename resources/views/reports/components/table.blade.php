<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>№</th>
                <th>ID</th>
                <th>Клиент</th>
                <th>Дата</th>
                <th>Город</th>
                <th>Филиал</th>
                <th>Сумма</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($reportData['orders']) && count($reportData['orders']) > 0)
                @foreach($reportData['orders'] as $order)
                    <tr>
                        <td>{{ $order['number'] }}</td>
                        <td>{{ $order['id'] }}</td>
                        <td>{{ $order['client'] }}</td>
                        <td>{{ $order['date'] }}</td>
                        <td>{{ $order['city'] }}</td>
                        <td>{{ $order['filial'] }}</td>
                        <td>{{ number_format($order['sum'] / 100, 2, ',', ' ') }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="7" class="text-center">Нет данных для отображения</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
