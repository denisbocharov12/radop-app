<?php

declare(strict_types=1);

namespace Database\Seeders\User;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    private array $permittedRoutes = [
        'dashboard.index',
        'order.index',
        'category.index',
        'brand.index',
        'product.index',
        'attribute.index',
        'coupon.index',
        'client.index',
        'client.show',
        'manager.index',
        'manager.edit',
        'manager.update',
        'filial.index',
        'filial.update',
        'filial.store',
        'filial.edit',
        'filial.delete',
        'order.status.last-ten-minutes',
        'reports.orders.index',
        'reports.orders.generate',
        'reports.orders.download',
        'reports.users.index',
        'reports.users.generate',
        'reports.users.download',
        'reports.orders-city.index',
        'reports.orders-city.generate',
        'reports.orders-city.download',
        'reports.orders-status.index',
        'reports.orders-status.generate',
        'reports.orders-status.download',
        'reports.orders-user-type.index',
        'reports.orders-user-type.generate',
        'reports.orders-user-type.download',
        'reports.view-count.product.index',
        'reports.view-count.product.report.generate',
        'reports.view-count.product.report.export',
        'reports.view-count.brand.index',
        'reports.view-count.brand.report.generate',
        'reports.view-count.category.index',
        'reports.view-count.category.report.generate',
        'seo_meta.index',
        'seo_meta.get',
        'seo_meta.create',
        'seo_meta.store',
        'seo_meta.edit',
        'seo_meta.update',
        'seo_meta.media.delete',
        'seo_meta.destroy',
        'seo_meta.destroy.ajax',
        'banner.index',
        'banner.sort.index',
        'banner.sort.order',
        'banner.store',
        'banner.edit',
        'banner.update',
        'banner.delete',
        'banner.banner-settings.edit',
        'banner.banner-settings.update',
        'import-export-data.descriptions.reset',
        'category.select.category',
        'category.sort.products.order.index',
        'category.sort.products.order',
        'category.export.onec-prices',
        'brand.export.onec-prices',
    ];

    private array $userPermittedRoutes = [
        'theme.user.logout',
        'theme.user.account.index',
        'theme.user.account.update',
        'theme.user.orders.index',
        'theme.user.orders.view.invoice',
        'theme.user.orders.download.invoice',
        'theme.user.orders.repeat',
        'theme.user.account.password.update',
        'theme.user.coupon.index',
        'theme.user.filial.index',
        'theme.user.filial.edit',
        'theme.user.filial.store',
        'theme.user.filial.update',
        'theme.user.filial.create',
        'theme.review.store',
        'theme.review.product.reviews',
        'theme.category.export.personalized',
        'theme.brand.export.personalized',
        'theme.shop.new.export.personalized',
        'theme.shop.popular.export.personalized',
        'theme.shop.sale.export.personalized',
    ];

    public function run(): void
    {
        foreach ($this->permittedRoutes as $route) {
            Permission::query()->updateOrCreate([
                'name' => $route,
                'guard_name' => 'web',
            ]);
        }

        foreach ($this->userPermittedRoutes as $route) {
            Permission::query()->updateOrCreate([
                'name' => $route,
                'guard_name' => 'web',
            ]);
        }
    }
}
