<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Helpers\MenuHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\HeaderMenu\HeaderMenuDeleteRequest;
use App\Http\Requests\HeaderMenu\HeaderMenuHierarchyUpdateRequest;
use App\Http\Requests\HeaderMenu\HeaderMenuItemDeleteRequest;
use App\Http\Requests\HeaderMenu\HeaderMenuItemRequest;
use App\Http\Requests\HeaderMenu\HeaderMenuRequest;
use App\Repositories\Category\CategoryRepository;
use App\Services\HeaderMenu\HeaderMenuManager;
use App\Services\HeaderMenuHierarchyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

final class AdminHeaderMenuController extends Controller
{
    protected HeaderMenuHierarchyService $headerMenuHierarchyService;

    protected HeaderMenuManager $headerMenuManager;

    protected CategoryRepository $categoryRepository;

    public function __construct(
        HeaderMenuHierarchyService $headerMenuHierarchyService,
        HeaderMenuManager $headerMenuManager,
        CategoryRepository $categoryRepository
    )
    {
        $this->headerMenuHierarchyService = $headerMenuHierarchyService;
        $this->headerMenuManager = $headerMenuManager;
        $this->categoryRepository = $categoryRepository;
    }

    public function index()
    {
        $menus = $this->headerMenuHierarchyService->getAllHeaderMenusPaginated();

        return view('header-menu.index', compact('menus'));
    }

    public function create()
    {
        return view('header-menu.create');
    }

    public function store(HeaderMenuRequest $request)
    {
        try {
            $menu = $this->headerMenuManager->store($request);

            return redirect()
                ->route('admin.header-menus.edit', $menu->id)
                ->with('success', 'Шапка меню успешно создана');
        } catch (ValidationException $e) {
            return back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Ошибка создания шапки меню')
                ->withInput();
        }
    }

    public function edit(int $id)
    {
        $menu = $this->headerMenuHierarchyService->findHeaderMenuById($id);

        if (!$menu) {
            abort(404, __('theme.header_menu.not_found'));
        }

        $menu->load(['rootItems' => function ($query) {
            $query->with('allChildren')->orderBy('order');
        }]);

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

        $flatMenuItems = $this->headerMenuHierarchyService->getHeaderMenuAsFlatArray($menu->code);

        return view('header-menu.edit', compact('menu', 'flatMenuItems'));
    }

    public function update(HeaderMenuRequest $request, int $id)
    {
        try {
            $this->headerMenuManager->update($request, $id);

            return back()->with('success', 'Шапка меню успешно обновлена');
        } catch (ValidationException $e) {
            return back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Ошибка обновления шапки меню')
                ->withInput();
        }
    }

    public function destroy(HeaderMenuDeleteRequest $request)
    {
        try {
            $this->headerMenuHierarchyService->deleteHeaderMenu($request->route('id'));

            return redirect()
                ->route('admin.header-menus.index')
                ->with('success', 'Шапка меню успешно удалена');
        } catch (\Exception $e) {
            return back()->with('error', 'Ошибка удаления шапки меню');
        }
    }

    public function createItem(int $menuId)
    {
        $menu = $this->headerMenuHierarchyService->findHeaderMenuById($menuId);

        if (!$menu) {
            abort(404, __('theme.header_menu.not_found'));
        }

        $menu->load(['rootItems' => function ($query) {
            $query->with('allChildren')->orderBy('order');
        }]);

        $parentOptions = MenuHelper::buildSelectOptions($menu->rootItems);
        $categories = $this->categoryRepository->getActiveCategoriesForMenu();

        return view('header-menu.items.create', compact('menu', 'parentOptions', 'categories'));
    }

    public function storeItem(HeaderMenuItemRequest $request, int $menuId)
    {
        try {
            $this->headerMenuManager->storeItem($request, $menuId);

            return redirect()
                ->route('admin.header-menus.edit', $menuId)
                ->with('success', 'Элемент шапки меню успешно создан');
        } catch (ValidationException $e) {
            return back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Ошибка создания элемента шапки меню')
                ->withInput();
        }
    }

    public function editItem(int $menuId, int $itemId)
    {
        $menu = $this->headerMenuHierarchyService->findHeaderMenuById($menuId);

        if (!$menu) {
            abort(404, __('theme.header_menu.not_found'));
        }

        $menuItem = $this->headerMenuHierarchyService->findHeaderMenuItemById($itemId);

        if (!$menuItem) {
            abort(404, 'Элемент шапки меню не найден');
        }

        $menuItem->loadMedia('header_menu_item_image');

        $menu->load(['rootItems' => function ($query) {
            $query->with('allChildren')->orderBy('order');
        }]);

        $parentOptions = MenuHelper::buildSelectOptions($menu->rootItems, $itemId);
        $categories = $this->categoryRepository->getActiveCategoriesForMenu();

        return view('header-menu.items.edit', compact('menu', 'menuItem', 'parentOptions', 'categories'));
    }

    public function updateItem(HeaderMenuItemRequest $request, int $menuId, int $itemId)
    {
        try {
            $this->headerMenuManager->updateItem($request, $menuId, $itemId);

            return redirect()
                ->route('admin.header-menus.edit', $menuId)
                ->with('success', 'Элемент шапки меню успешно обновлен');
        } catch (ValidationException $e) {
            return back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Ошибка обновления элемента шапки меню')
                ->withInput();
        }
    }

    public function destroyItem(HeaderMenuItemDeleteRequest $request)
    {
        try {
            $menuId = $request->route('menuId');
            $itemId = (int) $request->route('itemId');

            $this->headerMenuHierarchyService->deleteHeaderMenuItem($itemId);

            return redirect()
                ->route('admin.header-menus.edit', $menuId)
                ->with('success', 'Элемент шапки меню успешно удален');
        } catch (\Exception $e) {
            return back()->with('error', 'Ошибка удаления элемента шапки меню');
        }
    }

    public function updateHierarchy(HeaderMenuHierarchyUpdateRequest $request, string $menuCode): JsonResponse
    {
        try {
            $this->headerMenuHierarchyService->updateHierarchy($menuCode, $request->structure);

            return response()->json([
                'success' => true,
                'message' => 'Иерархия шапки меню успешно обновлена',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка валидации',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка обновления иерархии шапки меню',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function clearCache()
    {
        try {
            $this->headerMenuHierarchyService->clearAllHeaderMenuCache();

            return back()->with('success', 'Кэш шапки меню успешно очищен');
        } catch (\Exception $e) {
            return back()->with('error', 'Ошибка очистки кэша шапки меню');
        }
    }

    public function getCategories(): JsonResponse
    {
        $categories = $this->categoryRepository->getActiveCategoriesForMenu();

        return response()->json($categories);
    }

    public function preview(int $id)
    {
        $menu = $this->headerMenuHierarchyService->findHeaderMenuById($id);

        if (!$menu) {
            abort(404, __('theme.header_menu.not_found'));
        }

        $menu->load(['rootItems' => function ($query) {
            $query->with('children')->where('is_active', true)->orderBy('order');
        }]);

        return view('header-menu.partials.preview', compact('menu'));
    }
}

