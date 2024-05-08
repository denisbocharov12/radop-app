<?php

namespace App\Jobs;

use App\Models\Attribute;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

final class AttributeImportJsonJob implements ShouldQueue
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

        foreach ($this->importData as $attribute) {
            if (!empty($attribute['id'])) {
                $data = [
                    'name' => $attribute['name_ro'],
                    'slug' => Str::slug($attribute['name_ro']),
                    'onec_id' => $attribute['id'],
                ];

                Attribute::updateOrCreate([
                    'onec_id' => $attribute['id']
                ], $data);
            }
        }
    }
}
