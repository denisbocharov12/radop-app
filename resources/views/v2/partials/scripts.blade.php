{{-- Legacy helpers kept during migration: jQuery ($.ajax), SweetAlert2 --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- Select2 lives in its own isolated initializer (error-isolated + single place
     to control its z-index layer). Included after jQuery, which it depends on. --}}
@include('v2.partials.select2')

@if(Route::has('order.status.last-ten-minutes'))
<script>
    (function () {
        var baseTitle = document.title.replace(/^\(\d+\)\s*/, '');
        function applyToTitle(n) { document.title = (n > 0 ? '(' + n + ') ' : '') + baseTitle; }
        function refresh() {
            $.ajax({
                url: "{{ route('order.status.last-ten-minutes') }}", type: "GET", dataType: "json",
                success: function (data) {
                    var n = (data && typeof data.count !== 'undefined') ? (parseInt(data.count, 10) || 0) : 0;
                    var $b = $('#new_orders');
                    if (n > 0) { $b.text(n).removeClass('hidden'); } else { $b.text('').addClass('hidden'); }
                    applyToTitle(n);
                },
                error: function (xhr, s, e) { console.error('orders counter:', e); }
            });
        }
        window.updateOrdersCounter = refresh;
        document.addEventListener('DOMContentLoaded', function () { refresh(); setInterval(refresh, 20000); });
    })();
</script>
@endif

@stack('scripts')
@yield('scripts')
