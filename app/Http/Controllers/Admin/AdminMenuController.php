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
use App\Repositories\Category\CategoryRepository;
use App\Services\Menu\MenuManager;
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
     * @var MenuManager
     */
    protected MenuManager $menuManager;

    /**
     * @var MenuDataMapper
     */
    protected MenuDataMapper $menuDataMapper;

    /**
     * @var MenuItemDataMapper
     */
    protected MenuItemDataMapper $menuItemDataMapper;

    /**
     * @var CategoryRepository
     */
    protected CategoryRepository $categoryRepository;

    /**
     * AdminMenuController constructor.
     *
     * @param MenuHierarchyService $menuHierarchyService
     * @param MenuManager $menuManager
     * @param MenuDataMapper $menuDataMapper
     * @param MenuItemDataMapper $menuItemDataMapper
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(
        MenuHierarchyService $menuHierarchyService,
        MenuManager $menuManager,
        MenuDataMapper $menuDataMapper,
        MenuItemDataMapper $menuItemDataMapper,
        CategoryRepository $categoryRepository
    )
    {
        $this->menuHierarchyService = $menuHierarchyService;
        $this->menuManager = $menuManager;
        $this->menuDataMapper = $menuDataMapper;
        $this->menuItemDataMapper = $menuItemDataMapper;
        $this->categoryRepository = $categoryRepository;
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
            $menu = $this->menuManager->store($request);

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

        // Загружаем медиа для всех элементов меню
        if ($menu->rootItems) {
            $menu->rootItems->load('media');
            foreach ($menu->rootItems as $item) {
                if ($item->allChildren) {
                    $item->allChildren->load('media');
                    foreach ($item->allChildren as $child) {
                        if ($child->allChildren) {
                            $child->allChildren->load('media');
                        }
                    }
                }
            }
        }

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
            $this->menuManager->update($request, $id);

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
        $categories = $this->categoryRepository->getActiveCategoriesForMenu();

        return view('menu.items.create', compact('menu', 'parentOptions', 'categories'));
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
            $this->menuManager->storeItem($request, $menuId);

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

        $menuItem->loadMedia('menu_item_image');

        $menu->load(['rootItems' => function ($query) {
            $query->with('allChildren')->orderBy('order');
        }]);

        $parentOptions = MenuHelper::buildSelectOptions($menu->rootItems, $itemId);
        $categories = $this->categoryRepository->getActiveCategoriesForMenu();

        return view('menu.items.edit', compact('menu', 'menuItem', 'parentOptions', 'categories'));
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
            $this->menuManager->updateItem($request, $menuId, $itemId);

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
            $itemId = (int) $request->route('itemId');

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
     * Get column sort data for menu items (AJAX handler)
     *
     * @param \Illuminate\Http\Request $request
     * @param string $menuCode
     * @return JsonResponse
     */
    public function getColumnSortData(\Illuminate\Http\Request $request, string $menuCode): JsonResponse
    {
        try {
            $parentId = $request->query('parent_id');
            
            if (!$parentId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Parent ID is required',
                ], 400);
            }

            $menu = $this->menuHierarchyService->findMenuByCode($menuCode);

            if (!$menu) {
                return response()->json([
                    'success' => false,
                    'message' => 'Menu not found',
                ], 404);
            }

            $parentItem = $this->menuHierarchyService->findMenuItemById((int)$parentId);

            if (!$parentItem || $parentItem->menu_id !== $menu->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Parent item not found',
                ], 404);
            }

            $children = \App\Models\MenuItem::where('parent_id', (int)$parentId)
                ->where('type', '!=', 'widget_link')
                ->where('type', '!=', 'row')
                ->orderByRaw('COALESCE(`column`, 1) ASC, COALESCE(`column_order`, `order`, 0) ASC')
                ->get();

            \Illuminate\Support\Facades\Log::info('Column sort data request', [
                'menu_code' => $menuCode,
                'parent_id' => $parentId,
                'parent_item' => $parentItem ? $parentItem->id : null,
                'children_count' => $children->count(),
                'children_ids' => $children->pluck('id')->toArray(),
            ]);

            $locale = app()->getLocale();
            $items = $children->map(function ($item) use ($locale) {
                return [
                    'id' => $item->id,
                    'title' => $item->getTranslation('title', $locale),
                    'column' => $item->column ?? 1,
                    'column_order' => $item->column_order ?? 0,
                ];
            });

            return response()->json([
                'success' => true,
                'items' => $items,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update column sort for menu items (AJAX handler)
     *
     * @param \App\Http\Requests\Menu\MenuColumnSortRequest $request
     * @param string $menuCode
     * @return JsonResponse
     */
    public function updateColumnSort(\App\Http\Requests\Menu\MenuColumnSortRequest $request, string $menuCode): JsonResponse
    {
        try {
            $this->menuHierarchyService->updateColumnSort(
                $menuCode,
                $request->parent_id,
                $request->items
            );

            return response()->json([
                'success' => true,
                'message' => __('theme.menu.column_sort_updated_successfully'),
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
                'message' => __('theme.menu.column_sort_update_failed'),
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
     * Get categories for autocomplete (AJAX)
     *
     * @return JsonResponse
     */
    public function getCategories(): JsonResponse
    {
        $categories = $this->categoryRepository->getActiveCategoriesForMenu();

        return response()->json($categories);
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

