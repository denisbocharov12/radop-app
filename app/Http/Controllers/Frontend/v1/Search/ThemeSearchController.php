<?php
declare(strict_types=1);

namespace App\Http\Controllers\Frontend\v1\Search;

use App\Enums\PageTypes;
use App\Http\Controllers\Controller;
use App\Http\Mappers\Theme\ThemeSearchDataMapper;
use App\Http\Requests\Theme\Search\ThemeSearchRequest;
use App\Repositories\SeoMetaRepository;
use App\Services\Analytics\Ga4EcommercePayloadBuilder;
use App\Services\Theme\Search\ThemeSearchManager;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Traits\SEOTools;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class ThemeSearchController extends Controller
{
    use SEOTools;

    private const SEARCH_HISTORY_KEY = 'search_history';
    private const MAX_HISTORY_ITEMS = 5;

    public function __construct(
        private readonly ThemeSearchManager $themeSearchManager,
        private readonly ThemeSearchDataMapper $themeSearchDataMapper,
        private readonly SeoMetaRepository $seoMetaRepository,
        private readonly PageTypes $pageTypes,
        private readonly Ga4EcommercePayloadBuilder $ga4EcommercePayloadBuilder,
    )
    {
    }

    public function index(ThemeSearchRequest $request)
    {
        $themeSearchData = $this->themeSearchDataMapper->mapFromRequestToNormalized($request);

        $products = $this->themeSearchManager->index($themeSearchData);
        $categories = $this->themeSearchManager->getCategoriesFromQuery($themeSearchData);

        // For a narrow result (1-3 found) suggest related products:
        // same categories first, then same brands.
        $relatedProducts = collect();
        $foundTotal = $products->total();
        if ($foundTotal >= 1 && $foundTotal <= 3) {
            $relatedProducts = $this->themeSearchManager->getRelatedProducts($themeSearchData, $products, 8);
        }

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

        $searchLabel = trim((string) $request->get('search', ''));
        if (function_exists('mb_substr')) {
            $searchLabel = mb_substr($searchLabel, 0, 120);
        } else {
            $searchLabel = substr($searchLabel, 0, 120);
        }
        $listName = $searchLabel !== '' ? 'Search: ' . $searchLabel : 'Search';
        $ga4ItemList = $this->ga4EcommercePayloadBuilder->buildViewItemListFromPaginator($products, 'search_results', $listName);
        $ga4ItemLists = $ga4ItemList !== null ? [$ga4ItemList] : [];

        // Поисковый запрос и состав выдачи (события search и view_search_results).
        $ga4Search = $searchLabel === '' ? null : [
            'search_term' => $searchLabel,
            'ecommerce' => $ga4ItemList === null ? null : $ga4ItemList + ['search_term' => $searchLabel],
        ];

        return view('frontend.v1.pages.search.index', compact([
            'products',
            'themeSearchData',
            'categories',
            'relatedProducts',
            'ga4ItemLists',
            'ga4Search',
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
     * @param Request $request
     * @return JsonResponse
     */
    public function getSuggestions(Request $request): JsonResponse
    {
        $query = $request->input('query', '');
        $locale = $request->input('locale', app()->getLocale());

        if (empty($query) || mb_strlen(trim($query)) < 2) {
            return response()->json([
                'success' => true,
                'data' => []
            ]);
        }

        $suggestions = $this->themeSearchManager->getSuggestions($query, $locale);

        return response()->json([
            'success' => true,
            'data' => $suggestions->values()->toArray()
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
