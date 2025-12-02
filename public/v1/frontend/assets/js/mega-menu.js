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
        
        function openMenu() {
            trigger.classList.add('active');
            overlay.classList.add('active');
            dropdown.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
        
        function closeMenu() {
            trigger.classList.remove('active');
            overlay.classList.remove('active');
            dropdown.classList.remove('active');
            document.body.style.overflow = '';
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
        
        sidebarItems.forEach(function(item) {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                
                const categoryId = this.dataset.categoryId;
                
                sidebarItems.forEach(function(si) {
                    si.classList.remove('mega-menu__sidebar-item--active');
                });
                
                categoryPanels.forEach(function(panel) {
                    panel.classList.remove('mega-menu__category-panel--active');
                });
                
                this.classList.add('mega-menu__sidebar-item--active');
                
                const targetPanel = megaMenu.querySelector(`[data-category-panel="${categoryId}"]`);
                if (targetPanel) {
                    targetPanel.classList.add('mega-menu__category-panel--active');
                }
            });
        });
        
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && dropdown.classList.contains('active')) {
                closeMenu();
            }
        });
    });
});

