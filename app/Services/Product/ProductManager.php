<?php

namespace App\Services\Product;

use App\Data\Product\ProductData;
use App\Exceptions\Attachments\AttachmentNotFoundException;
use App\Exceptions\Brand\BrandNotFoundException;
use App\Exceptions\Category\CategoryNotFoundException;
use App\Exceptions\Product\ProductNotFoundException;
use App\Http\Requests\Category\CategoryDeleteRequest;
use App\Http\Requests\Media\ModelMediaDeleteRequest;
use App\Http\Requests\Product\ProductDeleteRequest;
use App\Http\Requests\Product\ProductMediaDeleteRequest;
use App\Http\Requests\Product\ProductRequest;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductProfile;
use App\Repositories\Attachments\AttachmentsRepository;
use App\Repositories\Brand\BrandRepository;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Product\ProductRepository;
use App\Services\Attachments\AttachmentsManager;
use App\Services\EntityStatusManager;
use App\Services\ONEC\ONECManager;
use Illuminate\Support\Str;

class ProductManager
{
    private CategoryRepository $categoryRepository;
    private ProductRepository $productRepository;
    private BrandRepository $brandRepository;
    private AttachmentsManager $attachmentsManager;
    private AttachmentsRepository $attachmentsRepository;
    private EntityStatusManager $entityStatusManager;

    public function __construct(
        CategoryRepository    $categoryRepository,
        ProductRepository     $productRepository,
        BrandRepository       $brandRepository,
        AttachmentsManager    $attachmentsManager,
        AttachmentsRepository $attachmentsRepository,
        EntityStatusManager   $entityStatusManager,
        private readonly ONECManager $ONECManager,
    )
    {
        $this->categoryRepository = $categoryRepository;
        $this->productRepository = $productRepository;
        $this->brandRepository = $brandRepository;
        $this->attachmentsManager = $attachmentsManager;
        $this->attachmentsRepository = $attachmentsRepository;
        $this->entityStatusManager = $entityStatusManager;
    }

    public function store(ProductData $productData, ProductRequest $request): void
    {
        $existedCategory = $this->categoryRepository->getByOnecId($productData->categoryId);

        if ($existedCategory === null) {
            throw new CategoryNotFoundException();
        }

        $existedBrand = $this->brandRepository->getByOnecId($productData->brandId);

        if ($existedBrand === null) {
            throw new BrandNotFoundException();
        }

        $status = $this->entityStatusManager->getEntityStatusFromRequest($productData->status);
        $siteStatus = $this->entityStatusManager->getEntityStatusFromRequest($productData->siteStatus);

        $product = Product::create([
            'title' => [
                'ro' => $productData->title_ro,
                'ru' => $productData->title_ru
            ],
            'stock' => $productData->stock,
            'unit' => $productData->unit,
            'price' => $productData->price,
            'sale_price' => $productData->salePrice,
            'status' => $status,
            'site_status' => $siteStatus,
            'brand_id' => $existedBrand->onec_id,
            'shtrih_code' => $productData->shtrih_code,
        ]);

        $product->slug = Str::slug($productData->title_ru) . '-' . $product->id;

        $product->save();

        $productOneCId = $this->ONECManager->getOneCIdForCreate($product);

        $product->update([
            'onec_id' => $productOneCId
        ]);

        $productProfile = ProductProfile::create([
            'product_id' => $productOneCId,
            'sku' => $productData->sku,
            'summary' => [
                'ro' => $productData->summary_ro,
                'ru' => $productData->summary_ru,
            ],
            'description' => $productData->description,
            'upp_sale' => json_encode($productData->uppSale),
            'iur_price' => $productData->iurPrice,
            'condition' => $productData->condition,
        ]);

        $productProfile->save();

        $this->attachCategoriesToProduct($product, $productData->categoryId);

        $this->attachmentsManager->storeToMediaAttachmentsFromRequestToModel($request, $product);
    }

    public function update(ProductData $productData, Product $product, ProductRequest $request): void
    {
        $existedCategory = $this->categoryRepository->getByOnecId($productData->categoryId);

        if ($existedCategory === null) {
            throw new CategoryNotFoundException();
        }

        $existedBrand = $this->brandRepository->getByOnecId($productData->brandId);

        if ($existedBrand === null) {
            throw new BrandNotFoundException();
        }

        $status = $this->entityStatusManager->getEntityStatusFromRequest($productData->status);
        $siteStatus = $this->entityStatusManager->getEntityStatusFromRequest($productData->siteStatus);

        $product->update([
            'title' => [
                'ro' => $productData->title_ro,
                'ru' => $productData->title_ru
            ],
            'stock' => $productData->stock,
            'unit' => $productData->unit,
            'price' => $productData->price,
            'sale_price' => $productData->salePrice,
            'status' => $status,
            'site_status' => $siteStatus,
            'brand_id' => $existedBrand->onec_id,
            'shtrih_code' => $productData->shtrih_code,
        ]);

        $product->slug = Str::slug($productData->title_ru) . '-' . $product->id;
        $product->save();

        $product->data->update([
            'sku' => $productData->sku,
            'summary' => [
                'ro' => $productData->summary_ro,
                'ru' => $productData->summary_ru,
            ],
            'description' => $productData->description,
            'upp_sale' => json_encode($productData->uppSale),
            'iur_price' => $productData->iurPrice,
            'condition' => $productData->condition,
        ]);


        //$this->syncCategoriesToProduct($product, $productData->categoryId);

        $this->attachmentsManager->storeToMediaAttachmentsFromRequestToModel($request, $product);
    }

    public function delete(ProductDeleteRequest $request): void
    {
        $productId = (int)$request->product_id;

        $product = $this->productRepository->getById($productId);

        if ($product === null) {
            throw new ProductNotFoundException();
        }

        $this->detachCategoriesFromProduct($product);

        $product->delete();
    }

    public function deleteMediaFromProduct(ModelMediaDeleteRequest $request, Product $product): void
    {
        $existedAttachment = $this->attachmentsRepository->getById($product, (int)$request->id);

        if ($existedAttachment === null) {
            throw new AttachmentNotFoundException();
        }

        $this->attachmentsManager->deleteAttachmentsFromModel($product, (int)$request->id);
    }

    private function attachCategoriesToProduct(Product $product, array $categories): void
    {
        foreach ($categories as $category)
        {
            ProductCategory::create([
                'product_id' => $product->onec_id,
                'category_id' => $category
            ]);
        }
    }

    private function syncCategoriesToProduct(Product $product, array $categories): void
    {
        $existedProductCategories = $this->productRepository->getProductCategoryByProductOnecId($product->onec_id);

        foreach ($existedProductCategories as $item)
        {
            $item->delete();
        }

        foreach ($categories as $category)
        {
            ProductCategory::create([
                'product_id' => $product->onec_id,
                'category_id' => $category
            ]);
        }
    }

    private function detachCategoriesFromProduct(Product $product): void
    {
        $existedProductCategories = $this->productRepository->getProductCategoryByProductOnecId($product->onec_id);

        foreach ($existedProductCategories as $item)
        {
            $item->delete();
        }
    }
}
