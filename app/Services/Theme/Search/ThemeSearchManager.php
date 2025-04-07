<?php
declare(strict_types=1);

namespace App\Services\Theme\Search;

use App\Data\Theme\Search\ThemeSearchData;
use App\Repositories\Product\ProductRepository;

final class ThemeSearchManager
{
    public function __construct(
        private readonly ProductRepository $productRepository
    ) {
    }

    public function index(ThemeSearchData $themeSearchData)
    {
        return $this->productRepository->getAllBySearch($themeSearchData->search);
    }

    public function getCategoriesFromQuery(ThemeSearchData $themeSearchData)
    {
        return $this->productRepository->getProductCategoryIdsBySearch($themeSearchData->search);
    }
}
