@php
    $currentSort = request()->query('sort');
    $sortOptions = [
        ['key' => 'price', 'label' => __('theme.sort-price-asc')],
        ['key' => 'price_desc', 'label' => __('theme.sort-price-desc')],
        ['key' => 'title', 'label' => __('theme.sort-title')],
        ['key' => 'popular_order', 'label' => __('theme.sort-popular')],
        ['key' => 'condition', 'label' => __('theme.sort-new')],
        ['key' => 'stock', 'label' => __('theme.sort-stock')],
    ];
    $activeOption = $sortOptions[0];
    foreach ($sortOptions as $option) {
        if ($currentSort === $option['key'] || ($currentSort === '-price' && $option['key'] === 'price_desc')) {
            $activeOption = $option;
            break;
        }
    }
@endphp
<div class="page-sort-block">
    <span class="sort-label d-none d-md-block">{{__('theme.sort-label')}}</span>
    <div class="sort-dropdown d-none d-md-block">
        <button type="button" class="sort-dropdown-toggle">
            <span class="sort-option active">{{$activeOption['label']}}</span>
        </button>
        <div class="sort-dropdown-menu">
            @foreach($sortOptions as $option)
                @if($option['key'] !== $activeOption['key'])
                    <a href="#" class="sort-option" data-sort="{{$option['key']}}">{{$option['label']}}</a>
                @endif
            @endforeach
        </div>
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
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dropdown = document.querySelector('.sort-dropdown');
        const toggle = dropdown.querySelector('.sort-dropdown-toggle');
        const menu = dropdown.querySelector('.sort-dropdown-menu');
        const options = menu.querySelectorAll('.sort-option');
        let opened = false;
        function openMenu() {
            menu.style.display = 'block';
            opened = true;
        }
        function closeMenu() {
            menu.style.display = 'none';
            opened = false;
        }
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            if (opened) {
                closeMenu();
            } else {
                openMenu();
            }
        });
        document.addEventListener('click', function(e) {
            if (!dropdown.contains(e.target)) {
                closeMenu();
            }
        });
        options.forEach(option => {
            option.addEventListener('click', function(e) {
                e.preventDefault();
                const sort = this.getAttribute('data-sort');
                const url = new URL(window.location.href);
                url.searchParams.set('sort', sort === 'price_desc' ? '-price' : sort);
                window.location.href = url.toString();
            });
        });
    });
</script>
