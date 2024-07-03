<?php

namespace App\Jobs;

use App\Models\Brand;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

final class BrandImportJsonJob implements ShouldQueue
{
    use Batchable;
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(
        private readonly array $importData,
        private readonly array $headers,
    )
    {
    }

    public function handle(): void
    {
        if ($this->batch()->cancelled()) {
            return;
        }

        foreach ($this->importData as $brand) {
            if (!empty($brand->id)) {
                $data = [
                    'onec_id' => $brand->id,
                    'title' => [
                        'ro' => isset($brand->name_ro) ? $brand->name_ro: '',
                        'ru' => isset($brand->name_ru) ? $brand->name_ru: '',
                    ],
                    'slug' => Str::slug($brand->name_ro) . '-' . $brand->id,
                ];

                Brand::updateOrCreate(['onec_id' => $brand->id], $data);
            }
        }
    }
}
