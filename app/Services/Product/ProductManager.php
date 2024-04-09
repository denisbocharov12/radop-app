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
        $existedCategory = $this->categoryRepository->getById($productData->category_id);

        if ($existedCategory === null) {
            throw new CategoryNotFoundException();
        }

        $existedBrand = $this->brandRepository->getById($productData->brand_id);

        if ($existedBrand === null) {
            throw new BrandNotFoundException();
        }

        $status = $this->entityStatusManager->getEntityStatusFromRequest($productData->status);

        $product = Product::create([
            'title' => $productData->title,
            'slug' => Str::slug($productData->title),
            'stock' => $productData->stock,
            'unit' => $productData->unit,
            'price' => $productData->price,
            'sale_price' => $productData->sale_price,
            'status' => $status,
            'brand_id' => $existedBrand->id,
            'category_id' => $existedCategory->id,
        ]);
        $product->slug = Str::slug($productData->title) . '-' . $product->id;
        $product->save();

        $productOneCId = $this->ONECManager->getOneCIdForCreate($product);

        $product->update([
            'onec_id' => $productOneCId
        ]);

        $this->attachmentsManager->storeToMediaAttachmentsFromRequestToModel($request, $product);
    }

    public function update(ProductData $productData, Product $product, ProductRequest $request): void
    {
        $existedCategory = $this->categoryRepository->getById($productData->category_id);

        if ($existedCategory === null) {
            throw new CategoryNotFoundException();
        }

        $existedBrand = $this->brandRepository->getById($productData->brand_id);

        if ($existedBrand === null) {
            throw new BrandNotFoundException();
        }

        $status = $this->entityStatusManager->getEntityStatusFromRequest($productData->status);

        $product->update([
            'title' => $productData->title,
            'stock' => $productData->stock,
            'unit' => $productData->unit,
            'price' => $productData->price,
            'sale_price' => $productData->sale_price,
            'status' => $status,
            'brand_id' => $existedBrand->id,
            'category_id' => $existedCategory->id,
        ]);

        $product->slug = Str::slug($productData->title) . '-' . $product->id;
        $product->save();

        $this->attachmentsManager->storeToMediaAttachmentsFromRequestToModel($request, $product);
    }

    public function delete(ProductDeleteRequest $request): void
    {
        $productId = (int)$request->product_id;

        $product = $this->productRepository->getById($productId);

        if ($product === null) {
            throw new ProductNotFoundException();
        }

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
}
