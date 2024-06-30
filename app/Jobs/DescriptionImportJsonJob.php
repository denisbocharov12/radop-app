<?php

namespace App\Jobs;

use App\Repositories\Product\ProductRepository;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

final class DescriptionImportJsonJob implements ShouldQueue
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

    public function handle(ProductRepository $productRepository): void
    {
        if ($this->batch()->cancelled()) {
            return;
        }

        foreach ($this->importData as $description) {
            if (!empty($description['id'])) {
                $existedProduct = $productRepository->getByOnecId($description['id']);

                if ($existedProduct !== null) {
                    $existedProduct->data->update([
                        'summary' => [
                            'ru' => $description['descr_ru'],
                            'ro' => $description['descr_ro'],
                        ]
                    ]);
                }

            }
        }
    }
}
