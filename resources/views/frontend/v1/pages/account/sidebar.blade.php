<ul class="my-account__selects my-account-selects">
    <li class="my-account-selects__item">
        <a class="my-account-selects__link" href="{{route('theme.user.account.index')}}">
            <i class="icon-account"></i>{{__('theme.account')}}
        </a>
    </li>
    <li class="my-account-selects__item">
        <a class="my-account-selects__link" href="{{route('theme.user.orders.index')}}">
            <i class="icon-your-order"></i>{{__('theme.my-orders')}}
        </a>
    </li>
    <li class="my-account-selects__item">
        <a class="my-account-selects__link" href="{{route('theme.user.coupon.index')}}">
            <i class="icon-percent"></i>{{__('theme.my-coupons')}}
        </a>
    </li>
    <li class="my-account-selects__item">
        <a class="my-account-selects__link" href="{{route('theme.user.logout')}}">
            <i class="icon-user"></i>{{__('theme.logout')}}
        </a>
    </li>
</ul>
@section('scripts')
    <script>
        $(document).ready(function () {
            // Получаем текущий URL страницы
            var currentUrl = window.location.href;

            // Проверяем каждую ссылку на совпадение с текущим URL
            $('.my-account-selects__link').each(function () {
                // Если атрибут href ссылки совпадает с текущим URL, добавляем класс активной ссылки
                if ($(this).attr('href') === currentUrl) {
                    $(this).addClass('my-account-selects__link--active');
                }
            });
        });
    </script>
@endsection
