<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Exports\ThemeExcelGroupedCategoryProductsExport;
use App\Services\Export\ProductCategoryGrouper;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

final class GenerateExcelExportJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * @param Collection $products
     * @param string $type
     * @param string $identifier
     * @param string $locale
     */
    public function __construct(
        private readonly Collection $products,
        private readonly string $type,
        private readonly string $identifier,
        private readonly string $locale
    ) {
    }

    /**
     * @return void
     */
    public function handle(): void
    {
        try {
            app()->setLocale($this->locale);
            
            $fileName = "radop_{$this->type}_{$this->identifier}_{$this->locale}.xlsx";
            $filePath = "{$fileName}";

            // §5 — group every catalog (brands / new / popular / sale) by
            // category so it matches the category catalog layout (yellow
            // sub-headers). Eager-load the relations the grouped view needs to
            // avoid N+1 inside the queued job.
            $this->products->loadMissing([
                'categories:id,onec_id,name',
                'brand:id,onec_id,title',
                'packages',
                'values.attribute',
                'media',
                'data',
            ]);

            $groups = app(ProductCategoryGrouper::class)->group($this->products, $this->locale);

            $export = new ThemeExcelGroupedCategoryProductsExport($groups, $this->locale);

            Excel::store($export, $filePath, 'export');

            Log::info("Export file successfully created: {$filePath}", [
                'type' => $this->type,
                'identifier' => $this->identifier,
                'locale' => $this->locale,
                'products_count' => $this->products->count(),
            ]);
        } catch (\Exception $e) {
            Log::error("Error creating export file", [
                'type' => $this->type,
                'identifier' => $this->identifier,
                'locale' => $this->locale,
                'error' => $e->getMessage(),
                'exception' => $e,
            ]);

            throw $e;
        }
    }
}

