<?php

namespace App\Http\Controllers;

use App\Repositories\PageSortSettingRepository;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PageSortSettingController extends Controller
{
    /**
     * @param PageSortSettingRepository $pageSortSettingRepository
     */
    public function __construct(
        private readonly PageSortSettingRepository $pageSortSettingRepository
    ) {
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json($this->pageSortSettingRepository->getAll());
    }

    /**
     * @param string $page
     * @return JsonResponse
     */
    public function show(string $page): JsonResponse
    {
        $setting = $this->pageSortSettingRepository->getByPage($page);
        if (!$setting) {
            return response()->json(['message' => 'Not found'], 404);
        }
        return response()->json($setting);
    }

    /**
     * @param Request $request
     * @param string $page
     * @return JsonResponse
     */
    public function update(Request $request, string $page): JsonResponse
    {
        $request->validate([
            'default_sort' => 'required|string',
        ]);
        $setting = $this->pageSortSettingRepository->setDefaultSort($page, $request->input('default_sort'));
        return response()->json($setting);
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function webIndex()
    {
        $settings = $this->pageSortSettingRepository->getAll()->keyBy('page');
        
        $productSortOptions = [
            'price' => 'По возрастанию цены',
            '-price' => 'По убыванию цены',
            'title' => 'По названию',
            'popular_order' => 'По популярности',
            'condition' => 'Сначала новые',
            'stock' => 'В наличии',
        ];

        $brandCatalogSortOptions = [
            'catalog_order' => 'Ручная сортировка',
            'title' => 'По наименованию',
            'created_at' => 'По дате создания',
            'order' => 'По основной сортировке',
        ];

        $sortOptionsByPage = [
            'brand' => $productSortOptions,
            'brand_catalog' => $brandCatalogSortOptions,
            'category' => $productSortOptions,
            'shop' => $productSortOptions,
            'new' => $productSortOptions,
            'popular' => $productSortOptions,
            'sale' => $productSortOptions,
        ];

        $pages = [
            'brand' => 'Бренды',
            'brand_catalog' => 'Каталог брендов',
            'category' => 'Категории',
            'shop' => 'Каталог',
            'new' => 'Новинки',
            'popular' => 'Популярные товары',
            'sale' => 'На акции',
        ];
        
        return view('admin.page_sort_settings', compact('settings', 'sortOptionsByPage', 'pages'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function webUpdate(Request $request)
    {
        $pages = ['brand', 'brand_catalog', 'category', 'shop', 'new', 'popular', 'sale'];
        foreach ($pages as $page) {
            if ($request->has($page)) {
                $this->pageSortSettingRepository->setDefaultSort($page, $request->input($page));
            }
        }
        return redirect()->route('page-setting.page-sort-settings.index')->with('success', 'Настройки сохранены!');
    }
}
