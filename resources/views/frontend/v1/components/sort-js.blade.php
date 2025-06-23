<script>
    document.addEventListener('DOMContentLoaded', function() {
        if(window.innerWidth <= 768) {
            // per-page
            var selected = document.getElementById('mobilePerPageSelected');
            var modal = document.getElementById('mobilePerPageModal');
            var options = document.querySelectorAll('.mobile-per-page-option');
            var current = {{$products->perPage()}};
            function getText(val) {
                if(val == 24) return '24 {{ __('theme.sort-product') }}';
                if(val == 48) return '48 {{ __('theme.sort-products') }}';
                if(val == 72) return '72 {{ __('theme.sort-product') }}';
                if(val == 96) return '96 {{ __('theme.sort-products') }}';
                return val + ' {{ __('theme.sort-products') }}';
            }
            options.forEach(function(opt){
                if(parseInt(opt.dataset.value) === current) opt.classList.add('active');
            });
            selected.innerHTML = getText(current) + ' <span class="arrow">&#9660;</span>';
            selected.addEventListener('click', function(e) {
                e.stopPropagation();
                modal.style.display = 'block';
            });
            options.forEach(function(opt){
                opt.addEventListener('click', function(){
                    var val = this.dataset.value;
                    var url = new URL(window.location.href);
                    url.searchParams.set('perPage', val);
                    window.location.href = url.toString();
                });
            });
            document.addEventListener('click', function(e){
                if(modal.style.display === 'block') {
                    if (!modal.contains(e.target) && e.target !== selected) {
                        modal.style.display = 'none';
                    }
                }
            });
            modal.addEventListener('click', function(e){
                e.stopPropagation();
            });
            // sort
            var sortSelected = document.getElementById('mobileSortSelected');
            var sortModal = document.getElementById('mobileSortModal');
            var sortOptions = document.querySelectorAll('.mobile-sort-option');
            var urlSort = new URL(window.location.href);
            var currentSort = urlSort.searchParams.get('sort');
            function getSortText(sort) {
                if(!sort) return '{{__('theme.sort-price-desc')}}';
                if(sort === 'price') return '{{__('theme.sort-price-asc')}}';
                if(sort === 'price_desc') return '{{__('theme.sort-price-desc')}}';
                if(sort === 'title') return '{{__('theme.sort-title')}}';
                if(sort === 'popular_order') return '{{__('theme.sort-popular')}}';
                if(sort === 'condition') return '{{__('theme.sort-new')}}';
                if(sort === 'stock') return '{{ __('theme.sort-stock') }}';
                return '{{__('theme.sort-price-asc')}}';
            }
            // выделяем активный и отображаем выбранный вариант
            var found = false;
            sortOptions.forEach(function(opt){
                var optSort = opt.getAttribute('data-sort');
                if((!currentSort && optSort === 'price') || (currentSort === optSort) || (currentSort === '-price' && optSort === 'price_desc')) {
                    opt.classList.add('active');
                    sortSelected.innerHTML = getSortText(optSort) + ' <span class="arrow">&#9650;</span>';
                    found = true;
                }
            });
            if (!found) {
                sortSelected.innerHTML = getSortText(currentSort) + ' <span class="arrow">&#9650;</span>';
            }
            sortSelected.addEventListener('click', function(e) {
                e.stopPropagation();
                sortModal.style.display = 'block';
            });
            sortOptions.forEach(function(opt){
                opt.addEventListener('click', function(){
                    var sort = this.getAttribute('data-sort');
                    var url = new URL(window.location.href);
                    if(sort === 'price_desc') {
                        url.searchParams.set('sort', '-price');
                    } else {
                        url.searchParams.set('sort', sort);
                    }
                    window.location.href = url.toString();
                });
            });
            document.addEventListener('click', function(e){
                if(sortModal.style.display === 'block') {
                    if (!sortModal.contains(e.target) && e.target !== sortSelected) {
                        sortModal.style.display = 'none';
                    }
                }
            });
            sortModal.addEventListener('click', function(e){
                e.stopPropagation();
            });
        }
    });
</script>