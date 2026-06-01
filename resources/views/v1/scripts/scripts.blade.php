<!-- JavaScript -->
<script src="{{asset('/v1/dashboard')}}/assets/js/bundle.js?ver=3.0.0"></script>
<script src="{{asset('/v1/dashboard')}}/assets/js/scripts.js?ver=3.0.0"></script>

<script>
(function () {
    // Preserve the original tab title and strip any "(N) " prefix we may have
    // added previously, so the base title stays clean across updates.
    var baseTitle = document.title.replace(/^\(\d+\)\s*/, '');

    // Mail-style: show the number of new orders in the browser tab title,
    // and clear it again when there are none.
    function applyOrdersToTitle(count) {
        document.title = (count > 0 ? '(' + count + ') ' : '') + baseTitle;
    }

    function updateOrdersCounter() {
        $.ajax({
            url: "{{ route('order.status.last-ten-minutes') }}",
            type: "GET",
            dataType: "json",
            success: function (data) {
                var count = (data && typeof data.count !== 'undefined')
                    ? (parseInt(data.count, 10) || 0)
                    : 0;

                if (count > 0) {
                    $('#new_orders').text(count);
                }

                applyOrdersToTitle(count);
            },
            error: function (xhr, status, error) {
                console.error("Error fetching orders counter:", error);
            }
        });
    }

    // Expose for any other callers that may trigger a manual refresh.
    window.updateOrdersCounter = updateOrdersCounter;

    document.addEventListener('DOMContentLoaded', function () {
        updateOrdersCounter();
        setInterval(updateOrdersCounter, 20000);
    });
})();
</script>

@yield('scripts')
