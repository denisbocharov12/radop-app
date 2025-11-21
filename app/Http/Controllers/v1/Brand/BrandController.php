<?php

namespace App\Http\Controllers\v1\Brand;

use App\Exceptions\Attachments\AttachmentNotFoundException;
use App\Exceptions\Attachments\AttachmentNotFoundValidationException;
use App\Exceptions\Brand\BrandNotFoundException;
use App\Exceptions\Brand\BrandNotFoundValidationException;
use App\Exceptions\Brand\BrandUniqueNameException;
use App\Exceptions\Brand\BrandUniqueNameValidationException;
use App\Exceptions\NotAjaxRequestException;
use App\Http\Controllers\Controller;
use App\Http\Mappers\BrandDataMapper;
use App\Http\Requests\Brand\BrandDeleteRequest;
use App\Http\Requests\Brand\BrandRequest;
use App\Http\Requests\Media\ModelMediaDeleteRequest;
use App\Jobs\GenerateManagerBrandExportJob;
use App\Models\Brand;
use App\Models\User;
use App\Repositories\Brand\BrandRepository;
use App\Repositories\Product\ProductRepository;
use App\Services\Brand\BrandManager;
use Illuminate\Http\Request;

final class BrandController extends Controller
{
    private BrandRepository $brandRepository;
    private BrandManager $brandManager;
    private BrandDataMapper $brandDataMapper;
    private ProductRepository $productRepository;

    public function __construct(
        BrandRepository $brandRepository,
        BrandManager $brandManager,
        BrandDataMapper $brandDataMapper,
        ProductRepository $productRepository
    )
    {
        $this->brandRepository = $brandRepository;
        $this->brandManager = $brandManager;
        $this->brandDataMapper = $brandDataMapper;
        $this->productRepository = $productRepository;
    }

    public function index(Request $request)
    {
        $query = $request->query('filter');
        $brands = $this->brandRepository->getAllPaginatedWithFilters();

        return view('brand.index', compact([
            'brands',
            'query'
        ]));
    }

    public function store(BrandRequest $request)
    {
        $brandData = $this->brandDataMapper->mapFromRequestToNormalized($request);

        try {
            $this->brandManager->store($brandData, $request);

            return redirect()->route('brand.index');
        } catch (BrandUniqueNameException $e) {
            throw new BrandUniqueNameValidationException();
        }
    }

    public function edit(Brand $brand)
    {
        return view('brand.edit', compact([
            'brand'
        ]));
    }

    public function update(BrandRequest $request, Brand $brand)
    {
        $brandData = $this->brandDataMapper->mapFromRequestToNormalized($request);

        try {
            $this->brandManager->update($brandData, $brand, $request);

            return redirect()->route('brand.index');
        } catch (BrandUniqueNameException $e) {
            throw new BrandUniqueNameValidationException();
        }
    }

    public function destroy(BrandDeleteRequest $request)
    {
        if (!$request->ajax())
        {
            throw new NotAjaxRequestException();
        }

        try {
            $this->brandManager->delete($request);

            return response()->json(['id' => $request->brand_id]);
        } catch (BrandNotFoundException $e) {
            throw new BrandNotFoundValidationException();
        }
    }
    public function deleteMedia(ModelMediaDeleteRequest $request, Brand $brand)
    {
        try {
            $this->brandManager->deleteMediaFromBrand($request, $brand);

            return response()->json(['status' => true]);
        } catch (AttachmentNotFoundException $e) {
            throw new AttachmentNotFoundValidationException();
        }
    }

    public function sortBrand()
    {
        $brands = $this->brandRepository->getAllForSort();

        return view('brand.sort', compact([
            'brands',
        ]));
    }

    public function sortBrandOrder(Request $request)
    {
        $brands = $this->brandRepository->getAllForSort();

        foreach ($brands as $brand) {
            foreach ($request->order as $order) {
                if ($order['id'] == $brand->id) {
                    $brand->update(['order' => $order['position']]);
                }
            }
        }

        return response()->json(['status' => true, 'text' => 'Бренды успешно отсортированы']);
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function sortCatalog()
    {
        $brands = $this->brandRepository->getAllForCatalogSort();

        return view('brand.sort-catalog', compact([
            'brands',
        ]));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sortCatalogOrder(Request $request)
    {
        $brands = $this->brandRepository->getAllForCatalogSort();

        foreach ($brands as $brand) {
            foreach ($request->order as $order) {
                if ($order['id'] == $brand->id) {
                    $brand->update(['catalog_order' => $order['position']]);
                }
            }
        }

        return response()->json(['status' => true, 'text' => 'Бренды каталога успешно отсортированы']);
    }

    /**
     * @param Brand $brand
     * @return \Illuminate\Http\JsonResponse
     * @throws BrandNotFoundException
     */
    public function exportOneCPrices(Brand $brand)
    {
        $manager = auth()->user();

        if (!$manager) {
            return response()->json([
                'success' => false,
                'message' => 'Необходима авторизация',
            ], 401);
        }

        if (!$brand) {
            throw new BrandNotFoundException();
        }

        $products = $this->productRepository->getAllProductsByBrand($brand);

        if ($products->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'У бренда нет товаров',
            ], 404);
        }

        $locale = app()->getLocale();

        GenerateManagerBrandExportJob::dispatch(
            $products,
            (string)$brand->id,
            $locale,
            $manager
        )->onQueue('high');

        return response()->json([
            'success' => true,
            'message' => 'Экспорт запущен. Файл будет создан и доступен в разделе "Экспорты менеджеров".',
        ]);
    }
}
