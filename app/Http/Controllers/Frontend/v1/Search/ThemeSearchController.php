<?php
declare(strict_types=1);

namespace App\Http\Controllers\Frontend\v1\Search;

use App\Http\Controllers\Controller;
use App\Http\Mappers\Theme\ThemeSearchDataMapper;
use App\Http\Requests\Theme\Search\ThemeSearchRequest;
use App\Services\Theme\Search\ThemeSearchManager;

final class ThemeSearchController extends Controller
{
    public function __construct(
        private readonly ThemeSearchManager $themeSearchManager,
        private readonly ThemeSearchDataMapper $themeSearchDataMapper
    )
    {
    }

    public function index(ThemeSearchRequest $request)
    {
        $themeSearchData = $this->themeSearchDataMapper->mapFromRequestToNormalized($request);

        $products = $this->themeSearchManager->index($themeSearchData);

        return view('frontend.v1.pages.search.index', compact([
            'products',
            'themeSearchData',
        ]));
    }
}
