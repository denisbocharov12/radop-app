<div class="wishlist-block icon-block">
    <a href="{{route('theme.wishlist.index')}}" class="wishlist icon-block-link">
{{--        <span class="theme-text-sp">--}}
{{--            {{__('theme.wishlist')}}--}}
{{--        </span>--}}
        <i class="icon-heart-radop"><span class="wishlist_count" id="wishlist_count" @if(app('wishlist')->getContent()->count() == 0) style="display:none"@endif>{{app('wishlist')->getContent()->count()}}</span></i>
    </a>
</div>
