<div class="login-registration-block icon-block">
    @php
        $user = Auth::guard('user')->user()
    @endphp

    @if($user)
        <a
            class="user icon-block-link"
            data-fancybox
            data-src="#loginModal"
            href="javascript:;"
        >
            @if($user->type->key_name === "fiz")
                {{$user->profile->first_name . ' ' . $user->profile->last_name}}
            @else
                {{$user->profile->organization_name}}
            @endif
            <i class="icon-user-radop"></i>
        </a>
    @else
        <a
            class="user icon-block-link"
            data-fancybox
            data-src="#loginModal"
            href="javascript:;"
        >
            {{__('theme.login-registration')}}
            <i class="icon-user-radop"></i>
        </a>
    @endif
</div>
