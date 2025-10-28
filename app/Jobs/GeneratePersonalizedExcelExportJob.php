<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Exports\PersonalizedThemeExcelProductsExport;
use App\Mail\PersonalizedExportReadyMail;
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
 * @param string $type
 * @param string $identifier
 * @param string $locale
 * @param User $user
 */
final class GeneratePersonalizedExcelExportJob implements ShouldQueue
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
     * @param User $user
     */
    public function __construct(
        private readonly Collection $products,
        private readonly string $type,
        private readonly string $identifier,
        private readonly string $locale,
        private readonly User $user
    ) {
    }

    /**
     * @return void
     */
    public function handle(): void
    {
        try {
            if (!$this->user->exists) {
                throw new \Exception("User {$this->user->id} no longer exists");
            }

            app()->setLocale($this->locale);

            $fileName = "radop_personalized_{$this->type}_{$this->identifier}_{$this->user->id}_{$this->locale}.xlsx";
            $filePath = "personalized/{$fileName}";

            $export = new PersonalizedThemeExcelProductsExport($this->products, $this->locale, $this->user);

            Excel::store($export, $filePath, 'local');

            Mail::to($this->user->email)->send(
                new PersonalizedExportReadyMail($this->user, $filePath, $fileName, $this->type)
            );

            if (Storage::exists($filePath)) {
                Storage::delete($filePath);
            }
        } catch (\Exception $e) {
            $filePath = "personalized/radop_personalized_{$this->type}_{$this->identifier}_{$this->user->id}_{$this->locale}.xlsx";

            if (Storage::exists($filePath)) {
                Storage::delete($filePath);
            }

            throw $e;
        }
    }
}
