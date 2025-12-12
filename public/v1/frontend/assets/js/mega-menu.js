document.addEventListener('DOMContentLoaded', function() {
    const megaMenus = document.querySelectorAll('.mega-menu');
    
    megaMenus.forEach(function(megaMenu) {
        const trigger = megaMenu.querySelector('[data-mega-menu-toggle]');
        const overlay = megaMenu.querySelector('[data-mega-menu-overlay]');
        const dropdown = megaMenu.querySelector('[data-mega-menu-dropdown]');
        const closeBtn = megaMenu.querySelector('[data-mega-menu-close]');
        const sidebarItems = megaMenu.querySelectorAll('.mega-menu__sidebar-item');
        const categoryPanels = megaMenu.querySelectorAll('.mega-menu__category-panel');
        
        if (!trigger || !overlay || !dropdown) return;
        
        let scrollPosition = 0;
        
        function openMenu() {
            trigger.classList.add('active');
            overlay.classList.add('active');
            dropdown.classList.add('active');
            // Сохраняем позицию скролла
            scrollPosition = window.pageYOffset || document.documentElement.scrollTop;
            console.log('[MegaMenu] Opening menu, saved scroll position:', scrollPosition);
            
            // Блокируем скролл body используя position: fixed
            // Сохраняем текущую позицию скролла в data-атрибут для восстановления
            document.body.setAttribute('data-scroll-position', scrollPosition);
            document.body.style.overflow = 'hidden';
            document.body.style.position = 'fixed';
            document.body.style.top = `-${scrollPosition}px`;
            document.body.style.width = '100%';
            console.log('[MegaMenu] Body fixed, top:', document.body.style.top);
        }
        
        function closeMenu() {
            trigger.classList.remove('active');
            overlay.classList.remove('active');
            dropdown.classList.remove('active');
            
            // Функция восстановления скролла
            function restoreScroll() {
                console.log('[MegaMenu] restoreScroll called, scrollPosition:', scrollPosition);
                console.log('[MegaMenu] Current scroll before restore:', window.pageYOffset, document.documentElement.scrollTop);
                
                // Получаем сохраненную позицию из data-атрибута (на случай, если scrollPosition изменился)
                const savedPosition = parseInt(document.body.getAttribute('data-scroll-position') || scrollPosition, 10);
                console.log('[MegaMenu] Saved position from attribute:', savedPosition);
                
                // Восстанавливаем overflow и width
                document.body.style.overflow = '';
                document.body.style.width = '';
                console.log('[MegaMenu] Overflow and width restored');
                
                // Используем правильную последовательность для восстановления скролла
                // Проблема: при удалении position: fixed браузер возвращает страницу в 0
                // Решение: устанавливаем скролл синхронно с удалением фиксации
                // и используем несколько попыток для гарантии
                
                // Убираем position: fixed и top
                document.body.style.position = '';
                document.body.style.top = '';
                document.body.removeAttribute('data-scroll-position');
                console.log('[MegaMenu] Position fixed removed');
                
                // СРАЗУ устанавливаем скролл синхронно (в том же тике event loop)
                // Используем прямой доступ к scrollTop для мгновенного скролла
                document.documentElement.scrollTop = savedPosition;
                document.body.scrollTop = savedPosition;
                window.scrollTo(0, savedPosition);
                console.log('[MegaMenu] Scroll set synchronously to:', savedPosition);
                
                // Используем requestAnimationFrame для проверки и корректировки
                // если браузер все еще вернул страницу в 0
                requestAnimationFrame(function() {
                    const currentScroll = window.pageYOffset || document.documentElement.scrollTop;
                    console.log('[MegaMenu] Scroll after first RAF:', currentScroll);
                    
                    if (Math.abs(currentScroll - savedPosition) > 1) {
                        console.log('[MegaMenu] Scroll correction needed, correcting from', currentScroll, 'to', savedPosition);
                        // Корректируем скролл
                        document.documentElement.scrollTop = savedPosition;
                        document.body.scrollTop = savedPosition;
                        window.scrollTo(0, savedPosition);
                        
                        // Еще одна проверка через следующий RAF
                        requestAnimationFrame(function() {
                            const correctedScroll = window.pageYOffset || document.documentElement.scrollTop;
                            console.log('[MegaMenu] Scroll after correction RAF:', correctedScroll);
                            
                            if (Math.abs(correctedScroll - savedPosition) > 1) {
                                console.log('[MegaMenu] Final correction attempt');
                                document.documentElement.scrollTop = savedPosition;
                                document.body.scrollTop = savedPosition;
                                window.scrollTo(0, savedPosition);
                            }
                        });
                    }
                });
            }
            
            // Ждем завершения CSS transition перед восстановлением скролла
            // Используем таймаут как fallback на случай, если transitionend не сработает
            let scrollRestored = false;
            const restoreScrollOnce = function() {
                if (!scrollRestored) {
                    scrollRestored = true;
                    restoreScroll();
                }
            };
            
            dropdown.addEventListener('transitionend', restoreScrollOnce, { once: true });
            // Fallback: если transitionend не сработает в течение 400ms, восстанавливаем скролл
            setTimeout(restoreScrollOnce, 400);
        }
        
        function showCategoryPanel(categoryId) {
            sidebarItems.forEach(function(si) {
                si.classList.remove('mega-menu__sidebar-item--active');
            });
            
            categoryPanels.forEach(function(panel) {
                panel.classList.remove('mega-menu__category-panel--active');
            });
            
            const targetItem = megaMenu.querySelector(`[data-category-id="${categoryId}"]`);
            if (targetItem) {
                targetItem.classList.add('mega-menu__sidebar-item--active');
            }
            
            const targetPanel = megaMenu.querySelector(`[data-category-panel="${categoryId}"]`);
            if (targetPanel) {
                targetPanel.classList.add('mega-menu__category-panel--active');
            }
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
        
        if (closeBtn) {
            closeBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                closeMenu();
            });
        }
        
        overlay.addEventListener('click', function() {
            closeMenu();
        });
        
        // Hover для категорий (переключение панелей)
        sidebarItems.forEach(function(item) {
            const categoryId = item.dataset.categoryId;
            
            item.addEventListener('mouseenter', function() {
                showCategoryPanel(categoryId);
            });
        });
        
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && dropdown.classList.contains('active')) {
                closeMenu();
            }
        });
    });
});
