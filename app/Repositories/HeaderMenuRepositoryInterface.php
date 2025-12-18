<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\HeaderMenu;
use App\Models\HeaderMenuItem;
use Illuminate\Database\Eloquent\Collection;

interface HeaderMenuRepositoryInterface
{
    public function getAllHeaderMenus(): Collection;

    public function getActiveHeaderMenus(): Collection;

    public function findHeaderMenuById(int $id): ?HeaderMenu;

    public function findHeaderMenuByCode(string $code): ?HeaderMenu;

    public function getHeaderMenuHierarchyByCode(string $code, bool $onlyActive = true): ?HeaderMenu;

    public function createHeaderMenu(array $data): HeaderMenu;

    public function updateHeaderMenu(int $id, array $data): bool;

    public function deleteHeaderMenu(int $id): bool;

    public function findHeaderMenuItemById(int $id): ?HeaderMenuItem;

    public function getHeaderMenuItems(int $headerMenuId, bool $onlyActive = false): Collection;

    public function getRootHeaderMenuItems(int $headerMenuId, bool $onlyActive = true): Collection;

    public function createHeaderMenuItem(array $data): HeaderMenuItem;

    public function updateHeaderMenuItem(int $id, array $data): bool;

    public function deleteHeaderMenuItem(int $id): bool;

    public function bulkUpdateHeaderMenuItemsHierarchy(array $items): bool;

    public function getMaxOrderForHeaderMenuItem(int $headerMenuId, ?int $parentId = null): int;
}

