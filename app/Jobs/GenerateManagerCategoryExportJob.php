<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Exports\PersonalizedThemeExcelProductsExport;
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
 * @param User $client
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
     * @param User $client
     * @param User $manager
     */
    public function __construct(
        private readonly Collection $products,
        private readonly string $categoryId,
        private readonly string $locale,
        private readonly User $client,
        private readonly User $manager
    ) {
    }

    /**
     * @return void
     */
    public function handle(): void
    {
        try {
            if (!$this->client->exists) {
                throw new \Exception("Клиент {$this->client->id} больше не существует");
            }

            if (!$this->client->with_sale) {
                throw new \Exception("У клиента {$this->client->id} не включены персональные цены");
            }

            if (!$this->manager->exists) {
                throw new \Exception("Менеджер {$this->manager->id} больше не существует");
            }

            app()->setLocale($this->locale);

            $fileName = "radop_manager_category_{$this->categoryId}_client_{$this->client->id}_{$this->locale}.xlsx";
            $filePath = "manager_exports/{$fileName}";

            $export = new PersonalizedThemeExcelProductsExport($this->products, $this->locale, $this->client);

            Excel::store($export, $filePath, 'local');

            Mail::to($this->manager->email)->send(
                new ManagerExportReadyMail($this->client, $filePath, $fileName, 'categories', $this->categoryId)
            );

            if (Storage::exists($filePath)) {
                Storage::delete($filePath);
            }

            Log::info("Экспорт категории для менеджера успешно отправлен", [
                'manager_id' => $this->manager->id,
                'manager_email' => $this->manager->email,
                'client_id' => $this->client->id,
                'client_name' => $this->client->name,
                'category_id' => $this->categoryId,
                'locale' => $this->locale,
                'products_count' => $this->products->count(),
            ]);
        } catch (\Exception $e) {
            $filePath = "manager_exports/radop_manager_category_{$this->categoryId}_client_{$this->client->id}_{$this->locale}.xlsx";

            if (Storage::exists($filePath)) {
                Storage::delete($filePath);
            }

            Log::error("Ошибка экспорта категории для менеджера", [
                'manager_id' => $this->manager->id,
                'client_id' => $this->client->id,
                'category_id' => $this->categoryId,
                'error' => $e->getMessage(),
            ]);

            throw $e;
        }
    }
}

