<section class="section-standart section-page-catalog">
    <div class="container">
        <div class="row row-header-catalog">
            @if(!empty($themeParentCategories))
                @php
                    $byColumn = $themeParentCategories->groupBy(fn($c) => $c->column ?? 1);
                @endphp
                @for($col = 1; $col <= 3; $col++)
                    <div class="col-4 col-list-content">
                        @foreach($byColumn->get($col, collect()) as $parentCategory)
                            @include('frontend.v1.header.components.header-catalog-item', ['parentCategory' => $parentCategory, 'noColumnWrap' => true])
                        @endforeach
                    </div>
                @endfor
            @endif
        </div>
    </div>
</section>
