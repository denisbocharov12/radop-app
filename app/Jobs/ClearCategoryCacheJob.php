<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\Category;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

final class ClearCategoryCacheJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * @param string|null $categoryOnecId OneC ID категории для очистки. Если null - очищает все категории
     */
    public function __construct(
        private readonly ?string $categoryOnecId = null
    ) {}

    /**
     * @return void
     */
    public function handle(): void
    {
        try {
            // Очистка кэша родительских категорий (используется в PropertyServiceProvider)
            Cache::forget('theme_parent_categories');

            // Пересоздание кэша родительских категорий
            $this->rebuildCategoryCache();

            Log::info('Кэш категорий успешно очищен и пересоздан', [
                'category_onec_id' => $this->categoryOnecId ?? 'all',
            ]);
        } catch (\Exception $e) {
            Log::error('Ошибка при очистке кэша категорий: ' . $e->getMessage(), [
                'category_onec_id' => $this->categoryOnecId ?? 'all',
                'exception' => $e,
            ]);

            throw $e;
        }
    }

    /**
     * Пересоздать кэш категорий
     *
     * @return void
     */
    private function rebuildCategoryCache(): void
    {
        $cacheKey = 'theme_parent_categories';
        $cacheTtl = 7200;

        Cache::remember($cacheKey, $cacheTtl, function () {
            return Category::where(['parent_id' => null, 'status' => true])
                ->select('id', 'onec_id', 'parent_id', 'name', 'order', 'catalog_order', 'status')
                ->with(['children' => function ($query) {
                    $query->where('status', true)
                        ->select('id', 'onec_id', 'parent_id', 'name', 'order', 'catalog_order', 'status')
                        ->orderBy('order')
                        ->with(['children' => function ($query) {
                            $query->where('status', true)
                                ->select('id', 'onec_id', 'parent_id', 'name', 'order', 'catalog_order', 'status')
                                ->orderBy('order');
                        }]);
                }])
                ->orderBy('order')
                ->get();
        });
    }
}
