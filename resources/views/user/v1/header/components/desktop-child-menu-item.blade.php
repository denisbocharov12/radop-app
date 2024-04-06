<ul class="list child-menu">
    <li class="item"><a href="{{route('user.dashboard')}}" class="link">Мои обьекты</a></li>
    <li class="item"><a href="{{route('user.transaction.index')}}" class="link">История транзакций (Онлайн оплата)</a></li>
    <li class="item"><a href="{{route('user.subscribe.index')}}" class="link">История транзакций (Подписка)</a></li>
{{--    <li class="item"><a href="#" class="link">Мой аккаунт</a></li>--}}

    <li class="item"><a href="{{route('user.logout')}}"  onclick="event.preventDefault();
                                                     document.getElementById('desktop-logout-form').submit();" class="link">Выйти</a>
    </li>
    <form id="desktop-logout-form" action="{{ route('user.logout') }}" method="POST" style="display: none">
        @csrf
    </form>
</ul>
