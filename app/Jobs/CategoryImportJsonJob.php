<?php

namespace App\Jobs;

use App\Models\Category;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

final class CategoryImportJsonJob implements ShouldQueue
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

        foreach ($this->importData as $category) {

            $isParent = !empty($category['parent_id']) ? false : true;
            $categoryId = !empty($category['parent_id']) ? $category['parent_id'] : null;

            $data = [
                'name' => $category['name_ro'],
                'slug' => $category['id'],
                'is_parent' => $isParent,
                'parent_id' => $categoryId,
            ];

            Category::updateOrCreate(['onec_id' => $category['id']], $data);
        }
    }
}
