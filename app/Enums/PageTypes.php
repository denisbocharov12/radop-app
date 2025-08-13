<?php

namespace App\Enums;

final class PageTypes
{
    public function getHomeType(): string
    {
        return 'home';
    }

    public function getProductType(): string
    {
        return 'product';
    }

    public function getCategoryType(): string
    {
        return 'category';
    }

    public function getBrandType(): string
    {
        return 'brand';
    }

    public function getAboutType(): string
    {
        return 'about';
    }

    public function getContactType(): string
    {
        return 'contact';
    }

    public function getDeliveryType(): string
    {
        return 'delivery';
    }

    public function getPrivacyPolicyType(): string
    {
        return 'privacy_policy';
    }

    public function getShopType(): string
    {
        return 'shop';
    }

    public function getTermsConditionsType(): string
    {
        return 'terms_conditions';
    }

    public function getReturnRulesType(): string
    {
        return 'return_rules';
    }

    public function getOrderGuideType(): string
    {
        return 'order_guide';
    }

    public function getCookieType(): string
    {
        return 'cookie';
    }

    public function getSearchType(): string
    {
        return 'search';
    }

    public function getAccountType(): string
    {
        return 'account';
    }

    public function getLoginType(): string
    {
        return 'login';
    }

    public function getRegistrationType(): string
    {
        return 'registration';
    }

    public function getShopCatalogType(): string
    {
        return 'shop_catalog';
    }

    public function getCartType(): string
    {
        return 'cart';
    }

    public function getCheckoutType(): string
    {
        return 'checkout';
    }

    public function getOrderType(): string
    {
        return 'order';
    }

    public function getMyOrdersType(): string
    {
        return 'my_orders';
    }

    public function getFilialType(): string
    {
        return 'filial';
    }

    public function getWishListType(): string
    {
        return 'wishlist';
    }

    public function getAll(): array
    {
        return [
            'home' => 'Главная страница',
            'product' => 'Страница товара',
            'category' => 'Страница категории',
            'brand' => 'Страница бренда',
            'about' => 'О нас',
            'contact' => 'Контакты',
            'delivery' => 'Доставка',
            'shop' => 'Магазин',
            'shop_catalog' => 'Каталог',
            'my_orders' => 'Мои заказы',
            'privacy_policy' => 'Политика конфиденциальности',
            'terms_conditions' => 'Условия использования',
            'return_rules' => 'Правила возврата',
            'order_guide' => 'Руководство по заказу',
            'cookie' => 'Политика cookies',
            'search' => 'Поиск',
            'account' => 'Личный кабинет',
            'wishlist' => 'Список желаний',
            'login' => 'Вход',
            'registration' => 'Регистрация',
            'cart' => 'Корзина',
            'checkout' => 'Оформление заказа',
            'order' => 'Заказ',
            'filial' => 'Филиал',
        ];
    }

    public function getStaticPages(): array
    {
        return [
            'home' => 'Главная страница',
            'about' => 'О нас',
            'contact' => 'Контакты',
            'delivery' => 'Доставка',
            'shop' => 'Магазин',
            'shop_catalog' => 'Каталог',
            'my_orders' => 'Мои заказы',
            'privacy_policy' => 'Политика конфиденциальности',
            'terms_conditions' => 'Условия использования',
            'return_rules' => 'Правила возврата',
            'order_guide' => 'Руководство по заказу',
            'cookie' => 'Политика cookies',
            'search' => 'Поиск',
            'account' => 'Личный кабинет',
            'wishlist' => 'Список желаний',
            'login' => 'Вход',
            'registration' => 'Регистрация',
            'cart' => 'Корзина',
            'checkout' => 'Оформление заказа',
        ];
    }

    public function getDynamicPages(): array
    {
        return [
            'product' => 'Страница товара',
            'category' => 'Страница категории',
            'brand' => 'Страница бренда',
            'order' => 'Заказ',
            'filial' => 'Филиал',
        ];
    }

    public function isStaticPage(string $pageType): bool
    {
        return array_key_exists($pageType, $this->getStaticPages());
    }

    public function isDynamicPage(string $pageType): bool
    {
        return array_key_exists($pageType, $this->getDynamicPages());
    }
}
