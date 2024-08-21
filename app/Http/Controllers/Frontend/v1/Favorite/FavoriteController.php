<?php

namespace App\Http\Controllers\Frontend\v1\Favorite;

use App\Exceptions\Favorite\FavoriteNotFoundException;
use App\Exceptions\Product\ProductNotFoundException;
use App\Exceptions\Product\ProductNotFoundValidationException;
use App\Http\Controllers\Controller;
use App\Http\Mappers\FavoriteDataMapper;
use App\Http\Requests\Favorite\FavoriteRequest;
use App\Repositories\Favorite\FavoriteRepository;
use App\Services\Favorite\FavoriteManager;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function __construct(
        private readonly FavoriteRepository $favoriteRepository,
        private readonly FavoriteManager $favoriteManager,
        private readonly FavoriteDataMapper $favoriteDataMapper,
    )
    {
    }

    public function index()
    {
        $user = Auth::guard('user')->user();

        $favorites = $this->favoriteRepository->getByUserId($user->id);

        return view('frontend.v1.pages.favorite.index', compact([
            'favorites',
        ]));
    }

    public function addToList(FavoriteRequest $request)
    {
        $favoriteData = $this->favoriteDataMapper->mapFromRequestToNormalized($request);

        try {
            $response = $this->favoriteManager->addToList($favoriteData);

            return response()->json($response);

        } catch (FavoriteNotFoundException) {
            return response()->json($response);
        } catch (ProductNotFoundException) {
            throw new ProductNotFoundValidationException();
        }

    }

    public function deleteFromList(FavoriteRequest $request)
    {
        $favoriteData = $this->favoriteDataMapper->mapFromRequestToNormalized($request);

        try {
            $response = $this->favoriteManager->deleteFromList($favoriteData);

            return response()->json($response);
        } catch (ProductNotFoundException) {
            throw new ProductNotFoundValidationException();
        }
    }
}
