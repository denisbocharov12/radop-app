{{-- Поиск: событие search с запросом и состав выдачи view_search_results.
     Шлём со страницы результатов — перехват отправки формы терял события,
     потому что браузер уже уходил со страницы. --}}
@php($ga4Search = $ga4Search ?? null)
@if(!empty($ga4Search))
<script>
    $(function () {
        var names = window.radopAnalyticsDataLayerEventNames || {};

        if (typeof window.radopGa4EventPush === 'function' && names.frontend_site_search_submitted) {
            window.radopGa4EventPush(names.frontend_site_search_submitted, {
                search_term: @json($ga4Search['search_term'])
            });
        }

        @if(!empty($ga4Search['ecommerce']))
        if (typeof window.radopGa4EcommercePush === 'function' && names.search_results_viewed) {
            window.radopGa4EcommercePush(names.search_results_viewed, @json($ga4Search['ecommerce']));
        }
        @endif
    });
</script>
@endif
