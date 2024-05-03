<ul class="my-account__selects my-account-selects">
    <li class="my-account-selects__item">
        <a
            class="my-account-selects__link"
            href="{{route('theme.account.index')}}"
        >
            <i class="icon-account"></i>Аккаунт</a
        >
    </li>
{{--    <li class="my-account-selects__item">--}}
{{--        <a class="my-account-selects__link" href="#">--}}
{{--            <i class="icon-location-1"></i>Мои адреса--}}
{{--        </a>--}}
{{--    </li>--}}
    <li class="my-account-selects__item">
        <a class="my-account-selects__link" href="{{route('theme.orders.index')}}"
        ><i class="icon-your-order"></i>Мои заказы</a
        >
    </li>
{{--    <li class="my-account-selects__item">--}}
{{--        <a class="my-account-selects__link" href="#"--}}
{{--        ><i class="icon-settings"></i>Настройки</a--}}
{{--        >--}}
{{--    </li>--}}
</ul>
@section('scripts')
    <script>
        $(document).ready(function(){
            // Получаем текущий URL страницы
            var currentUrl = window.location.href;

            // Проверяем каждую ссылку на совпадение с текущим URL
            $('.my-account-selects__link').each(function(){
                // Если атрибут href ссылки совпадает с текущим URL, добавляем класс активной ссылки
                if ($(this).attr('href') === currentUrl) {
                    $(this).addClass('my-account-selects__link--active');
                }
            });
        });
    </script>
@endsection
