<div class="card-inner">
    {{$orders->appends(request()->except('page'))->links()}}
</div><!-- .card-inner -->
