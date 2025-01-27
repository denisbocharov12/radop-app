<?php

namespace App\Jobs;

use App\Models\Category;
use App\Models\Package;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductProfile;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

final class PackageImportJsonJob implements ShouldQueue
{
    use Batchable;
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public $importData;
    public  $headers;

    public function __construct(
        $importData,
        $headers
    )
    {
        $this->importData = $importData;
        $this->headers = $headers;
    }

    public function handle(): void
    {
        if ($this->batch()->cancelled()) {
            return;
        }

        foreach ($this->importData as $package) {

            $data = [
                'product_onec_id' => $package->product_id,
                'name' => [
                    'ro' => isset($package->name_ro) ? $package->name_ro : '',
                    'ru' => isset($package->name_ru) ? $package->name_ru : '',
                ],
                'value' => $package->koef,
                'order_status' => isset($package->order_status) ? true : false,
            ];

            Package::create($data);
        }
    }
}
