<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;

/**
 * Права на раздел «Секции главной». Без записей в таблице прав раздел
 * закрыт даже тому, кому его выдали в роли: CheckPermissions сверяется с
 * именем маршрута.
 */
return new class extends Migration
{
    private const PERMISSIONS = [
        'home-section.index',
        'home-section.create',
        'home-section.store',
        'home-section.edit',
        'home-section.update',
        'home-section.delete',
        'home-section.sort.index',
        'home-section.sort.order',
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
