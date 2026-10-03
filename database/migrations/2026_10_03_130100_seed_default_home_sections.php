<?php

use App\Models\HomeSection;
use Illuminate\Database\Migrations\Migration;

/**
 * Текущая раскладка главной страницы строками в таблице: баннеры, три ленты
 * товаров и бренды. После выката главная выглядит ровно так же, но порядок и
 * видимость блоков уже редактируются.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (HomeSection::query()->exists()) {
            return;
        }

        $rows = [
            [
                'type' => HomeSection::TYPE_BANNERS,
                'order' => 10,
                'settings' => null,
                'title' => null,
                'link' => null,
            ],
            [
                'type' => HomeSection::TYPE_PRODUCT_RAIL,
                'order' => 20,
                'settings' => ['source' => 'new', 'anchor' => 'new-products-home-anchor', 'list_id' => 'home_new', 'list_name' => 'Home new'],
                'title' => ['ro' => 'Produse noi', 'ru' => 'Новинки'],
                'link' => '/shop/new',
            ],
            [
                'type' => HomeSection::TYPE_PRODUCT_RAIL,
                'order' => 30,
                'settings' => ['source' => 'popular', 'anchor' => 'popular-products-home-anchor', 'list_id' => 'home_popular', 'list_name' => 'Home popular'],
                'title' => ['ro' => 'Top vânzări', 'ru' => 'Топ продаж'],
                'link' => '/shop/popular',
            ],
            [
                'type' => HomeSection::TYPE_PRODUCT_RAIL,
                'order' => 40,
                'settings' => ['source' => 'sale', 'anchor' => 'discount-products-home-anchor', 'list_id' => 'home_sale', 'list_name' => 'Home sale'],
                'title' => ['ro' => 'Produse cu reducere', 'ru' => 'Со скидкой'],
                'link' => '/shop/sale',
            ],
            [
                'type' => HomeSection::TYPE_BRANDS,
                'order' => 50,
                'settings' => ['anchor' => 'brands-home-anchor'],
                'title' => null,
                'link' => null,
            ],
        ];

        foreach ($rows as $row) {
            HomeSection::query()->create($row + ['is_active' => true]);
        }
    }

    public function down(): void
    {
        HomeSection::query()->delete();
    }
};
