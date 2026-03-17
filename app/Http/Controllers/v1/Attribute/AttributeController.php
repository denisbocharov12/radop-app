<?php

namespace App\Http\Controllers\v1\Attribute;

use App\Http\Controllers\Controller;
use App\Http\Mappers\Attribute\AttributeCategorySortOrderDataMapper;
use App\Http\Requests\Attribute\AttributeCategorySortOrderRequest;
use App\Http\Requests\Attribute\AttributeSortByCategoryRequest;
use App\Models\Attribute;
use App\Repositories\Attribute\AttributeRepository;
use App\Services\Attribute\AttributeManager;
use Illuminate\Http\Request;

final class AttributeController extends Controller
{
    public function __construct(
        private readonly AttributeRepository $attributeRepository,
        private readonly AttributeManager $attributeManager,
        private readonly AttributeCategorySortOrderDataMapper $attributeCategorySortOrderDataMapper,
    ) {
    }
    public function index()
    {
        $attributes = $this->attributeRepository->getAllPaginatedWithFilters();

        return view('attribute.index', compact([
            'attributes',
        ]));
    }

    public function sort()
    {
        $attributes = $this->attributeRepository->getAllSorted();

        return view('attribute.sort', compact([
            'attributes',
        ]));
    }

    public function sortOrder(Request $request)
    {
        $validated = $request->validate([
            'order' => ['required', 'array'],
            'order.*.id' => ['required', 'integer', 'exists:attributes,id'],
            'order.*.position' => ['required', 'integer', 'min:0'],
        ]);

        foreach ($validated['order'] as $item) {
            Attribute::where('id', $item['id'])->update(['global_sort_order' => $item['position']]);
        }

        return response()->json(['status' => true, 'text' => 'Атрибуты успешно отсортированы']);
    }

    /**
     * @param AttributeSortByCategoryRequest $request
     * @return \Illuminate\Contracts\View\View
     */
    public function sortByCategory(AttributeSortByCategoryRequest $request): \Illuminate\Contracts\View\View
    {
        $pageData = $this->attributeManager->getSortByCategoryPageData($request->validated('category'));

        return view('attribute.sort-by-category', [
            'categories' => $pageData->categories,
            'selectedCategory' => $pageData->selectedCategory,
            'attributesForSort' => $pageData->attributesForSort,
        ]);
    }

    /**
     * @param AttributeCategorySortOrderRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sortByCategoryOrder(AttributeCategorySortOrderRequest $request): \Illuminate\Http\JsonResponse
    {
        $data = $this->attributeCategorySortOrderDataMapper->mapFromRequestToNormalized($request);
        $this->attributeManager->saveCategoryAttributeOrder($data);

        return response()->json(['status' => true, 'text' => 'Порядок атрибутов категории сохранён']);
    }
}
