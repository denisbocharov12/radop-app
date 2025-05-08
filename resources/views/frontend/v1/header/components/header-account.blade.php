<div class="login-registration-block icon-block">
    @php
        $user = Auth::guard('user')->user()
    @endphp

    @if($user)
        <a
            class="icon-block-link"
{{--            data-fancybox--}}
{{--            data-src="#loginModal"--}}
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
