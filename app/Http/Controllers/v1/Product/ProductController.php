<?php

namespace App\Http\Controllers\v1\Product;

use App\Enums\ProductConditions;
use App\Exceptions\Attachments\AttachmentNotFoundException;
use App\Exceptions\Attachments\AttachmentNotFoundValidationException;
use App\Exceptions\Brand\BrandNotFoundException;
use App\Exceptions\Brand\BrandNotFoundValidationException;
use App\Exceptions\Category\CategoryNotFoundException;
use App\Exceptions\Category\CategoryNotFoundValidationException;
use App\Exceptions\NotAjaxRequestException;
use App\Exceptions\Product\ProductNotFoundException;
use App\Exceptions\Product\ProductNotFoundValidationException;
use App\Http\Controllers\Controller;
use App\Http\Mappers\ProductDataMapper;
use App\Http\Mappers\Product\UpdateProductConditionDataMapper;
use App\Http\Requests\Product\UpdateProductConditionsRequest;
use App\Http\Requests\Media\ModelMediaDeleteRequest;
use App\Http\Requests\Product\ProductDeleteRequest;
use App\Http\Requests\Product\ProductIndexRequest;
use App\Http\Requests\Product\ProductRequest;
use App\Models\Product;
use App\Repositories\Brand\BrandRepository;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Product\ProductRepository;
use App\Services\Product\ProductManager;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(
        private readonly ProductRepository $productRepository,
        private readonly ProductManager $productManager,
        private readonly ProductDataMapper $productDataMapper,
        private readonly CategoryRepository $categoryRepository,
        private readonly BrandRepository $brandRepository,
        private readonly ProductConditions $productConditions,
        private readonly UpdateProductConditionDataMapper $updateProductConditionDataMapper,
    ) {
    }

    public function index(ProductIndexRequest $request)
    {
        $query = $request->query('filter');

        $products = $this->productRepository->getAllPaginatedWithFilters();
        $categories = $this->categoryRepository->getAll();
        $brands = $this->brandRepository->getAll();

        $productConditions = $this->productConditions->getAll();

        return view('product.index', compact([
            'products',
            'categories',
            'brands',
            'query',
            'productConditions',
        ]));
    }

    public function store(ProductRequest $request)
    {
        $productData = $this->productDataMapper->mapFromRequestToNormalized($request);

        try {
            $this->productManager->store($productData, $request);

            return redirect()->route('product.index');
        } catch (CategoryNotFoundException $e) {
            throw new CategoryNotFoundValidationException();
        } catch (BrandNotFoundException $e) {
            throw new BrandNotFoundValidationException();
        }
    }

    public function edit(Product $product)
    {
        $categories = $this->categoryRepository->getAll();
        $brands = $this->brandRepository->getAll();
        $products = $this->productRepository->getAllExcluded($product->id);
        $productConditions = $this->productConditions->getAll();

        return view('product.edit', compact([
            'product',
            'products',
            'categories',
            'brands',
            'productConditions'
        ]));
    }

    public function update(ProductRequest $request, Product $product)
    {
        $productData = $this->productDataMapper->mapFromRequestToNormalized($request);

        try {
            $this->productManager->update($productData, $product, $request);

            return redirect()->route('product.index');
        } catch (CategoryNotFoundException $e) {
            throw new CategoryNotFoundValidationException();
        } catch (BrandNotFoundException $e) {
            throw new BrandNotFoundValidationException();
        }
    }

    public function destroy(ProductDeleteRequest $request)
    {
        if (!$request->ajax()) {
            throw new NotAjaxRequestException();
        }

        try {
            $this->productManager->delete($request);

            return response()->json(['id' => $request->product_id]);
        } catch (ProductNotFoundException $e) {
            throw new ProductNotFoundValidationException();
        }
    }

    public function deleteProductMedia(ModelMediaDeleteRequest $request, Product $product)
    {
        try {
            $this->productManager->deleteMediaFromProduct($request, $product);

            return response()->json(['status' => true]);
        } catch (AttachmentNotFoundException $e) {
            throw new AttachmentNotFoundValidationException();
        }
    }

    public function updateProductConditions(UpdateProductConditionsRequest $request)
    {
        $data = $this->updateProductConditionDataMapper->mapFromRequestToNormalized($request);

        $this->productManager->updateProductConditions($data);

        return response()->json(['status' => 'success']);
    }

    public function sortFeatured()
    {
        $products = $this->productRepository->getAllFeaturedProductsWithoutLimit();

        return view('product.sort-featured', compact([
            'products',
        ]));
    }

    public function sortFeaturedOrder(Request $request)
    {
        $products = $this->productRepository->getAllFeaturedProductsWithoutLimit();

        foreach ($products as $product) {
            foreach ($request->order as $order) {
                if ($order['id'] == $product->id) {
                    $product->update(['featured_order' => $order['position']]);
                }
            }
        }

        return response()->json(['status' => true, 'text' => 'Товары успешно отсортированы']);
    }

    public function sortSale()
    {
        $products = $this->productRepository->getAllDiscountProductsWithoutLimit();

        return view('product.sort-sale', compact([
            'products',
        ]));
    }

    public function sortSaleOrder(Request $request)
    {
        $products = $this->productRepository->getAllDiscountProductsWithoutLimit();

        foreach ($products as $product) {
            foreach ($request->order as $order) {
                if ($order['id'] == $product->id) {
                    $product->update(['sale_order' => $order['position']]);
                }
            }
        }

        return response()->json(['status' => true, 'text' => 'Товары успешно отсортированы']);
    }

    public function sortPopular()
    {
        $products = $this->productRepository->getAllPopularProductsWithoutLimit();

        return view('product.sort-popular', compact([
            'products',
        ]));
    }

    public function sortPopularOrder(Request $request)
    {
        $products = $this->productRepository->getAllPopularProductsWithoutLimit();

        foreach ($products as $product) {
            foreach ($request->order as $order) {
                if ($order['id'] == $product->id) {
                    $product->update(['popular_order' => $order['position']]);
                }
            }
        }

        return response()->json(['status' => true, 'text' => 'Товары успешно отсортированы']);
    }

    public function sortNew()
    {
        $products = $this->productRepository->getAllNewProductsWithoutLimit();

        return view('product.sort-new', compact([
            'products',
        ]));
    }

    public function sortNewOrder(Request $request)
    {
        $products = $this->productRepository->getAllNewProductsWithoutLimit();

        foreach ($products as $product) {
            foreach ($request->order as $order) {
                if ($order['id'] == $product->id) {
                    $product->update(['new_order' => $order['position']]);
                }
            }
        }

        return response()->json(['status' => true, 'text' => 'Товары успешно отсортированы']);
    }

    public function sortHot()
    {
        $products = $this->productRepository->getAllHotProductsWithoutLimit();

        return view('product.sort-hot', compact([
            'products',
        ]));
    }

    public function sortHotOrder(Request $request)
    {
        $products = $this->productRepository->getAllHotProductsWithoutLimit();

        foreach ($products as $product) {
            foreach ($request->order as $order) {
                if ($order['id'] == $product->id) {
                    $product->update(['hot_order' => $order['position']]);
                }
            }
        }

        return response()->json(['status' => true, 'text' => 'Товары успешно отсортированы']);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function exportDescriptions()
    {
        $products = Product::with('data')->whereHas('data')->get();

        $exportData = [];

        foreach ($products as $product) {
            if ($product->data && $product->onec_id) {
                $exportData[] = [
                    'id' => $product->onec_id,
                    'descr_ru' => $product->data->getTranslation('summary', 'ru') ?? '',
                    'descr_ro' => $product->data->getTranslation('summary', 'ro') ?? '',
                ];
            }
        }

        $fileName = 'product_descriptions_' . date('Y-m-d_H-i-s') . '.json';

        return response()->json([
            'Description' => $exportData
        ], 200, [
            'Content-Type' => 'application/json',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"'
        ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
}
