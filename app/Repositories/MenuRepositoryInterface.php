<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Database\Eloquent\Collection;

interface MenuRepositoryInterface
{
    /**
     * Получить все меню
     *
     * @return Collection
     */
    public function getAllMenus(): Collection;

    /**
     * Получить активные меню
     *
     * @return Collection
     */
    public function getActiveMenus(): Collection;

    /**
     * Найти меню по ID
     *
     * @param int $id
     * @return Menu|null
     */
    public function findMenuById(int $id): ?Menu;

    /**
     * Найти меню по коду
     *
     * @param string $code
     * @return Menu|null
     */
    public function findMenuByCode(string $code): ?Menu;

    /**
     * Получить полную иерархию меню по коду (для фронтенда)
     * Загружает корневые элементы с рекурсивными дочерними элементами
     *
     * @param string $code
     * @param bool $onlyActive
     * @return Menu|null
     */
    public function getMenuHierarchyByCode(string $code, bool $onlyActive = true): ?Menu;

    /**
     * Создать новое меню
     *
     * @param array $data
     * @return Menu
     */
    public function createMenu(array $data): Menu;

    /**
     * Обновить меню
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function updateMenu(int $id, array $data): bool;

    /**
     * Удалить меню
     *
     * @param int $id
     * @return bool
     */
    public function deleteMenu(int $id): bool;

    /**
     * Найти элемент меню по ID
     *
     * @param int $id
     * @return MenuItem|null
     */
    public function findMenuItemById(int $id): ?MenuItem;

    /**
     * Получить все элементы меню
     *
     * @param int $menuId
     * @param bool $onlyActive
     * @return Collection
     */
    public function getMenuItems(int $menuId, bool $onlyActive = false): Collection;

    /**
     * Получить корневые элементы меню
     *
     * @param int $menuId
     * @param bool $onlyActive
     * @return Collection
     */
    public function getRootMenuItems(int $menuId, bool $onlyActive = true): Collection;

    /**
     * Создать элемент меню
     *
     * @param array $data
     * @return MenuItem
     */
    public function createMenuItem(array $data): MenuItem;

    /**
     * Обновить элемент меню
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function updateMenuItem(int $id, array $data): bool;

    /**
     * Удалить элемент меню
     *
     * @param int $id
     * @return bool
     */
    public function deleteMenuItem(int $id): bool;

    /**
     * Массовое обновление порядка и parent_id для элементов меню
     * (используется для Drag & Drop)
     *
     * @param array $items Массив вида [['id' => 1, 'parent_id' => null, 'order' => 0], ...]
     * @return bool
     */
    public function bulkUpdateMenuItemsHierarchy(array $items): bool;

    /**
     * Получить максимальное значение order для элементов меню
     *
     * @param int $menuId
     * @param int|null $parentId
     * @return int
     */
    public function getMaxOrderForMenuItem(int $menuId, ?int $parentId = null): int;
}

