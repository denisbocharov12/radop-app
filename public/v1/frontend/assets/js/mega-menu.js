(function() {
    document.addEventListener('DOMContentLoaded', function() {
        const megaMenus = document.querySelectorAll('.mega-menu');

        megaMenus.forEach(function(megaMenu) {
            const trigger = megaMenu.querySelector('[data-mega-menu-toggle]');
            const overlay = megaMenu.querySelector('[data-mega-menu-overlay]');
            const dropdown = megaMenu.querySelector('[data-mega-menu-dropdown]');
            const container = dropdown ? dropdown.querySelector('[data-mega-menu-container]') : null;
            const loading = dropdown ? dropdown.querySelector('[data-mega-menu-loading]') : null;
            const menuCode = megaMenu.dataset.menuCode || dropdown?.dataset.menuCode;
            const translateLoadError = megaMenu.dataset.translateLoadError || 'Ошибка загрузки меню';
            const translateInvalidResponse = megaMenu.dataset.translateInvalidResponse || 'Неверный формат ответа';
            const translateLoadErrorMessage = megaMenu.dataset.translateLoadErrorMessage || 'Ошибка загрузки меню. Пожалуйста, обновите страницу.';

            if (!trigger || !overlay || !dropdown || !menuCode) return;

            let isLoaded = false;
            let isLoading = false;
            const categoryContentCache = {};

            function openMenu() {
                trigger.classList.add('active');
                overlay.classList.add('active');
                dropdown.classList.add('active');
                document.body.style.overflow = 'hidden';
                document.documentElement.style.overflow = 'hidden';

                if (!isLoaded && !isLoading) {
                    loadMenuContent();
                }
            }

            function closeMenu() {
                trigger.classList.remove('active');
                overlay.classList.remove('active');
                dropdown.classList.remove('active');
                document.body.style.overflow = '';
                document.documentElement.style.overflow = '';
            }

            function loadMenuContent() {
                isLoading = true;
                if (loading) loading.style.display = 'flex';
                if (container) container.style.display = 'none';

                fetch(`/api/v1/mega-menu/${menuCode}/html`, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        if (response.status === 404) {
                            return response.json().then(err => {
                                return {
                                    success: false,
                                    message: err.message || translateLoadError,
                                    html: ''
                                };
                            }).catch(() => {
                                return {
                                    success: false,
                                    message: translateLoadError,
                                    html: ''
                                };
                            });
                        }
                        return response.json().then(err => {
                            throw new Error(err.message || translateLoadError);
                        }).catch(() => {
                            throw new Error(translateLoadError);
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    if (data && typeof data === 'object' && data.success === true && data.html) {
                        if (container) {
                            container.innerHTML = data.html;
                            container.style.display = 'block';
                        }
                        if (loading) loading.style.display = 'none';
                        isLoaded = true;
                        initializeMenuInteractions();
                    } else {
                        if (loading) loading.style.display = 'none';
                        closeMenu();
                    }
                })
                .catch(error => {
                    console.error('Ошибка загрузки мега-меню:', error);
                    if (loading) loading.style.display = 'none';
                    closeMenu();
                    
                    if (container) {
                        const closeBtnHtml = '<button type="button" class="mega-menu__close mega-menu__error-close" data-mega-menu-close><span class="mega-menu__close-icon"></span></button>';
                        container.innerHTML = '<div class="mega-menu__error"><div class="mega-menu__error-content">' + closeBtnHtml + '<p>' + translateLoadErrorMessage + '</p></div></div>';
                        container.style.display = 'block';
                        
                        const errorCloseBtn = container.querySelector('.mega-menu__error-close');
                        if (errorCloseBtn) {
                            errorCloseBtn.addEventListener('click', function(e) {
                                e.preventDefault();
                                e.stopPropagation();
                                closeMenu();
                            });
                        }
                    }
                })
                .finally(() => {
                    isLoading = false;
                });
            }

            function initializeMenuInteractions() {
                const closeBtn = dropdown.querySelector('[data-mega-menu-close]');
                const sidebarItems = dropdown.querySelectorAll('.mega-menu__sidebar-item');
                const categoryPanels = dropdown.querySelectorAll('.mega-menu__category-panel');

                function showCategoryPanel(categoryId) {
                    sidebarItems.forEach(function(si) {
                        si.classList.remove('mega-menu__sidebar-item--active');
                    });

                    categoryPanels.forEach(function(panel) {
                        panel.classList.remove('mega-menu__category-panel--active');
                    });

                    const targetItem = dropdown.querySelector(`[data-category-id="${categoryId}"]`);
                    if (targetItem) {
                        targetItem.classList.add('mega-menu__sidebar-item--active');
                    }

                    const targetPanel = dropdown.querySelector(`[data-category-panel="${categoryId}"]`);
                    if (targetPanel) {
                        targetPanel.classList.add('mega-menu__category-panel--active');
                        
                        const hasContent = targetPanel.children.length > 0 && !targetPanel.querySelector('.mega-menu__loading');
                        
                        if (!hasContent && !categoryContentCache[categoryId]) {
                            loadCategoryContent(categoryId, targetPanel);
                        } else if (categoryContentCache[categoryId]) {
                            targetPanel.innerHTML = categoryContentCache[categoryId];
                        }
                    }
                }

                function loadCategoryContent(categoryId, panel) {
                    if (categoryContentCache[categoryId]) {
                        panel.innerHTML = categoryContentCache[categoryId];
                        return;
                    }

                    const loadingIndicator = document.createElement('div');
                    loadingIndicator.className = 'mega-menu__loading';
                    loadingIndicator.innerHTML = '<div class="mega-menu__spinner"></div>';
                    loadingIndicator.style.display = 'flex';
                    
                    panel.innerHTML = '';
                    panel.appendChild(loadingIndicator);

                    fetch(`/api/v1/mega-menu/${menuCode}/category/${categoryId}/content`, {
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(err => {
                                throw new Error(err.message || 'Ошибка загрузки контента');
                            }).catch(() => {
                                throw new Error('Ошибка загрузки контента');
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data && typeof data === 'object' && data.success === true && data.html) {
                            categoryContentCache[categoryId] = data.html;
                            panel.innerHTML = data.html;
                        } else {
                            throw new Error(data?.message || 'Неверный формат ответа');
                        }
                    })
                    .catch(error => {
                        console.error('Ошибка загрузки контента категории:', error);
                        panel.innerHTML = '<div class="mega-menu__error"><div class="mega-menu__error-content"><p>Ошибка загрузки контента. Пожалуйста, обновите страницу.</p></div></div>';
                    });
                }

                if (closeBtn) {
                    closeBtn.addEventListener('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        closeMenu();
                    });
                }

                sidebarItems.forEach(function(item) {
                    const categoryId = item.dataset.categoryId;
                    if (categoryId) {
                        item.addEventListener('mouseenter', function() {
                            showCategoryPanel(categoryId);
                        });
                    }
                });
            }

            trigger.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                if (dropdown.classList.contains('active')) {
                    closeMenu();
                } else {
                    openMenu();
                }
            });

            overlay.addEventListener('click', function() {
                closeMenu();
            });

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && dropdown.classList.contains('active')) {
                    closeMenu();
                }
            });
        });
    });
})();
