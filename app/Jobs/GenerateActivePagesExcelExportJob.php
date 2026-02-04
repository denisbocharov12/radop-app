<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Exports\ManagerExcelActiveStateProductsExport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

final class GenerateActivePagesExcelExportJob implements ShouldQueue
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

            $export = new ManagerExcelActiveStateProductsExport($this->products, $this->locale);

            Excel::store($export, $filePath, 'manager_exports');

            Log::info("Active pages export file successfully created: {$filePath}", [
                'type' => $this->type,
                'identifier' => $this->identifier,
                'locale' => $this->locale,
                'products_count' => $this->products->count(),
            ]);
        } catch (\Exception $e) {
            Log::error("Error creating active pages export file", [
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
