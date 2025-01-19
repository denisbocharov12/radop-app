<span class="sort-label">{{__('theme.sort-label')}}</span>
<div class="sort-options">
    <a href="?sort=popular_order" class="sort-option">{{__('theme.sort-popular')}}</a>
    <a href="?sort=stock" class="sort-option">{{__('theme.sort-stock')}}</a>
    <a href="?sort=created_at" class="sort-option">{{__('theme.sort-new')}}</a>
    <a href="?sort=title" class="sort-option">{{__('theme.sort-title')}}</a>
    <a href="?sort=price" class="sort-option">{{__('theme.sort-price-asc')}}</a>
    <a href="?sort=-price" class="sort-option">{{__('theme.sort-price-desc')}}</a>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sortOptions = document.querySelectorAll('.sort-option');
    const currentUrl = new URL(window.location.href);
    const currentSort = currentUrl.searchParams.get('sort');

    sortOptions.forEach(option => {
        const optionUrl = new URL(option.href);
        const optionSort = optionUrl.searchParams.get('sort');

        if (currentSort === optionSort) {
            option.classList.add('active');
        }

        option.addEventListener('click', function(e) {
            e.preventDefault();
            sortOptions.forEach(opt => opt.classList.remove('active'));
            this.classList.add('active');
            window.location.href = this.href;
        });
    });
});
</script>
</div>