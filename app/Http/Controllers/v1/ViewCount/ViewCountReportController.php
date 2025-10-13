<?php

namespace App\Http\Controllers\v1\ViewCount;

use App\Http\Controllers\Controller;
use App\Http\Requests\ViewCount\ViewCountReportRequest;
use App\Repositories\Brand\BrandRepository;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Product\ProductRepository;
use App\Services\ViewCount\ViewCountReportManager;
use Illuminate\Http\JsonResponse;

final class ViewCountReportController extends Controller
{
    public function __construct(
        private readonly ViewCountReportManager $viewCountReportManager,
        private readonly ProductRepository $productRepository,
        private readonly BrandRepository $brandRepository,
        private readonly CategoryRepository $categoryRepository,
    ) {
    }

    /**
     * @param ViewCountReportRequest $request
     * @return JsonResponse
     */
    public function generateProductReport(ViewCountReportRequest $request): JsonResponse
    {
        $reportData = $this->viewCountReportManager->generateProductReport(
            $request->get('start_date'),
            $request->get('end_date'),
            $request->get('product_id'),
            $request->get('category_id')
        );

        return response()->json([
            'success' => true,
            'message' => 'Отчет по просмотрам товаров успешно сгенерирован',
            'data' => $reportData
        ]);
    }

    /**
     * @param ViewCountReportRequest $request
     * @return JsonResponse
     */
    public function generateBrandReport(ViewCountReportRequest $request): JsonResponse
    {
        $reportData = $this->viewCountReportManager->generateBrandReport(
            $request->get('start_date'),
            $request->get('end_date'),
            $request->get('brand_id')
        );

        return response()->json([
            'success' => true,
            'message' => 'Отчет по просмотрам брендов успешно сгенерирован',
            'data' => $reportData
        ]);
    }

    /**
     * @param ViewCountReportRequest $request
     * @return JsonResponse
     */
    public function generateCategoryReport(ViewCountReportRequest $request): JsonResponse
    {
        $reportData = $this->viewCountReportManager->generateCategoryReport(
            $request->get('start_date'),
            $request->get('end_date'),
            $request->get('category_id')
        );

        return response()->json([
            'success' => true,
            'message' => 'Отчет по просмотрам категорий успешно сгенерирован',
            'data' => $reportData
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function productIndex()
    {
        $products = $this->productRepository->getAllWithViewCounts();
        $categories = $this->categoryRepository->getAll();

        return view('reports.view-count.product.index', compact('products', 'categories'));
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function brandIndex()
    {
        $brands = $this->brandRepository->getAllWithViewCounts();

        return view('reports.view-count.brand.index', compact('brands'));
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function categoryIndex()
    {
        $categories = $this->categoryRepository->getAllWithViewCounts();

        return view('reports.view-count.category.index', compact('categories'));
    }
}
