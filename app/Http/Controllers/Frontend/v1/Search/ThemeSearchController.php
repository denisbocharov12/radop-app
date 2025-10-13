<?php
declare(strict_types=1);

namespace App\Http\Controllers\Frontend\v1\Search;

use App\Enums\PageTypes;
use App\Http\Controllers\Controller;
use App\Http\Mappers\Theme\ThemeSearchDataMapper;
use App\Http\Requests\Theme\Search\ThemeSearchRequest;
use App\Repositories\SeoMetaRepository;
use App\Services\Theme\Search\ThemeSearchManager;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Traits\SEOTools;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class ThemeSearchController extends Controller
{
    use SEOTools;

    private const SEARCH_HISTORY_KEY = 'search_history';
    private const MAX_HISTORY_ITEMS = 10;

    public function __construct(
        private readonly ThemeSearchManager $themeSearchManager,
        private readonly ThemeSearchDataMapper $themeSearchDataMapper,
        private readonly SeoMetaRepository $seoMetaRepository,
        private readonly PageTypes $pageTypes,
    )
    {
    }

    public function index(ThemeSearchRequest $request)
    {
        $themeSearchData = $this->themeSearchDataMapper->mapFromRequestToNormalized($request);

        $products = $this->themeSearchManager->index($themeSearchData);
        $categories = $this->themeSearchManager->getCategoriesFromQuery($themeSearchData);

        $searchQuery = $request->get('search');
        if (!empty($searchQuery)) {
            $this->saveSearchQuery($searchQuery);
        }

        $seo = $this->seoMetaRepository->getStatic($this->pageTypes->getSearchType(), app()->getLocale());

        if ($seo !== null) {
            $this->seo()->setTitle($seo->title ?? trans('seo.title', [], app()->getLocale()));
            $this->seo()->setDescription($seo->description ?? trans('seo.description', [], app()->getLocale()));
            $this->seo()->addImages($seo->getFirstMediaUrl('files') ?? config('seotools.meta.defaults.default_image'));

            (array)$seoKeywords = $seo?->keywords !== null && $seo?->keywords !== '' ? explode(',', $seo?->keywords) : trans('seo.keywords', [], app()->getLocale());

            SEOMeta::setKeywords($seoKeywords);

            $this->seo()->opengraph()->setUrl(route('theme.search.index'));
            $this->seo()->opengraph()->addProperty('type', 'search');
            $this->seo()->jsonLd()->setType('SearchResultsPage');
        }

        return view('frontend.v1.pages.search.index', compact([
            'products',
            'themeSearchData',
            'categories'
        ]));
    }

    /**
     * @param string $query
     * @return void
     */
    private function saveSearchQuery(string $query): void
    {
        $query = trim($query);
        
        if (empty($query)) {
            return;
        }

        $history = session()->get(self::SEARCH_HISTORY_KEY, []);

        $history = array_filter($history, fn($item) => $item !== $query);

        array_unshift($history, $query);

        $history = array_slice($history, 0, self::MAX_HISTORY_ITEMS);

        session()->put(self::SEARCH_HISTORY_KEY, $history);
    }

    /**
     * @return JsonResponse
     */
    public function getHistory(): JsonResponse
    {
        $history = session()->get(self::SEARCH_HISTORY_KEY, []);

        return response()->json([
            'success' => true,
            'data' => array_values($history)
        ]);
    }

    /**
     * @return JsonResponse
     */
    public function clearHistory(): JsonResponse
    {
        session()->forget(self::SEARCH_HISTORY_KEY);

        return response()->json([
            'success' => true,
            'message' => __('theme.search_history_cleared')
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteHistoryItem(Request $request): JsonResponse
    {
        $query = $request->input('query');

        if (empty($query)) {
            return response()->json([
                'success' => false,
                'message' => __('theme.search_query_not_specified')
            ], 400);
        }

        $history = session()->get(self::SEARCH_HISTORY_KEY, []);
        $history = array_filter($history, fn($item) => $item !== $query);
        $history = array_values($history);

        session()->put(self::SEARCH_HISTORY_KEY, $history);

        return response()->json([
            'success' => true,
            'message' => __('theme.search_history_item_deleted')
        ]);
    }
}
