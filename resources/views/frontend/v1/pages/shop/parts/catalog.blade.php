<section class="section-standart section-page-catalog">
    <div class="container">
        <div class="row row-header-catalog">
            @if(!empty($themeParentCategories))
                @foreach($themeParentCategories as $parentCategory)
                    @include('frontend.v1.header.components.header-catalog-item', $parentCategory)
                @endforeach
            @endif
        </div>
    </div>
</section>
