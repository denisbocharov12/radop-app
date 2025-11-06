<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Exports\ManagerExcelProductsExport;
use App\Mail\ManagerExportReadyMail;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

/**
 * @param Collection $products
 * @param string $categoryId
 * @param string $locale
 * @param User $manager
 */
final class GenerateManagerCategoryExportJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * @param Collection $products
     * @param string $categoryId
     * @param string $locale
     * @param User $manager
     */
    public function __construct(
        private readonly Collection $products,
        private readonly string $categoryId,
        private readonly string $locale,
        private readonly User $manager
    ) {
    }

    /**
     * @return void
     */
    public function handle(): void
    {
        try {
            if (!$this->manager->exists) {
                throw new \Exception("Менеджер {$this->manager->id} больше не существует");
            }

            app()->setLocale($this->locale);

            $fileName = "radop_manager_category_{$this->categoryId}_{$this->locale}.xlsx";
            $filePath = "manager_exports/{$fileName}";

            $export = new ManagerExcelProductsExport($this->products, $this->locale);

            Excel::store($export, $filePath, 'local');

            Mail::to($this->manager->email)->send(
                new ManagerExportReadyMail($filePath, $fileName, 'categories', $this->categoryId)
            );

            if (Storage::exists($filePath)) {
                Storage::delete($filePath);
            }

            Log::info("Экспорт категории для менеджера успешно отправлен", [
                'manager_id' => $this->manager->id,
                'manager_email' => $this->manager->email,
                'category_id' => $this->categoryId,
                'locale' => $this->locale,
                'products_count' => $this->products->count(),
            ]);
        } catch (\Exception $e) {
            $filePath = "manager_exports/radop_manager_category_{$this->categoryId}_{$this->locale}.xlsx";

            if (Storage::exists($filePath)) {
                Storage::delete($filePath);
            }

            Log::error("Ошибка экспорта категории для менеджера", [
                'manager_id' => $this->manager->id,
                'category_id' => $this->categoryId,
                'error' => $e->getMessage(),
            ]);

            throw $e;
        }
    }
}

