<?php

declare(strict_types=1);

namespace App\Http\Controllers\v1\ActivePagesExport;

use App\Http\Controllers\Controller;
use App\Jobs\GenerateActivePagesExcelExportJob;
use App\Repositories\Product\ProductRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

final class ActivePagesExportController extends Controller
{
    private const COUNT_OF_PAGINATION = 24;

    private const ACTIVE_PAGES_FILE_PREFIXES = [
        'radop_new_products_',
        'radop_popular_products_',
        'radop_sale_products_',
    ];

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $disk = Storage::disk('manager_exports');
        $allFiles = collect($disk->files());

        $filesList = $allFiles->filter(function (string $file) {
            $basename = basename($file);
            foreach (self::ACTIVE_PAGES_FILE_PREFIXES as $prefix) {
                if (str_starts_with($basename, $prefix) && str_ends_with($basename, '.xlsx')) {
                    return true;
                }
            }
            return false;
        });

        $filesWithMetadata = $filesList->map(function (string $file) use ($disk) {
            $fileName = basename($file);
            return [
                'name' => $fileName,
                'path' => $file,
                'size' => $disk->size($file),
                'modified' => $disk->lastModified($file),
            ];
        })->sortByDesc('modified')->values();

        $currentPage = (int) $request->get('page', 1);
        $perPage = self::COUNT_OF_PAGINATION;
        $total = $filesWithMetadata->count();
        $items = $filesWithMetadata->forPage($currentPage, $perPage)->values();

        $files = new LengthAwarePaginator(
            $items,
            $total,
            $perPage,
            $currentPage,
            [
                'path' => $request->url(),
                'query' => $request->query(),
            ]
        );

        return view('active-pages-export.index', compact('files'));
    }

    /**
     * @param Request $request
     * @param ProductRepository $productRepository
     * @return JsonResponse
     */
    public function generate(Request $request, ProductRepository $productRepository): JsonResponse
    {
        $request->validate([
            'type' => 'required|string|in:new,popular,sale',
            'locale' => 'required|string|in:ru,ro',
        ]);

        $type = $request->input('type');
        $locale = $request->input('locale');

        $products = match ($type) {
            'new' => $productRepository->getAllNewProductsForExport(),
            'popular' => $productRepository->getAllPopularProductsForExport(),
            'sale' => $productRepository->getAllDiscountProductsForExport(),
            default => $productRepository->getAllNewProductsForExport(),
        };

        if ($products->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Нет товаров для экспорта в выбранном разделе',
            ], 404);
        }

        $typeLabel = match ($type) {
            'new' => 'new_products',
            'popular' => 'popular_products',
            'sale' => 'sale_products',
            default => 'new_products',
        };

        GenerateActivePagesExcelExportJob::dispatch($products, $typeLabel, $type, $locale)->onQueue('high');

        return response()->json([
            'success' => true,
            'message' => 'Экспорт запущен. Файл будет создан и доступен в списке ниже.',
        ]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse|BinaryFileResponse
     */
    public function download(Request $request): RedirectResponse|BinaryFileResponse
    {
        $request->validate([
            'file' => 'required|string',
        ]);

        $disk = Storage::disk('manager_exports');
        $decodedFileName = urldecode($request->input('file'));
        $filePath = $decodedFileName;

        if (!$disk->exists($filePath)) {
            $allFiles = $disk->files();
            foreach ($allFiles as $file) {
                if (basename($file) === $decodedFileName) {
                    $filePath = $file;
                    break;
                }
            }
        }

        $allowed = false;
        foreach (self::ACTIVE_PAGES_FILE_PREFIXES as $prefix) {
            if (str_starts_with(basename($filePath), $prefix)) {
                $allowed = true;
                break;
            }
        }

        if (!$allowed || !$disk->exists($filePath)) {
            return redirect()->route('active-pages-export.index')
                ->with('error', 'Файл не найден');
        }

        $absolutePath = storage_path('app/export/' . $filePath);

        if (!file_exists($absolutePath)) {
            return redirect()->route('active-pages-export.index')
                ->with('error', 'Файл не найден на диске');
        }

        return response()->download($absolutePath, $decodedFileName);
    }
}
