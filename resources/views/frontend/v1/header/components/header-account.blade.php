<div class="login-registration-block icon-block">
    @php
        $user = Auth::guard('user')->user()
    @endphp

    @if($user)
        <a
            class="icon-block-link"
            href="{{route('theme.user.orders.index')}}"
        >
            <span class="theme-text-sp">
                @if($user->type->key_name === "fiz")
                    {{$user->profile->first_name . ' ' . $user->profile->last_name}}
                @else
                    {{$user->profile->organization_name}}
                @endif
            </span>
            <i class="icon-user-radop"></i>
        </a>
        <div class="account-dropdown-menu">
            <ul class="account-dropdown-list">
                <li class="account-dropdown-item">
                    <a class="account-dropdown-link" href="{{route('theme.user.orders.index')}}">
                        <i class="icon-your-order"></i>{{__('theme.my-orders')}}
                    </a>
                </li>
                @if($user->type->key_name === 'iur')
                    <li class="account-dropdown-item">
                        <a class="account-dropdown-link" href="{{route('theme.user.filial.index')}}">
                            <i class="icon-building"></i>{{__('theme.filials')}}
                        </a>
                    </li>
                @endif
                <li class="account-dropdown-item">
                    <a class="account-dropdown-link" href="{{route('theme.user.account.index')}}">
                        <i class="icon-account"></i>{{__('theme.account')}}
                    </a>
                </li>
                <li class="account-dropdown-item">
                    <a class="account-dropdown-link" href="{{route('theme.user.logout')}}">
                        <i class="icon-user"></i>{{__('theme.logout')}}
                    </a>
                </li>
            </ul>
        </div>
    @else
        <a
            class="user icon-block-link"
            data-fancybox
            data-src="#loginModal"
            href="javascript:;"
        >
            <span class="theme-text-sp">
               {{__('theme.login-registration')}}
            </span>
            <i class="icon-user-radop"></i>
        </a>
    @endif
</div>
