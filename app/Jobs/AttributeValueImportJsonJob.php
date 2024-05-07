<?php

namespace App\Jobs;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\ProductAttribute;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

final class AttributeValueImportJsonJob implements ShouldQueue
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
        foreach ($this->importData as $attributeValue) {
            if (!empty($attributeValue['product_id'])) {

                AttributeValue::create([
                    'attribute_onec_id' => $attributeValue['characteristic_id'],
                    'product_onec_id' => $attributeValue['product_id'],
                    'value' => $attributeValue['name_ro'],
                ]);

                $attribute = Attribute::where('onec_id', $attributeValue['characteristic_id'])
                    ->first();

                if ($attribute !== null)
                {
                    ProductAttribute::query()->create([
                        'product_id' => $attributeValue['product_id'],
                        'attribute_id' => $attribute->id,
                    ]);
                }
            }
        }
    }
}
