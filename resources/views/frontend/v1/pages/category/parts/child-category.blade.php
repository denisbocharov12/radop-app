<section class="section-standart section-category pt-0 section-category-columns">
    <div class="container">
        <div class="row row-category-childs row-category-childs-by-column">
            @php
                $childrenByColumn = ($existedCategory->childrenOrderedByColumn ?? $existedCategory->children)->groupBy(fn($c) => (int)($c->column ?? 1));
            @endphp
            @for($col = 1; $col <= 3; $col++)
                <div class="col-md-4 col-12 col-lg-4 col-category-childs">
                    <div class="col-category-childs-inner">
                        @foreach($childrenByColumn->get($col, collect()) as $category)
                            <div class="wrap-category-childs">
                                <div class="category-child-header">
                                    <a class="link parent-link" href="{{route('theme.category.index', $category->onec_id)}}">
                                        @if($category->getFirstMediaUrl('media') !== '')
                                            <img src="{{$category->getFirstMediaUrl('media')}}" alt="{{$category->name}}" class="category-child-icon" loading="lazy">
                                        @endif
                                        {{$category->name}}
                                    </a>
                                    @include('frontend.v1.pages.category.parts.export-excel-category-row', ['category' => $category])
                                </div>
                                @include('frontend.v1.pages.category.parts.child-category-list', ['categories' => $category->childrenOrderedByColumn ?? $category->children])
                            </div>
                        @endforeach
                    </div>
                </div>
            @endfor
        </div>
    </div>
</section>
<section class="section-standart section-slider section-brand-slider">
    <div class="container">
        <div class="row">
            <div class="col-12 col-slider">
                <div class="wrap-slider theme-slider" id="partners-slider">
                    @foreach($themeBrands as $brand)
                        <div class="item">
                            <a href="{{route('theme.brand.index', $brand->onec_id)}}">
                                <img src="{{$brand->getFirstMediaUrl('media', 'thumb')}}" alt="{{$brand->title}}" loading="lazy"/>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
