<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Helpers\MenuHelper;
use App\Http\Controllers\Controller;
use App\Http\Mappers\MenuDataMapper;
use App\Http\Mappers\MenuItemDataMapper;
use App\Http\Requests\Menu\MenuDeleteRequest;
use App\Http\Requests\Menu\MenuHierarchyUpdateRequest;
use App\Http\Requests\Menu\MenuItemDeleteRequest;
use App\Http\Requests\Menu\MenuItemRequest;
use App\Http\Requests\Menu\MenuRequest;
use App\Services\MenuHierarchyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

final class AdminMenuController extends Controller
{
    /**
     * @var MenuHierarchyService
     */
    protected MenuHierarchyService $menuHierarchyService;

    /**
     * @var MenuDataMapper
     */
    protected MenuDataMapper $menuDataMapper;

    /**
     * @var MenuItemDataMapper
     */
    protected MenuItemDataMapper $menuItemDataMapper;

    /**
     * AdminMenuController constructor.
     *
     * @param MenuHierarchyService $menuHierarchyService
     * @param MenuDataMapper $menuDataMapper
     * @param MenuItemDataMapper $menuItemDataMapper
     */
    public function __construct(
        MenuHierarchyService $menuHierarchyService,
        MenuDataMapper $menuDataMapper,
        MenuItemDataMapper $menuItemDataMapper
    )
    {
        $this->menuHierarchyService = $menuHierarchyService;
        $this->menuDataMapper = $menuDataMapper;
        $this->menuItemDataMapper = $menuItemDataMapper;
    }

    /**
     * Display a listing of menus
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $menus = $this->menuHierarchyService->getAllMenusPaginated();

        return view('menu.index', compact('menus'));
    }

    /**
     * Show the form for creating a new menu
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('menu.create');
    }

    /**
     * Store a newly created menu in storage
     *
     * @param MenuRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(MenuRequest $request)
    {
        try {
            $menuData = $this->menuDataMapper->mapFromRequestToNormalized($request);

            $menu = $this->menuHierarchyService->createMenu([
                'code' => $menuData->code,
                'name' => $menuData->name,
                'link' => $menuData->link,
                'description' => $menuData->description,
                'is_active' => $menuData->is_active,
            ]);

            return redirect()
                ->route('admin.menus.edit', $menu->id)
                ->with('success', __('theme.menu.created_successfully'));
        } catch (ValidationException $e) {
            return back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            return back()
                ->with('error', __('theme.menu.creation_failed'))
                ->withInput();
        }
    }

    /**
     * Show the form for editing the specified menu
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function edit(int $id)
    {
        $menu = $this->menuHierarchyService->findMenuById($id);

        if (!$menu) {
            abort(404, __('theme.menu.not_found'));
        }

        $menu->load(['rootItems' => function ($query) {
            $query->with('allChildren')->orderBy('order');
        }]);

        $flatMenuItems = $this->menuHierarchyService->getMenuAsFlatArray($menu->code);

        return view('menu.edit', compact('menu', 'flatMenuItems'));
    }

    /**
     * Update the specified menu in storage
     *
     * @param MenuRequest $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(MenuRequest $request, int $id)
    {
        try {
            $menuData = $this->menuDataMapper->mapFromRequestToNormalized($request);

            $this->menuHierarchyService->updateMenu($id, [
                'code' => $menuData->code,
                'name' => $menuData->name,
                'link' => $menuData->link,
                'description' => $menuData->description,
                'is_active' => $menuData->is_active,
            ]);

            return back()->with('success', __('theme.menu.updated_successfully'));
        } catch (ValidationException $e) {
            return back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            return back()
                ->with('error', __('theme.menu.update_failed'))
                ->withInput();
        }
    }

    /**
     * Remove the specified menu from storage
     *
     * @param MenuDeleteRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(MenuDeleteRequest $request)
    {
        try {
            $this->menuHierarchyService->deleteMenu($request->route('id'));

            return redirect()
                ->route('admin.menus.index')
                ->with('success', __('theme.menu.deleted_successfully'));
        } catch (\Exception $e) {
            return back()->with('error', __('theme.menu.deletion_failed'));
        }
    }

    /**
     * Show the form for creating a new menu item
     *
     * @param int $menuId
     * @return \Illuminate\View\View
     */
    public function createItem(int $menuId)
    {
        $menu = $this->menuHierarchyService->findMenuById($menuId);

        if (!$menu) {
            abort(404, __('theme.menu.not_found'));
        }

        $menu->load(['rootItems' => function ($query) {
            $query->with('allChildren')->orderBy('order');
        }]);

        $parentOptions = MenuHelper::buildSelectOptions($menu->rootItems);

        return view('menu.items.create', compact('menu', 'parentOptions'));
    }

    /**
     * Store a newly created menu item
     *
     * @param MenuItemRequest $request
     * @param int $menuId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeItem(MenuItemRequest $request, int $menuId)
    {
        try {
            $menuItemData = $this->menuItemDataMapper->mapFromRequestToNormalized($request, $menuId);
            $data = $this->menuItemDataMapper->mapToArray($menuItemData);

            $this->menuHierarchyService->createMenuItem($data);

            return redirect()
                ->route('admin.menus.edit', $menuId)
                ->with('success', __('theme.menu_item.created_successfully'));
        } catch (ValidationException $e) {
            return back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            return back()
                ->with('error', __('theme.menu_item.creation_failed'))
                ->withInput();
        }
    }

    /**
     * Show the form for editing a menu item
     *
     * @param int $menuId
     * @param int $itemId
     * @return \Illuminate\View\View
     */
    public function editItem(int $menuId, int $itemId)
    {
        $menu = $this->menuHierarchyService->findMenuById($menuId);

        if (!$menu) {
            abort(404, __('theme.menu.not_found'));
        }

        $menuItem = $this->menuHierarchyService->findMenuItemById($itemId);

        if (!$menuItem) {
            abort(404, __('theme.menu_item.not_found'));
        }

        $menu->load(['rootItems' => function ($query) {
            $query->with('allChildren')->orderBy('order');
        }]);

        $parentOptions = MenuHelper::buildSelectOptions($menu->rootItems, $itemId);

        return view('menu.items.edit', compact('menu', 'menuItem', 'parentOptions'));
    }

    /**
     * Update a menu item
     *
     * @param MenuItemRequest $request
     * @param int $menuId
     * @param int $itemId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateItem(MenuItemRequest $request, int $menuId, int $itemId)
    {
        try {
            $menuItemData = $this->menuItemDataMapper->mapFromRequestToNormalized($request, $menuId);
            $data = $this->menuItemDataMapper->mapToArray($menuItemData);

            $this->menuHierarchyService->updateMenuItem($itemId, $data);

            return redirect()
                ->route('admin.menus.edit', $menuId)
                ->with('success', __('theme.menu_item.updated_successfully'));
        } catch (ValidationException $e) {
            return back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            return back()
                ->with('error', __('theme.menu_item.update_failed'))
                ->withInput();
        }
    }

    /**
     * Delete a menu item
     *
     * @param MenuItemDeleteRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroyItem(MenuItemDeleteRequest $request)
    {
        try {
            $menuId = $request->route('menuId');
            $itemId = $request->route('itemId');

            $this->menuHierarchyService->deleteMenuItem($itemId);

            return redirect()
                ->route('admin.menus.edit', $menuId)
                ->with('success', __('theme.menu_item.deleted_successfully'));
        } catch (\Exception $e) {
            return back()->with('error', __('theme.menu_item.deletion_failed'));
        }
    }

    /**
     * Update menu hierarchy (AJAX handler for Drag & Drop)
     *
     * @param MenuHierarchyUpdateRequest $request
     * @param string $menuCode
     * @return JsonResponse
     */
    public function updateHierarchy(MenuHierarchyUpdateRequest $request, string $menuCode): JsonResponse
    {
        try {
            $this->menuHierarchyService->updateHierarchy($menuCode, $request->structure);

            return response()->json([
                'success' => true,
                'message' => __('theme.menu.hierarchy_updated_successfully'),
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => __('theme.menu.validation_failed'),
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('theme.menu.hierarchy_update_failed'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Clear menu cache
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function clearCache()
    {
        try {
            $this->menuHierarchyService->clearAllMenuCache();

            return back()->with('success', __('theme.menu.cache_cleared_successfully'));
        } catch (\Exception $e) {
            return back()->with('error', __('theme.menu.cache_clear_failed'));
        }
    }

    /**
     * Get menu preview HTML
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function preview(int $id)
    {
        $menu = $this->menuHierarchyService->findMenuById($id);

        if (!$menu) {
            abort(404, __('theme.menu.not_found'));
        }

        $menu->load(['rootItems' => function ($query) {
            $query->with('children')->where('is_active', true)->orderBy('order');
        }]);

        return view('menu.partials.preview', compact('menu'));
    }
}

