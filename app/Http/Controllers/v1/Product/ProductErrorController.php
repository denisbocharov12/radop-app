<?php

declare(strict_types=1);

namespace App\Http\Controllers\v1\Product;

use App\Http\Controllers\Controller;
use App\Models\ProductError;
use App\Repositories\Product\ProductErrorRepository;
use App\Services\Product\ProductErrorScanner;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\App;

final class ProductErrorController extends Controller
{
    /**
     * The admin UI is Russian, but the app default locale is `ro`. This page
     * renders no product-data translations (it uses snapshot columns), so we
     * can safely pin the UI locale to Russian for consistent chrome.
     */
    private const ADMIN_LOCALE = 'ru';

    public function __construct(
        private readonly ProductErrorRepository $productErrorRepository,
        private readonly ProductErrorScanner $productErrorScanner,
    ) {
    }

    public function index()
    {
        App::setLocale(self::ADMIN_LOCALE);

        $errors  = $this->productErrorRepository->paginatedWithFilters();
        $summary = $this->productErrorRepository->summary();
        $affectedProducts = $summary['products'];

        // type => localized label, for the filter dropdown.
        $types = ProductError::typeOptions();

        return view('product.errors.index', compact([
            'errors',
            'summary',
            'affectedProducts',
            'types',
        ]));
    }

    /**
     * Trigger a synchronous full rescan and return to the listing.
     * The dataset (~6k products) scans in a few seconds; if it ever grows
     * large enough to time out, swap this for a queued job.
     */
    public function rescan(): RedirectResponse
    {
        App::setLocale(self::ADMIN_LOCALE);

        $summary = $this->productErrorScanner->scanAll();

        return redirect()
            ->route('product.errors.index')
            ->with('success', __('product_errors.rescan_done', [
                'scanned'  => $summary['scanned'],
                'critical' => $summary['critical'],
                'minor'    => $summary['minor'],
            ]));
    }
}
