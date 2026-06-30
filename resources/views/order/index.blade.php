@extends('v2.layouts.app')

@section('title', 'Заказы')
@section('breadcrumb')<span class="text-gray-700">Заказы</span>@endsection

@section('content')
    @php $bulkUrl = \Illuminate\Support\Facades\Route::has('order.orders.update-statuses') ? route('order.orders.update-statuses') : ''; @endphp

    <x-page-header title="Заказы" description="Всего заказов: {{ $orders->total() }}" />

    @if($errors->any())
        <x-alert type="error" class="mb-4">
            <ul class="list-disc list-inside space-y-0.5">
                @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
            </ul>
        </x-alert>
    @endif

    <div class="card">
        @include('order.table.head')
        <div class="table-wrap">
            <table class="data-table" id="orders-table">
                @include('order.table.content')
            </table>
        </div>
        @include('order.table.footer')
    </div>

    @include('order.modal.add_manager')
@endsection

@section('scripts')
<script>
    $(function () {
        var bulkUrl = @json($bulkUrl);

        // Select-all sync (header + toolbar checkboxes)
        $('#select-all-orders, #select-all-orders-head').on('change', function () {
            var checked = $(this).is(':checked');
            $('.order-checkbox').prop('checked', checked);
            $('#select-all-orders, #select-all-orders-head').prop('checked', checked);
        });
        $(document).on('change', '.order-checkbox', function () {
            var all = $('.order-checkbox').length, sel = $('.order-checkbox:checked').length;
            $('#select-all-orders, #select-all-orders-head').prop('checked', all > 0 && sel === all);
        });

        // Bulk status update
        $('#bulk-status-update-btn').on('click', function (e) {
            e.preventDefault();
            if (!bulkUrl) { Swal.fire('Недоступно', 'Массовое изменение статуса недоступно', 'info'); return; }
            var ids = $('.order-checkbox:checked').map(function () { return $(this).val(); }).get();
            var status = $('#bulk-status-select').val();
            if (!ids.length) { Swal.fire('Ошибка', 'Выберите хотя бы один заказ', 'error'); return; }
            if (!status) { Swal.fire('Ошибка', 'Выберите статус', 'error'); return; }
            $.ajax({
                url: bulkUrl, type: "POST",
                data: { order_ids: ids, status: status, _token: "{{ csrf_token() }}" },
                success: function () {
                    Swal.fire({ title: 'Готово', text: 'Статус обновлён', icon: 'success', timer: 1500, showConfirmButton: false });
                    setTimeout(function () { location.reload(); }, 1500);
                },
                error: function (xhr) {
                    Swal.fire('Ошибка', (xhr.responseJSON && xhr.responseJSON.error) ? xhr.responseJSON.error : 'Произошла ошибка', 'error');
                }
            });
        });

        // Filter panel toggle
        var ft = document.getElementById('filter-toggle'), fp = document.getElementById('filter-panel');
        if (ft && fp) {
            ft.addEventListener('click', function (e) {
                e.preventDefault();
                fp.style.display = (fp.style.display === 'none' || !fp.style.display) ? 'block' : 'none';
            });
        }

        // "Only my orders" client-side filter (managers)
        var fos = document.getElementById('filterOrdersSwitch');
        if (fos) {
            fos.addEventListener('change', function () {
                var myId = "{{ $user->id }}", checked = fos.checked;
                document.querySelectorAll('#orders-table tbody tr[data-manager-id]').forEach(function (row) {
                    var mid = row.getAttribute('data-manager-id');
                    row.style.display = (checked && String(mid) !== String(myId)) ? 'none' : '';
                });
            });
        }
    });
</script>
@endsection
