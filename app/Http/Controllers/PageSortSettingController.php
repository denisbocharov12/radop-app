<?php

namespace App\Http\Controllers;

use App\Repositories\PageSortSettingRepository;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PageSortSettingController extends Controller
{
    public function __construct(
        private readonly PageSortSettingRepository $pageSortSettingRepository
    ) {
    }

    public function index(): JsonResponse
    {
        return response()->json($this->pageSortSettingRepository->getAll());
    }

    public function show(string $page): JsonResponse
    {
        $setting = $this->pageSortSettingRepository->getByPage($page);
        if (!$setting) {
            return response()->json(['message' => 'Not found'], 404);
        }
        return response()->json($setting);
    }

    public function update(Request $request, string $page): JsonResponse
    {
        $request->validate([
            'default_sort' => 'required|string',
        ]);
        $setting = $this->pageSortSettingRepository->setDefaultSort($page, $request->input('default_sort'));
        return response()->json($setting);
    }

    public function webIndex()
    {
        $settings = $this->pageSortSettingRepository->getAll()->keyBy('page');
        $sortOptions = [
            'price' => 'По возрастанию цены',
            '-price' => 'По убыванию цены',
            'title' => 'По названию',
            'popular_order' => 'По популярности',
            'condition' => 'Сначала новые',
            'stock' => 'В наличии',
        ];
        $pages = [
            'brand' => 'Бренды',
            'category' => 'Категории',
            'shop' => 'Новинки/Популярные товары/На акции',
        ];
        return view('admin.page_sort_settings', compact('settings', 'sortOptions', 'pages'));
    }

    public function webUpdate(Request $request)
    {
        $pages = ['brand', 'category', 'shop'];
        foreach ($pages as $page) {
            if ($request->has($page)) {
                $this->pageSortSettingRepository->setDefaultSort($page, $request->input($page));
            }
        }
        return redirect()->route('page-setting.page-sort-settings.index')->with('success', 'Настройки сохранены!');
    }
}
