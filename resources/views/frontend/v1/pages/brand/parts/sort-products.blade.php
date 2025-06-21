<span class="sort-label d-none d-md-block">{{__('theme.sort-label')}}</span>
<div class="sort-options d-none d-md-block">
    <a href="#" class="sort-option default-option" data-sort="price">{{__('theme.sort-price-asc')}}</a>
    <a href="#" class="sort-option" data-sort="price_desc">{{__('theme.sort-price-desc')}}</a>
    <a href="#" class="sort-option" data-sort="title">{{__('theme.sort-title')}}</a>
    <a href="#" class="sort-option" data-sort="popular_order">{{__('theme.sort-popular')}}</a>
    <a href="#" class="sort-option" data-sort="condition">{{__('theme.sort-new')}}</a>
    <a href="#" class="sort-option" data-sort="stock">{{__('theme.sort-stock')}}</a>
</div>
<div class="sort-per-page d-none d-md-block">
    <form class="form-sort-per-page" id="form-sort-per-page" action="{{route('theme.brand.index', $existedBrand->onec_id)}}" method="GET">
        <select name="perPage" id="perPage" class="js2-select select-sort-per-page">
            <option value="24" {{request()->has('perPage') && request()->query('perPage') !== null && (int)request()->query('perPage') === 24 ? 'selected': ''}}>24</option>
            <option value="48" {{request()->has('perPage') && request()->query('perPage') !== null && (int)request()->query('perPage') === 48 ? 'selected': ''}}>48</option>
            <option value="72" {{request()->has('perPage') && request()->query('perPage') !== null && (int)request()->query('perPage') === 72 ? 'selected': ''}}>72</option>
            <option value="96" {{request()->has('perPage') && request()->query('perPage') !== null && (int)request()->query('perPage') === 96 ? 'selected': ''}}>96</option>
        </select>
    </form>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sortOptions = document.querySelectorAll('.sort-option');
        const currentUrl = new URL(window.location.href);
        const currentSort = currentUrl.searchParams.get('sort');

        function updateUrlWithParams(params) {
            const url = new URL(window.location.href);
            for (const [key, value] of Object.entries(params)) {
                if (value) {
                    url.searchParams.set(key, value);
                } else {
                    url.searchParams.delete(key);
                }
            }
            return url.toString();
        }

        function applySort(sort) {
            const newUrl = updateUrlWithParams({ sort: sort });
            window.location.href = newUrl;
        }

        sortOptions.forEach(option => {
            const optionSort = option.getAttribute('data-sort');

            if (currentSort === optionSort || (currentSort === '-price' && optionSort === 'price_desc')) {
                option.classList.add('active');
            }

            if (currentSort === null) {
                document.querySelector('.default-option').classList.add('active');
            }

            option.addEventListener('click', function(e) {
                e.preventDefault();
                sortOptions.forEach(opt => opt.classList.remove('active'));
                this.classList.add('active');
                const sort = this.getAttribute('data-sort');
                applySort(sort === 'price_desc' ? '-price' : sort);
            });
        });
    });
</script>
