<section class="section-standart section-category pt-0">
    <div class="container">
        <div class="row row-category-childs">
            @php
                $childrenByColumn = ($existedCategory->childrenOrderedByColumn ?? $existedCategory->children)->groupBy(fn($c) => $c->column ?? 1);
            @endphp
            @for($col = 1; $col <= 3; $col++)
                <div class="col-md-4 col-12 col-lg-4 col-category-childs">
                    @foreach($childrenByColumn->get($col, collect()) as $category)
                        <div class="wrap-category-childs">
                            <a class="link parent-link" href="{{route('theme.category.index', $category->onec_id)}}">
                                @if($category->getFirstMediaUrl('media') !== '')
                                    <img src="{{$category->getFirstMediaUrl('media')}}" alt="{{$category->name}}" style="width: 32px; height: 32px; margin-right: 5px">
                                @endif
                                {{$category->name}}
                            </a>
                            @include('frontend.v1.pages.category.parts.child-category-list', ['categories' => $category->childrenOrderedByColumn ?? $category->children])
                        </div>
                    @endforeach
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
