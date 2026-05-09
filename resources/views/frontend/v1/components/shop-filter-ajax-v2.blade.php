@if(isset($pageSubType))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const pageSubType = '{{ $pageSubType }}';
        const isModal = {{ isset($isModal) && $isModal ? 'true' : 'false' }};
        const ajaxUrl = '{{ route("theme.shop.filter", ":type") }}'.replace(':type', pageSubType);
        let debounceTimer = null;
        let isLoading = false;
        const debounceDelay = 500;
        const namespace = 'shopFilterV2';

        function buildFilterFormData() {
            const formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}');
            
            // Check both desktop and modal forms for checkboxes
            const desktopForm = document.getElementById('filterForm');
            const modalForm = document.getElementById('filterFormModal');
            const activeForm = isModal && modalForm ? modalForm : (desktopForm || modalForm);
            
            if (activeForm) {
                const checkboxes = activeForm.querySelectorAll('.theme-checkbox:checked');
                checkboxes.forEach(function(checkbox) {
                    const name = checkbox.getAttribute('name');
                    if (name && name.startsWith('filter[')) {
                        formData.append(name, checkbox.value);
                    }
                });
                
                const priceFrom = activeForm.querySelector('.input-min');
                const priceTo = activeForm.querySelector('.input-max');
                
                if (priceFrom && priceFrom.value) {
                    formData.append('filter[price][from]', priceFrom.value);
                }
                if (priceTo && priceTo.value) {
                    formData.append('filter[price][to]', priceTo.value);
                }
            }
            
            const sortInputId = isModal ? 'sortInputModal' : 'sortInput';
            const sortInput = document.querySelector('#' + sortInputId) || document.querySelector('#sortInput');
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
            const listViewMobile = document.getElementById('productsListViewMobile');
            
            if (tableView) {
                tableView.style.opacity = '0.5';
                tableView.classList.add('filter-ajax-loading');
            }
            if (listView) {
                listView.style.opacity = '0.5';
                listView.classList.add('filter-ajax-loading');
            }
            if (listViewMobile) {
                listViewMobile.style.opacity = '0.5';
                listViewMobile.classList.add('filter-ajax-loading');
            }
        }
        
        function hideLoading() {
            const tableView = document.getElementById('productsTableView');
            const listView = document.getElementById('productsListView');
            const listViewMobile = document.getElementById('productsListViewMobile');
            
            if (tableView) {
                tableView.style.opacity = '1';
                tableView.classList.remove('filter-ajax-loading');
            }
            if (listView) {
                listView.style.opacity = '1';
                listView.classList.remove('filter-ajax-loading');
            }
            if (listViewMobile) {
                listViewMobile.style.opacity = '1';
                listViewMobile.classList.remove('filter-ajax-loading');
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
                listViewMobile.style.opacity = '1';
                listViewMobile.style.display = 'block';
            }
            
            const paginationContainers = document.querySelectorAll('.theme-pagination-container');
            if (paginationContainers.length > 0) {
                paginationContainers.forEach(function(container) {
                    container.innerHTML = data.pagination || '';
                });
                if (data.pagination) {
                    initPaginationHandlers();
                }
            } else if (data.pagination) {
                const tableViewParent = tableView ? tableView.parentElement : null;
                if (tableViewParent) {
                    let existingPagination = tableViewParent.querySelector('.theme-pagination-container');
                    if (!existingPagination) {
                        existingPagination = document.createElement('div');
                        existingPagination.className = 'theme-pagination theme-pagination-container';
                        tableViewParent.appendChild(existingPagination);
                    }
                    existingPagination.innerHTML = data.pagination;
                    initPaginationHandlers();
                }
            }
            
            if (data.filtersCounts) {
                updateFiltersCounts(data.filtersCounts);
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
                            countSpan.textContent = String(count);
                        } else {
                            const newCountSpan = document.createElement('span');
                            newCountSpan.className = 'category-filter-count';
                            newCountSpan.textContent = String(count);
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
                                existingCount.textContent = String(count);
                            } else {
                                const countSpan = document.createElement('span');
                                countSpan.className = 'brand-filter-count';
                                countSpan.textContent = String(count);
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
                                        existingCount.textContent = String(count);
                                    } else {
                                        const countSpan = document.createElement('span');
                                        countSpan.className = 'attribute-filter-count';
                                        countSpan.textContent = String(count);
                                        label.appendChild(countSpan);
                                    }
                                }
                            }
                        });
                    });
                });
            }
        }
        
        function performAjaxRequest(page = 1) {
            if (isLoading) {
                return Promise.resolve();
            }
            
            isLoading = true;
            showLoading();
            
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
                    updateUI(data);
                    if (!isModal) {
                        updateURL(data);
                    }
                } else {
                    console.error('Server error:', data.message || 'Unknown error');
                    hideLoading();
                }
                return data;
            })
            .catch(error => {
                console.error('Error:', error);
                hideLoading();
                alert('An error occurred while loading data. Please try again.');
                throw error;
            })
            .finally(() => {
                isLoading = false;
                hideLoading();
            });
        }
        
        function updateURL(data) {
            const formId = isModal ? 'filterFormModal' : 'filterForm';
            const form = document.getElementById(formId);
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
            // For desktop: automatic filtering on change
            // For mobile: no automatic filtering, user clicks "Apply" button
            if (!isModal) {
                $(document).off('change.' + namespace, '.theme-checkbox').on('change.' + namespace, '.theme-checkbox', function(e) {
                    clearTimeout(debounceTimer);
                    debounceTimer = setTimeout(function() {
                        performAjaxRequest(1);
                    }, debounceDelay);
                });
            }
        }
        
        function initApplyButton() {
            if (!isModal) {
                return;
            }
            
            const applyBtn = document.getElementById('filterApplyBtnModal');
            if (!applyBtn) {
                return;
            }
            
            applyBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                performAjaxRequest(1).then(function() {
                    setTimeout(function() {
                        const modalElement = document.getElementById('filtersModal');
                        if (modalElement) {
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
                        
                        setTimeout(function() {
                            const listViewMobile = document.getElementById('productsListViewMobile');
                            if (listViewMobile) {
                                listViewMobile.scrollIntoView({ behavior: 'smooth', block: 'start' });
                            }
                        }, 300);
                    }, 100);
                });
            });
        }
        
        function initPriceRangeHandlers() {
            const formId = isModal ? 'filterFormModal' : 'filterForm';
            const form = document.getElementById(formId);
            if (!form) {
                return;
            }
            
            const priceFrom = form.querySelector('.input-min');
            const priceTo = form.querySelector('.input-max');
            const rangeMin = form.querySelector('.range-min');
            const rangeMax = form.querySelector('.range-max');
            
            if (!isModal && priceFrom && priceTo) {
                let priceDebounceTimer = null;
                
                [priceFrom, priceTo].forEach(function(input) {
                    input.addEventListener('input', function() {
                        clearTimeout(priceDebounceTimer);
                        priceDebounceTimer = setTimeout(function() {
                            performAjaxRequest(1);
                        }, debounceDelay * 2);
                    });
                });
            }
            
            if (!isModal && rangeMin && rangeMax) {
                let rangeDebounceTimer = null;
                
                [rangeMin, rangeMax].forEach(function(range) {
                    range.addEventListener('input', function() {
                        if (priceFrom && priceTo) {
                            priceFrom.value = rangeMin.value;
                            priceTo.value = rangeMax.value;
                        }
                        
                        clearTimeout(rangeDebounceTimer);
                        rangeDebounceTimer = setTimeout(function() {
                            performAjaxRequest(1);
                        }, debounceDelay * 2);
                    });
                });
            }
        }
        
        function initResetButton() {
            const resetBtnId = isModal ? 'filterResetBtnModal' : 'filterResetBtn';
            const resetBtn = document.getElementById(resetBtnId);
            if (!resetBtn) {
                return;
            }
            
            resetBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                const formId = isModal ? 'filterFormModal' : 'filterForm';
                const form = document.getElementById(formId);
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
                
                const sortInputId = isModal ? 'sortInputModal' : 'sortInput';
                const sortInput = document.getElementById(sortInputId);
                if (sortInput) {
                    sortInput.value = '';
                }
                
                const perPageSelect = document.querySelector('.select-sort-per-page');
                if (perPageSelect) {
                    perPageSelect.value = '24';
                }
                
                const newUrl = new URL(window.location.href);
                newUrl.searchParams.delete('filter');
                newUrl.searchParams.delete('page');
                newUrl.searchParams.delete('sort');
                newUrl.searchParams.delete('perPage');
                window.history.pushState({}, '', newUrl.toString());
                
                performAjaxRequest(1);
            });
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
            
            performAjaxRequest(parseInt(page));
        }
        
        function initPaginationHandlers() {
            const paginationContainers = document.querySelectorAll('.theme-pagination-container');
            paginationContainers.forEach(function(paginationContainer) {
                const links = paginationContainer.querySelectorAll('a[href*="page="]');
                links.forEach(function(link) {
                    link.removeEventListener('click', handlePaginationClick);
                    link.addEventListener('click', handlePaginationClick);
                });
            });
        }
        
        function init() {
            initCheckboxHandlers();
            initPriceRangeHandlers();
            initResetButton();
            initApplyButton();
            initPaginationHandlers();
        }
        
        init();
    });
</script>
@endif

