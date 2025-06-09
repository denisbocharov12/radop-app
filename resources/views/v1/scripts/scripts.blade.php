<!-- JavaScript -->
<script src="{{asset('/v1/dashboard')}}/assets/js/bundle.js?ver=3.0.0"></script>
<script src="{{asset('/v1/dashboard')}}/assets/js/scripts.js?ver=3.0.0"></script>

<script>
function updateOrdersCounter() {
    $.ajax({
        url: "{{ route('order.status.last-ten-minutes') }}",
        type: "GET",
        dataType: "json",
        success: function(data) {
            if (data.count > 0) {
                $('#new_orders').text(data.count);
            }
        },
        error: function(xhr, status, error) {
            console.error("Error fetching orders counter:", error);
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    updateOrdersCounter();
    setInterval(updateOrdersCounter, 20000);
});
</script>

@yield('scripts')
