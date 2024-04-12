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
use App\Http\Requests\Media\ModelMediaDeleteRequest;
use App\Http\Requests\Product\ProductDeleteRequest;
use App\Http\Requests\Product\ProductIndexRequest;
use App\Http\Requests\Product\ProductMediaDeleteRequest;
use App\Http\Requests\Product\ProductRequest;
use App\Models\Product;
use App\Models\ProductProfile;
use App\Repositories\Brand\BrandRepository;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Product\ProductRepository;
use App\Services\Product\ProductManager;

class ProductController extends Controller
{
    private ProductRepository $productRepository;
    private ProductManager $productManager;
    private ProductDataMapper $productDataMapper;
    private CategoryRepository $categoryRepository;
    private BrandRepository $brandRepository;

    public function __construct(
        ProductRepository                  $productRepository,
        ProductManager                     $productManager,
        ProductDataMapper                  $productDataMapper,
        CategoryRepository                 $categoryRepository,
        BrandRepository                    $brandRepository,
        private readonly ProductConditions $productConditions,
    )
    {
        $this->productRepository = $productRepository;
        $this->productManager = $productManager;
        $this->productDataMapper = $productDataMapper;
        $this->categoryRepository = $categoryRepository;
        $this->brandRepository = $brandRepository;
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

        return view('product.edit', compact(['product', 'products', 'categories', 'brands', 'productConditions',]));
    }

    public function update(ProductRequest $request, Product $product)
    {
        $productData = $this->productDataMapper->mapFromRequestToNormalized($request);

        try {
            $this->productManager->update($productData, $product, $request );

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
}
