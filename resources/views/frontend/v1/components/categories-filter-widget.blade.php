@if(isset($categories) && $categories->isNotEmpty())
    <li class="theme-toggle-item">
        <div class="theme-toggle-item-title">
            <i class="icon-arrow-filter-radop-left"></i>
            <p class="theme-widget-title">{{ __('theme.categories') }}</p>
        </div>
        <div class="theme-toggle-item-content" style="display: flex; flex-direction: column;">
            <div class="categories-filter-list" style="height: 300px; overflow-y: auto; width: 100%;">
                @foreach($categories as $category)
                    <div class="col-12" style="margin-bottom: 8px;">
                        <a href="{{ route('theme.category.index', $category->onec_id) }}" class="category-link" style="display: flex; justify-content: space-between; align-items: center; text-decoration: none; color: inherit; padding: 4px 0;">
                            <span>{{ $category->name }}</span>
                            <span style="color: #999; font-size: 14px;">({{ $category->products_count ?? 0 }})</span>
                        </a>
                    </div>
                @endforeach
            </div>
            <button type="button" class="categories-toggle-btn" style="margin-top: 10px; width: 100%; padding: 8px; background: transparent; border: 1px solid #ddd; cursor: pointer; border-radius: 4px; color: #333;">
                <span class="toggle-text">{{ __('theme.show-all-categories') }}</span>
            </button>
        </div>
    </li>
@endif

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleBtn = document.querySelector('.categories-toggle-btn');
        const categoriesList = document.querySelector('.categories-filter-list');
        
        if (toggleBtn && categoriesList) {
            let isExpanded = false;
            
            toggleBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                isExpanded = !isExpanded;
                
                if (isExpanded) {
                    categoriesList.style.height = 'auto';
                    categoriesList.style.maxHeight = 'none';
                    toggleBtn.querySelector('.toggle-text').textContent = '{{ __('theme.hide-categories') }}';
                } else {
                    categoriesList.style.height = '300px';
                    categoriesList.style.maxHeight = '300px';
                    toggleBtn.querySelector('.toggle-text').textContent = '{{ __('theme.show-all-categories') }}';
                }
            });
        }
    });
</script>

