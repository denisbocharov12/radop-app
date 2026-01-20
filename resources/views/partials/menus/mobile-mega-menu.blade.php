@if($menu && $menu->is_active && $menu->rootItems->isNotEmpty())
<div class="theme-catalog-navbar catalog-navbar" data-mobile-menu-code="{{ $code ?? 'main_menu' }}">
    <div class="catalog-navbar__catalog">
        <div class="catalog__loading" data-mobile-menu-loading style="display: none;">
            <div class="mega-menu__spinner"></div>
        </div>
        <div class="catalog theme-catalog-body" data-mobile-menu-container style="display: none;"></div>
    </div>
</div>
@endif

