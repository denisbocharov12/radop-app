<?php

declare(strict_types=1);

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Services\MenuRenderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

final class MegaMenuController extends Controller
{
    /**
     * @param MenuRenderService $menuRenderService
     */
    public function __construct(
        private readonly MenuRenderService $menuRenderService
    ) {
    }

    /**
     * Определить локаль из запроса
     *
     * @param Request $request
     * @return string
     */
    private function resolveLocale(Request $request): string
    {
        if ($request->hasHeader('X-Localization')) {
            $locale = $request->header('X-Localization');
            $supportedLocales = array_keys(config('laravellocalization.supportedLocales', []));
            if (in_array($locale, $supportedLocales)) {
                return $locale;
            }
        }

        if ($request->hasHeader('x-localization')) {
            $locale = $request->header('x-localization');
            $supportedLocales = array_keys(config('laravellocalization.supportedLocales', []));
            if (in_array($locale, $supportedLocales)) {
                return $locale;
            }
        }

        try {
            $currentLocale = LaravelLocalization::getCurrentLocale();
            if ($currentLocale) {
                return $currentLocale;
            }
        } catch (\Exception $e) {
        }

        $sessionLocale = session('locale');
        if ($sessionLocale) {
            $supportedLocales = array_keys(config('laravellocalization.supportedLocales', []));
            if (in_array($sessionLocale, $supportedLocales)) {
                return $sessionLocale;
            }
        }

        $urlLocale = $request->segment(1);
        $supportedLocales = array_keys(config('laravellocalization.supportedLocales', []));
        if (in_array($urlLocale, $supportedLocales)) {
            return $urlLocale;
        }

        return config('app.fallback_locale', 'ro');
    }

    /**
     * @param Request $request
     * @param string $code
     * @return JsonResponse
     */
    public function getData(Request $request, string $code): JsonResponse
    {
        $locale = $this->resolveLocale($request);
        App::setLocale($locale);

        $menu = $this->menuRenderService->getMenuData($code);

        if (!$menu || !$menu->is_active || $menu->rootItems->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => __('theme.mega-menu-not-found'),
                'data' => null
            ], 404);
        }
        $nameRaw = $menu->getRawOriginal('name');
        $menuName = is_array(json_decode($nameRaw, true))
            ? $menu->getTranslation('name', $locale)
            : ($nameRaw ?? '');
        $linkRaw = $menu->getRawOriginal('link');
        $menuLink = is_array(json_decode($linkRaw, true))
            ? $menu->getTranslation('link', $locale)
            : ($linkRaw ?? '');

        $data = [
            'code' => $code,
            'name' => $menuName,
            'link' => $menuLink,
            'is_active' => $menu->is_active,
            'widgets' => $this->formatMenuItems($menu->rootItems->where('type', 'widget_link'), $locale),
            'categories' => $this->formatMenuItems($menu->rootItems->where('type', '!=', 'widget_link'), $locale),
        ];

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    /**
     * @param Request $request
     * @param string $code
     * @return JsonResponse
     */
    public function getHtml(Request $request, string $code): JsonResponse
    {
        $locale = $this->resolveLocale($request);
        App::setLocale($locale);

        $cssClass = $request->query('css_class', '');
        $html = $this->menuRenderService->renderContent($code, $cssClass);

        if (empty($html)) {
            return response()->json([
                'success' => false,
                'message' => __('theme.mega-menu-not-found'),
                'html' => ''
            ], 404);
        }

        return response()->json([
            'success' => true,
            'html' => $html
        ]);
    }

    /**
     * @param Request $request
     * @param string $code
     * @return JsonResponse
     */
    public function getMobileHtml(Request $request, string $code): JsonResponse
    {
        $locale = $this->resolveLocale($request);
        App::setLocale($locale);

        $cssClass = $request->query('css_class', '');
        $html = $this->menuRenderService->renderMobileContent($code, $cssClass);

        if (empty($html)) {
            return response()->json([
                'success' => false,
                'message' => __('theme.mega-menu-not-found'),
                'html' => ''
            ], 404);
        }

        return response()->json([
            'success' => true,
            'html' => $html
        ]);
    }

    /**
     * @param Request $request
     * @param string $code
     * @param int $itemId
     * @return JsonResponse
     */
    public function getCategoryContent(Request $request, string $code, int $itemId): JsonResponse
    {
        $locale = $this->resolveLocale($request);
        App::setLocale($locale);

        $html = $this->menuRenderService->renderCategoryContent($itemId, $code);

        if (empty($html)) {
            return response()->json([
                'success' => false,
                'message' => __('theme.mega-menu-category-not-found'),
                'html' => ''
            ], 404);
        }

        return response()->json([
            'success' => true,
            'html' => $html
        ]);
    }

    /**
     * @param Request $request
     * @param string $code
     * @param int $itemId
     * @return JsonResponse
     */
    public function getMobileCategoryContent(Request $request, string $code, int $itemId): JsonResponse
    {
        $locale = $this->resolveLocale($request);
        App::setLocale($locale);

        $html = $this->menuRenderService->renderMobileCategoryContent($itemId, $code);

        if (empty($html)) {
            return response()->json([
                'success' => false,
                'message' => __('theme.mega-menu-category-not-found'),
                'html' => ''
            ], 404);
        }

        return response()->json([
            'success' => true,
            'html' => $html
        ]);
    }

    /**
     * @param \Illuminate\Support\Collection $items
     * @param string $locale
     * @return array
     */
    private function formatMenuItems(\Illuminate\Support\Collection $items, string $locale): array
    {
        return $items->map(function ($item) use ($locale) {
            $titleRaw = $item->getRawOriginal('title');
            $title = is_array(json_decode($titleRaw, true))
                ? $item->getTranslation('title', $locale)
                : ($titleRaw ?? '');
            $linkRaw = $item->getRawOriginal('link');
            $link = is_array(json_decode($linkRaw, true))
                ? $item->getTranslation('link', $locale)
                : ($linkRaw ?? '');

            $image = $item->getFirstMedia('menu_item_image');

            $labelNameRaw = $item->getRawOriginal('label_name');
            $labelName = is_array(json_decode($labelNameRaw, true))
                ? $item->getTranslation('label_name', $locale)
                : ($labelNameRaw ?? null);

            $formatted = [
                'id' => $item->id,
                'title' => $title,
                'link' => $link,
                'type' => $item->type,
                'target' => $item->target ?? '_self',
                'category_id' => $item->category_id,
                'products_count' => $item->products_count ?? 0,
                'image' => $image ? $image->getUrl() : null,
                'order' => $item->order,
                'label_name' => $labelName,
                'label_color' => $item->label_color,
                'display_title' => $item->display_title ?? false,
                'display_as_link' => $item->display_as_link ?? true,
            ];

            if ($item->children && $item->children->isNotEmpty()) {
                $formatted['children'] = $this->formatMenuItems($item->children, $locale);
            }

            return $formatted;
        })->values()->toArray();
    }
}
