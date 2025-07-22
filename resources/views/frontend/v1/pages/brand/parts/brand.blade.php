<section class="section-standart section-sort">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="sort-block">
                    <div class="view-mode-switch">
                        <button id="viewTable" class="btn btn-light me-2 active" type="button"><i class="fa fa-th"></i> Таблица</button>
                        <button id="viewList" class="btn btn-light" type="button"><i class="fa fa-list"></i> Список</button>
                    </div>
                    @include('frontend.v1.pages.brand.parts.sort-products')
                </div>
            </div>
        </div>
    </div>
</section>
@include('frontend.v1.components.show-filter-button')
<section class="section-standart section-category pt-0">
    <div class="container">
        <div class="row row-category-list">
                <div class="col-12 col-md-3 col-theme-filters d-none d-md-block">
                    @include('frontend.v1.pages.brand.parts.brand-filter-form')
                </div>
                <div class="col-md-9 col-12 col-theme-content">
                    <div id="mobile-sort-block" class="mobile-sort-block">
                        <span class="mobile-sort-label">{{__('theme.sort-label')}}</span>
                        <span class="mobile-sort-selected" id="mobileSortSelected"></span>
                    </div>
                    <div id="mobileSortModal" class="mobile-sort-modal">
                        <div class="mobile-sort-modal-content">
                            <div class="mobile-sort-option default-option" data-sort="price">{{ __('theme.sort-price-asc') }}</div>
                            <div class="mobile-sort-option" data-sort="price_desc">{{ __('theme.sort-price-desc') }}</div>
                            <div class="mobile-sort-option" data-sort="title">{{ __('theme.sort-title') }}</div>
                            <div class="mobile-sort-option" data-sort="popular_order">{{ __('theme.sort-popular') }}</div>
                            <div class="mobile-sort-option" data-sort="condition">{{ __('theme.sort-new') }}</div>
                            <div class="mobile-sort-option" data-sort="stock">{{ __('theme.sort-stock') }}</div>
                        </div>
                    </div>
                    <div id="productsTableView" class="{{$products->isEmpty() ? 'row' : 'grid-products-list-wrap'}}">
                        @include('frontend.v1.pages.brand.parts.list')
                    </div>
                    <div id="productsListView" style="display:none;">
                        @include('frontend.v1.pages.brand.parts.list-view')
                    </div>
                    <div id="mobile-per-page-block" class="mobile-per-page-block">
                        <div class="mobile-per-page-selected" id="mobilePerPageSelected">{{$products->perPage()}} товаров <span class="arrow">&#9660;</span></div>
                    </div>
                    <div id="mobilePerPageModal" class="mobile-per-page-modal">
                        <div class="mobile-per-page-modal-content">
                            <div class="mobile-per-page-option" data-value="24">24 {{ __('theme.sort-product') }}</div>
                            <div class="mobile-per-page-option" data-value="48">48 {{ __('theme.sort-products') }}</div>
                            <div class="mobile-per-page-option" data-value="72">72 {{ __('theme.sort-product') }}</div>
                            <div class="mobile-per-page-option" data-value="96">96 {{ __('theme.sort-products') }}</div>
                        </div>
                    </div>
                    <div class="theme-pagination">
                        {{$products->links()}}
                    </div>
                </div>
        </div>
    </div>
    @include('frontend.v1.pages.brand.parts.brand-filter-modal')
</section>
@include('frontend.v1.components.sort-js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const btnTable = document.getElementById('viewTable');
        const btnList = document.getElementById('viewList');
        const tableView = document.getElementById('productsTableView');
        const listView = document.getElementById('productsListView');
        function setViewMode(mode) {
            if (mode === 'list') {
                tableView.style.display = 'none';
                listView.style.display = '';
                btnList.classList.add('active');
                btnTable.classList.remove('active');
            } else {
                tableView.style.display = '';
                listView.style.display = 'none';
                btnTable.classList.add('active');
                btnList.classList.remove('active');
            }
            localStorage.setItem('brandViewMode', mode);
        }
        btnTable.addEventListener('click', function() { setViewMode('table'); });
        btnList.addEventListener('click', function() { setViewMode('list'); });
        const savedMode = localStorage.getItem('brandViewMode');
        if (savedMode === 'list') {
            setViewMode('list');
        }
    });
</script>
