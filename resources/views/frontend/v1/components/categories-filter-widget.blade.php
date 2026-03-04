@if(isset($categories) && $categories->isNotEmpty())
    <li class="theme-toggle-item">
        <div class="theme-toggle-item-title">
            <i class="icon-arrow-radop-left theme-filter-arrow"></i>
            <p class="theme-widget-title">{{ __('theme.categories') }}</p>
        </div>
        <div class="theme-toggle-item-content categories-filter-content" style="display: flex">
            <div class="categories-filter-list">
                @php
                    $categoriesByName = $categories->groupBy('name');
                @endphp
                @foreach($categoriesByName as $name => $group)
                    <div class="category-filter-item">
                        <a href="javascript:void(0);"
                           class="category-filter-link"
                           data-category-id="{{ $group->pluck('onec_id')->implode(',') }}"
                           data-page-type="{{ $pageType ?? 'shop' }}"
                           data-page-sub-type="{{ $pageSubType ?? '' }}"
                           data-brand-onec-id="{{ $brandOnecId ?? '' }}">
                            <span>{{ $name }}</span>
                            <span class="category-filter-count">({{ $group->sum('products_count') }})</span>
                        </a>
                    </div>
                @endforeach
            </div>
            <button type="button" class="categories-toggle-btn">
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

        function buildFormData(categoryId, page) {
            const formData = new FormData();
            formData.append('category_id', categoryId);
            formData.append('_token', '{{ csrf_token() }}');
            if (page) {
                formData.append('page', page);
            }

            const currentUrl = new URL(window.location.href);
            const urlParams = currentUrl.searchParams;

            urlParams.forEach(function(value, key) {
                if (key.startsWith('filter[')) {
                    formData.append(key, value);
                } else if (key === 'filter' && typeof value === 'string') {
                    try {
                        const filterObj = JSON.parse(decodeURIComponent(value));
                        Object.keys(filterObj).forEach(function(filterKey) {
                            if (Array.isArray(filterObj[filterKey])) {
                                filterObj[filterKey].forEach(function(val) {
                                    formData.append('filter[' + filterKey + '][]', val);
                                });
                            } else if (typeof filterObj[filterKey] === 'object' && filterObj[filterKey] !== null) {
                                Object.keys(filterObj[filterKey]).forEach(function(subKey) {
                                    formData.append('filter[' + filterKey + '][' + subKey + ']', filterObj[filterKey][subKey]);
                                });
                            } else {
                                formData.append('filter[' + filterKey + ']', filterObj[filterKey]);
                            }
                        });
                    } catch (e) {
                        formData.append('filter', value);
                    }
                } else if (key !== 'category_id' && key !== 'page') {
                    formData.append(key, value);
                }
            });

            return formData;
        }

        function getAjaxUrl(pageType, pageSubType, brandOnecId) {
            if (pageType === 'brand' && brandOnecId) {
                return '{{ route("theme.brand.filter-by-category", ":onecId") }}'.replace(':onecId', brandOnecId);
            } else if (pageType === 'shop' && pageSubType) {
                return '{{ route("theme.shop.filter-by-category", ":type") }}'.replace(':type', pageSubType);
            } else {
                return '{{ route("theme.shop.filter-by-category", "all") }}';
            }
        }

        function updateUI(data) {
            const tableView = document.getElementById('productsTableView');
            const listView = document.getElementById('productsListView');
            const listViewMobile = document.getElementById('productsListViewMobile');

            if (tableView) {
                tableView.innerHTML = data.tableView || '';
                tableView.style.opacity = '1';
            }
            if (listView) {
                listView.innerHTML = data.listView || '';
                listView.style.opacity = '1';
            }
            if (listViewMobile) {
                listViewMobile.innerHTML = data.listView || '';
            }

            const hasPages = (data.hasPages === true) || (data.pagination && data.pagination.trim() !== '');

            if (hasPages && data.pagination) {
                const paginationContainers = document.querySelectorAll('.theme-pagination');
                paginationContainers.forEach(function(container) {
                    if (container) {
                        container.innerHTML = data.pagination;
                    }
                });

                const topPaginationContainer = document.querySelector('.sort-block');
                if (topPaginationContainer) {
                    let topPagination = topPaginationContainer.querySelector('.theme-pagination');
                    if (!topPagination) {
                        topPagination = document.createElement('div');
                        topPagination.className = 'theme-pagination d-none d-lg-block';
                        topPaginationContainer.appendChild(topPagination);
                    }
                    topPagination.innerHTML = data.pagination;
                }
            } else {
                const paginationContainers = document.querySelectorAll('.theme-pagination');
                paginationContainers.forEach(function(container) {
                    if (container) {
                        container.innerHTML = '';
                    }
                });

                const topPaginationContainer = document.querySelector('.sort-block');
                if (topPaginationContainer) {
                    const topPagination = topPaginationContainer.querySelector('.theme-pagination');
                    if (topPagination) {
                        topPagination.remove();
                    }
                }
            }
        }

        function showLoading() {
            const tableView = document.getElementById('productsTableView');
            const listView = document.getElementById('productsListView');
            const listViewMobile = document.getElementById('productsListViewMobile');

            if (tableView) {
                tableView.style.opacity = '0.5';
            }
            if (listView) {
                listView.style.opacity = '0.5';
            }
            if (listViewMobile) {
                listViewMobile.style.opacity = '0.5';
            }
        }

        function hideLoading() {
            const tableView = document.getElementById('productsTableView');
            const listView = document.getElementById('productsListView');
            const listViewMobile = document.getElementById('productsListViewMobile');

            if (tableView) {
                tableView.style.opacity = '1';
            }
            if (listView) {
                listView.style.opacity = '1';
            }
            if (listViewMobile) {
                listViewMobile.style.opacity = '1';
            }
        }

        function closeFilterModal() {
            const modalElement = document.getElementById('filtersModal');
            if (!modalElement) {
                return;
            }

            if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                const modal = bootstrap.Modal.getInstance(modalElement);
                if (modal) {
                    modal.hide();
                } else {
                    const bsModal = new bootstrap.Modal(modalElement);
                    bsModal.hide();
                }
            } else if (window.$ && $.fancybox) {
                $.fancybox.close();
            } else {
                modalElement.style.display = 'none';
                modalElement.classList.remove('show');
                document.body.classList.remove('modal-open');
                const backdrop = document.querySelector('.modal-backdrop');
                if (backdrop) {
                    backdrop.remove();
                }
            }
        }

        function performAjaxRequest(url, formData, updateUrl, signal) {
            showLoading();

            const fetchOptions = {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                }
            };

            if (signal) {
                fetchOptions.signal = signal;
            }

            return fetch(url, fetchOptions)
            .then(response => {
                if (signal && signal.aborted) {
                    throw new Error('Request aborted');
                }
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (signal && signal.aborted) {
                    return;
                }
                if (data.success) {
                    updateUI(data);
                    if (updateUrl) {
                        const newUrl = new URL(window.location.href);
                        if (updateUrl.page) {
                            newUrl.searchParams.set('page', updateUrl.page);
                        } else {
                            newUrl.searchParams.delete('page');
                        }
                        if (updateUrl.categoryId) {
                            newUrl.searchParams.set('filter[category]', updateUrl.categoryId);
                        }
                        window.history.pushState({}, '', newUrl.toString());
                    }
                    hideLoading();
                    
                    setTimeout(function() {
                        closeFilterModal();
                    }, 100);
                } else {
                    console.error('Server error:', data.message || 'Unknown error');
                    hideLoading();
                }
                return data;
            })
            .catch(error => {
                if (signal && signal.aborted) {
                    hideLoading();
                    return;
                }
                console.error('Error:', error);
                hideLoading();
                if (error.name !== 'AbortError') {
                    alert('Произошла ошибка при загрузке данных. Пожалуйста, попробуйте еще раз.');
                }
                throw error;
            });
        }

        let isRequestInProgress = false;
        let currentRequestAbortController = null;

        function initCategoryFilters() {
            const links = document.querySelectorAll('.category-filter-link');
            
            links.forEach(function(link) {
                link.removeEventListener('click', handleCategoryClick);
                link.addEventListener('click', handleCategoryClick);
            });
        }

        function handleCategoryClick(e) {
            e.preventDefault();
            e.stopPropagation();

            if (isRequestInProgress) {
                return;
            }

            const categoryId = this.getAttribute('data-category-id');
            const pageType = this.getAttribute('data-page-type');
            const pageSubType = this.getAttribute('data-page-sub-type');
            const brandOnecId = this.getAttribute('data-brand-onec-id');

            if (!categoryId) {
                return;
            }

            if (this.classList.contains('active')) {
                return;
            }

            document.querySelectorAll('.category-filter-link').forEach(function(l) {
                l.classList.remove('active');
            });
            this.classList.add('active');

            if (currentRequestAbortController) {
                currentRequestAbortController.abort();
            }

            isRequestInProgress = true;
            currentRequestAbortController = new AbortController();

            const url = getAjaxUrl(pageType, pageSubType, brandOnecId);
            const formData = buildFormData(categoryId, '1');

            performAjaxRequest(url, formData, { page: '1', categoryId: categoryId }, currentRequestAbortController.signal)
                .finally(function() {
                    isRequestInProgress = false;
                    currentRequestAbortController = null;
                });
        }

        initCategoryFilters();

        function handlePaginationClick(e) {
            const link = e.target.closest('a');
            if (!link || !link.href) {
                return;
            }

            e.preventDefault();
            e.stopPropagation();

            let page = null;
            try {
                let href = link.href;
                if (href.startsWith('/')) {
                    href = window.location.origin + href;
                }
                const url = new URL(href);
                page = url.searchParams.get('page');
            } catch (err) {
                const hrefMatch = link.href.match(/[?&]page=(\d+)/);
                if (hrefMatch) {
                    page = hrefMatch[1];
                }
            }

            if (!page) {
                return;
            }

            const activeCategoryLink = document.querySelector('.category-filter-link.active');
            if (!activeCategoryLink) {
                window.location.href = link.href;
                return;
            }

            const categoryId = activeCategoryLink.getAttribute('data-category-id');
            const pageType = activeCategoryLink.getAttribute('data-page-type');
            const pageSubType = activeCategoryLink.getAttribute('data-page-sub-type');
            const brandOnecId = activeCategoryLink.getAttribute('data-brand-onec-id');

            if (!categoryId) {
                window.location.href = link.href;
                return;
            }

            if (isRequestInProgress) {
                return;
            }

            if (currentRequestAbortController) {
                currentRequestAbortController.abort();
            }

            isRequestInProgress = true;
            currentRequestAbortController = new AbortController();

            const ajaxUrl = getAjaxUrl(pageType, pageSubType, brandOnecId);
            const formData = buildFormData(categoryId, page);

            performAjaxRequest(ajaxUrl, formData, { page: page, categoryId: categoryId }, currentRequestAbortController.signal)
                .finally(function() {
                    isRequestInProgress = false;
                    currentRequestAbortController = null;
                });
        }

        document.addEventListener('click', function(e) {
            if (e.target.closest('.theme-pagination a')) {
                handlePaginationClick(e);
            }
        });
    });
</script>
