<?php

namespace App\Services\Favorite;

use App\Data\Favorite\FavoriteData;
use App\Exceptions\Favorite\FavoriteNotFoundException;
use App\Exceptions\Product\ProductNotFoundException;
use App\Models\Favorite;
use App\Models\Product;
use App\Repositories\Favorite\FavoriteRepository;
use App\Repositories\Product\ProductRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\Auth;

class FavoriteManager
{
    public function __construct(
        private readonly FavoriteRepository $favoriteRepository,
        private readonly UserRepository $userRepository,
        private readonly ProductRepository $productRepository,
    ) {
    }

    public function addToList(FavoriteData $favoriteData): array
    {
        $response = [];

        $user = Auth::guard('user')->user();

        $existedProduct = $this->productRepository->getById($favoriteData->productId);

        if ($existedProduct === null) {
            throw new ProductNotFoundException();
        }

        $existedFavorite = $this->favoriteRepository->getByUserIdAndProductId($user->id, $favoriteData->productId);

        if ($existedFavorite !== null) {
            throw new FavoriteNotFoundException();
        }

        $favorite = Favorite::create([
            'user_id' => $user->id,
            'product_id' => $favoriteData->productId,
        ]);

        $response['status'] = true;
        $response['product_id'] = $favoriteData->productId;
        $response['product_title'] = $existedProduct->title;

        return $response;
    }

    public function deleteFromList(FavoriteData $favoriteData): array
    {
        $response = [];

        $user = Auth::guard('user')->user();

        $existedProduct = $this->productRepository->getById($favoriteData->productId);

        if ($existedProduct === null) {
            throw new ProductNotFoundException();
        }

        $existedFavorite = $this->favoriteRepository->getByUserIdAndProductId($user->id, $favoriteData->productId);

        if ($existedFavorite !== null) {
            throw new FavoriteNotFoundException();
        }

        return $response;
    }
}
