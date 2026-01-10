@if(isset($pageSubType))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const pageSubType = '{{ $pageSubType }}';
        const ajaxUrl = '{{ route("theme.shop.filter", ":type") }}'.replace(':type', pageSubType);
        let debounceTimer = null;
        let currentPage = 1;
        let hasMorePages = true;
        let isLoading = false;
        let infiniteScrollObserver = null;
        const debounceDelay = 500;

        function buildFilterFormData() {
            const formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}');
            
            const form = document.getElementById('filterForm');
            if (!form) {
                return formData;
            }
            
            const checkboxes = form.querySelectorAll('.theme-checkbox:checked');
            checkboxes.forEach(function(checkbox) {
                const name = checkbox.getAttribute('name');
                if (name && name.startsWith('filter[')) {
                    formData.append(name, checkbox.value);
                }
            });
            
            const priceFrom = form.querySelector('.input-min');
            const priceTo = form.querySelector('.input-max');
            
            if (priceFrom && priceFrom.value) {
                formData.append('filter[price][from]', priceFrom.value);
            }
            if (priceTo && priceTo.value) {
                formData.append('filter[price][to]', priceTo.value);
            }
            
            const sortInput = form.querySelector('#sortInput');
            if (sortInput && sortInput.value) {
                formData.append('sort', sortInput.value);
            }
            
            const perPageSelect = document.querySelector('.select-sort-per-page');
            if (perPageSelect && perPageSelect.value) {
                formData.append('perPage', perPageSelect.value);
            }
            
            return formData;
        }
        
        function showLoading() {
            const tableView = document.getElementById('productsTableView');
            const listView = document.getElementById('productsListView');
            
            if (tableView) {
                tableView.style.opacity = '0.5';
                tableView.classList.add('filter-ajax-loading');
            }
            if (listView) {
                listView.style.opacity = '0.5';
                listView.classList.add('filter-ajax-loading');
            }
        }
        
        function hideLoading() {
            const tableView = document.getElementById('productsTableView');
            const listView = document.getElementById('productsListView');
            
            if (tableView) {
                tableView.style.opacity = '1';
                tableView.classList.remove('filter-ajax-loading');
            }
            if (listView) {
                listView.style.opacity = '1';
                listView.classList.remove('filter-ajax-loading');
            }
        }
        
        function updateUI(data, append = false) {
            const tableView = document.getElementById('productsTableView');
            const listView = document.getElementById('productsListView');
            
            if (tableView) {
                if (append) {
                    tableView.insertAdjacentHTML('beforeend', data.tableView || '');
                } else {
                    tableView.innerHTML = data.tableView || '';
                }
                tableView.style.opacity = '1';
            }
            
            if (listView) {
                if (append) {
                    listView.insertAdjacentHTML('beforeend', data.listView || '');
                } else {
                    listView.innerHTML = data.listView || '';
                }
                listView.style.opacity = '1';
            }
            
            const hasPages = (data.hasPages === true) || (data.currentPage && data.lastPage && data.currentPage < data.lastPage);
            
            // Update pagination data attributes and current page
            if (tableView) {
                if (data.currentPage !== undefined) {
                    currentPage = parseInt(data.currentPage) || 1;
                    tableView.setAttribute('data-current-page', currentPage);
                }
                if (data.lastPage !== undefined) {
                    tableView.setAttribute('data-last-page', data.lastPage);
                }
                tableView.setAttribute('data-has-pages', hasPages ? 'true' : 'false');
            }
            
            // Update hasMorePages based on current page and last page
            if (data.currentPage !== undefined && data.lastPage !== undefined) {
                hasMorePages = parseInt(data.currentPage) < parseInt(data.lastPage);
            } else {
                hasMorePages = hasPages;
            }
            
            // Pagination is now handled by infinite scroll, so we don't update DOM
            
            if (data.filtersCounts) {
                updateFiltersCounts(data.filtersCounts);
            }
            
            if (!append && infiniteScrollObserver) {
                destroyInfiniteScroll();
                if (hasMorePages) {
                    initInfiniteScroll();
                }
            } else if (append && hasMorePages && !infiniteScrollObserver) {
                // Re-initialize infinite scroll if we appended content and there are more pages
                initInfiniteScroll();
            }
        }
        
        function updateFiltersCounts(counts) {
            if (counts.categories) {
                Object.keys(counts.categories).forEach(function(categoryOnecId) {
                    const count = counts.categories[categoryOnecId];
                    const link = document.querySelector('.category-filter-link[data-category-id="' + categoryOnecId + '"]');
                    if (link) {
                        const countSpan = link.querySelector('.category-filter-count');
                        if (countSpan) {
                            countSpan.textContent = '(' + count + ')';
                        } else {
                            const newCountSpan = document.createElement('span');
                            newCountSpan.className = 'category-filter-count';
                            newCountSpan.textContent = '(' + count + ')';
                            link.appendChild(newCountSpan);
                        }
                    }
                });
            }
            
            if (counts.brands) {
                Object.keys(counts.brands).forEach(function(brandOnecId) {
                    const count = counts.brands[brandOnecId];
                    const checkbox = document.querySelector('#brand-' + brandOnecId);
                    if (checkbox) {
                        const label = checkbox.nextElementSibling;
                        if (label && label.tagName === 'LABEL') {
                            const existingCount = label.querySelector('.brand-filter-count');
                            if (existingCount) {
                                existingCount.textContent = '(' + count + ')';
                            } else {
                                const countSpan = document.createElement('span');
                                countSpan.className = 'brand-filter-count';
                                countSpan.textContent = ' (' + count + ')';
                                label.appendChild(countSpan);
                            }
                        }
                    }
                });
            }
            
            if (counts.attributes) {
                Object.keys(counts.attributes).forEach(function(attributeOnecId) {
                    const attributeCounts = counts.attributes[attributeOnecId];
                    Object.keys(attributeCounts).forEach(function(attributeValue) {
                        const count = attributeCounts[attributeValue];
                        const checkboxes = document.querySelectorAll('input[name="filter[attribute][' + attributeOnecId + '][]"]');
                        checkboxes.forEach(function(checkbox) {
                            if (checkbox.value === attributeValue || checkbox.value === attributeValue.replace('.', ',')) {
                                const label = checkbox.nextElementSibling;
                                if (label && label.tagName === 'LABEL') {
                                    const existingCount = label.querySelector('.attribute-filter-count');
                                    if (existingCount) {
                                        existingCount.textContent = '(' + count + ')';
                                    } else {
                                        const countSpan = document.createElement('span');
                                        countSpan.className = 'attribute-filter-count';
                                        countSpan.textContent = ' (' + count + ')';
                                        label.appendChild(countSpan);
                                    }
                                }
                            }
                        });
                    });
                });
            }
        }
        
        function performAjaxRequest(page = 1, append = false) {
            if (isLoading) {
                return Promise.resolve();
            }
            
            isLoading = true;
            currentPage = page;
            
            if (!append) {
                showLoading();
            }
            
            const formData = buildFilterFormData();
            formData.append('page', page);
            
            return fetch(ajaxUrl, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    updateUI(data, append);
                    updateURL(data);
                } else {
                    console.error('Server error:', data.message || 'Unknown error');
                    if (!append) {
                        hideLoading();
                    }
                }
                return data;
            })
            .catch(error => {
                console.error('Error:', error);
                if (!append) {
                    hideLoading();
                }
                alert('Произошла ошибка при загрузке данных. Пожалуйста, попробуйте еще раз.');
                throw error;
            })
            .finally(() => {
                isLoading = false;
                if (!append) {
                    hideLoading();
                }
            });
        }
        
        function updateURL(data) {
            const form = document.getElementById('filterForm');
            if (!form) {
                return;
            }
            
            const newUrl = new URL(window.location.href);
            newUrl.searchParams.delete('page');
            
            const checkboxes = form.querySelectorAll('.theme-checkbox:checked');
            newUrl.searchParams.delete('filter[category]');
            newUrl.searchParams.delete('filter[attribute]');
            newUrl.searchParams.delete('filter[brand]');
            newUrl.searchParams.delete('filter[price]');
            
            checkboxes.forEach(function(checkbox) {
                const name = checkbox.getAttribute('name');
                if (name && name.startsWith('filter[')) {
                    const match = name.match(/filter\[([^\]]+)\](?:\[([^\]]+)\])?/);
                    if (match) {
                        const filterKey = match[1];
                        const subKey = match[2];
                        
                        if (subKey) {
                            if (!newUrl.searchParams.has('filter[' + filterKey + '][' + subKey + ']')) {
                                newUrl.searchParams.append('filter[' + filterKey + '][' + subKey + ']', checkbox.value);
                            }
                        } else {
                            newUrl.searchParams.append('filter[' + filterKey + ']', checkbox.value);
                        }
                    }
                }
            });
            
            const priceFrom = form.querySelector('.input-min');
            const priceTo = form.querySelector('.input-max');
            
            if (priceFrom && priceFrom.value) {
                newUrl.searchParams.set('filter[price][from]', priceFrom.value);
            }
            if (priceTo && priceTo.value) {
                newUrl.searchParams.set('filter[price][to]', priceTo.value);
            }
            
            window.history.pushState({}, '', newUrl.toString());
        }
        
        function initCheckboxHandlers() {
            const form = document.getElementById('filterForm');
            if (!form) {
                return;
            }
            
            $(document).off('change.shopFilter', '.theme-checkbox').on('change.shopFilter', '.theme-checkbox', function(e) {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(function() {
                    performAjaxRequest(1, false);
                }, debounceDelay);
            });
        }
        
        function initPriceRangeHandlers() {
            const form = document.getElementById('filterForm');
            if (!form) {
                return;
            }
            
            const priceFrom = form.querySelector('.input-min');
            const priceTo = form.querySelector('.input-max');
            const rangeMin = form.querySelector('.range-min');
            const rangeMax = form.querySelector('.range-max');
            
            if (priceFrom && priceTo) {
                let priceDebounceTimer = null;
                
                [priceFrom, priceTo].forEach(function(input) {
                    input.addEventListener('input', function() {
                        clearTimeout(priceDebounceTimer);
                        priceDebounceTimer = setTimeout(function() {
                            performAjaxRequest(1, false);
                        }, debounceDelay * 2);
                    });
                });
            }
            
            if (rangeMin && rangeMax) {
                let rangeDebounceTimer = null;
                
                [rangeMin, rangeMax].forEach(function(range) {
                    range.addEventListener('input', function() {
                        if (priceFrom && priceTo) {
                            priceFrom.value = rangeMin.value;
                            priceTo.value = rangeMax.value;
                        }
                        
                        clearTimeout(rangeDebounceTimer);
                        rangeDebounceTimer = setTimeout(function() {
                            performAjaxRequest(1, false);
                        }, debounceDelay * 2);
                    });
                });
            }
        }
        
        function initResetButton() {
            const resetBtn = document.getElementById('filterResetBtn');
            if (!resetBtn) {
                return;
            }
            
            resetBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                const form = document.getElementById('filterForm');
                if (!form) {
                    return;
                }
                
                const checkboxes = form.querySelectorAll('.theme-checkbox');
                checkboxes.forEach(function(checkbox) {
                    checkbox.checked = false;
                });
                
                const priceFrom = form.querySelector('.input-min');
                const priceTo = form.querySelector('.input-max');
                const rangeMin = form.querySelector('.range-min');
                const rangeMax = form.querySelector('.range-max');
                
                if (priceFrom) priceFrom.value = 0;
                if (priceTo) priceTo.value = 1000;
                if (rangeMin) rangeMin.value = 0;
                if (rangeMax) rangeMax.value = 1000;
                
                const activeCategoryLink = document.querySelector('.category-filter-link.active');
                if (activeCategoryLink) {
                    activeCategoryLink.classList.remove('active');
                }
                
                const newUrl = new URL(window.location.href);
                newUrl.searchParams.delete('filter');
                newUrl.searchParams.delete('page');
                window.history.pushState({}, '', newUrl.toString());
                
                performAjaxRequest(1, false);
            });
        }
        
        function initInfiniteScroll() {
            const tableView = document.getElementById('productsTableView');
            if (!tableView || infiniteScrollObserver) {
                return;
            }
            
            const trigger = document.createElement('div');
            trigger.className = 'infinite-scroll-trigger';
            trigger.style.height = '20px';
            tableView.appendChild(trigger);
            
            infiniteScrollObserver = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting && hasMorePages && !isLoading && currentPage < 100) {
                        performAjaxRequest(currentPage + 1, true);
                    }
                });
            }, { threshold: 0.1 });
            
            infiniteScrollObserver.observe(trigger);
        }
        
        function destroyInfiniteScroll() {
            if (infiniteScrollObserver) {
                infiniteScrollObserver.disconnect();
                infiniteScrollObserver = null;
            }
            
            const trigger = document.querySelector('.infinite-scroll-trigger');
            if (trigger) {
                trigger.remove();
            }
        }
        
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
            
            performAjaxRequest(parseInt(page), false);
        }
        
        function init() {
            initCheckboxHandlers();
            initPriceRangeHandlers();
            initResetButton();
            
            // Initialize infinite scroll on page load if there are products
            const tableView = document.getElementById('productsTableView');
            if (tableView && tableView.children.length > 0) {
                // Check pagination info from data attributes
                const hasPagesAttr = tableView.getAttribute('data-has-pages');
                const currentPageAttr = tableView.getAttribute('data-current-page');
                const lastPageAttr = tableView.getAttribute('data-last-page');
                
                if (hasPagesAttr === 'true') {
                    hasMorePages = true;
                    if (currentPageAttr && lastPageAttr) {
                        currentPage = parseInt(currentPageAttr) || 1;
                        hasMorePages = parseInt(currentPageAttr) < parseInt(lastPageAttr);
                    }
                } else {
                    hasMorePages = false;
                }
                
                if (hasMorePages) {
                    initInfiniteScroll();
                }
            }
        }
        
        init();
    });
</script>
@endif

