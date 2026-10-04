<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;

/**
 * Права на раздел «Популярные запросы»: без записей в таблице прав раздел
 * закрыт даже тому, кому его выдали в роли — CheckPermissions сверяется с
 * именем маршрута.
 */
return new class extends Migration
{
    private const PERMISSIONS = [
        'search-popular-critery.index',
        'search-popular-critery.create',
        'search-popular-critery.store',
        'search-popular-critery.edit',
        'search-popular-critery.update',
        'search-popular-critery.delete',
    ];

    public function up(): void
    {
        foreach (self::PERMISSIONS as $name) {
            Permission::findOrCreate($name, 'web');
        }
    }

    public function down(): void
    {
        Permission::whereIn('name', self::PERMISSIONS)->delete();
    }
};
