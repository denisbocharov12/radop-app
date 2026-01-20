@if($menu && $menu->is_active && $menu->rootItems->isNotEmpty())
@php
    $locale = app()->getLocale();
    $nameRaw = $menu->getRawOriginal('name');
    $menuName = is_array(json_decode($nameRaw, true))
        ? $menu->getTranslation('name', $locale)
        : ($nameRaw ?? '');
    $linkRaw = $menu->getRawOriginal('link');
    $menuLink = is_array(json_decode($linkRaw, true))
        ? $menu->getTranslation('link', $locale)
        : ($linkRaw ?? '');
@endphp
<div class="mega-menu {{ $cssClass ?? '' }}" 
     data-menu-code="{{ $code ?? '' }}"
     data-translate-load-error="{{ __('theme.mega-menu-load-error') }}"
     data-translate-invalid-response="{{ __('theme.mega-menu-invalid-response') }}"
     data-translate-load-error-message="{{ __('theme.mega-menu-load-error-message') }}">
    @if($menuLink)
        <a href="{{ $menuLink }}" id="btn-header-catalog" class="btn-header-catalog" data-mega-menu-toggle>
            <span class="animated-burger-icon"></span>
            <span class="btn-header-catalog-text">{{ $menuName }}</span>
        </a>
    @else
        <button id="btn-header-catalog" class="btn-header-catalog" data-mega-menu-toggle>
            <span class="animated-burger-icon"></span>
            <span class="btn-header-catalog-text">{{ $menuName }}</span>
        </button>
    @endif

    <div class="mega-menu__overlay" data-mega-menu-overlay></div>

    <div class="mega-menu__dropdown" data-mega-menu-dropdown data-menu-code="{{ $code ?? '' }}">
        <div class="mega-menu__loading" data-mega-menu-loading style="display: none;">
            <div class="mega-menu__spinner"></div>
        </div>
        <div class="mega-menu__container" data-mega-menu-container style="display: none;"></div>
    </div>
</div>
@endif

