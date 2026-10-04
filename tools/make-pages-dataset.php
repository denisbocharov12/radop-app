<?php

declare(strict_types=1);

/**
 * Сжатый срез базы для витрины на GitHub Pages.
 *
 * Боевая база — три сотни мегабайт, в репозиторий ей нельзя. Здесь собирается
 * демонстрационный набор: все разделы, бренды и меню, но товары — выборочно,
 * вместе с их характеристиками, упаковками и медиафайлами.
 *
 * Запуск (из корня проекта, на той базе, что в .env):
 *   php tools/make-pages-dataset.php --products=600 --out=database/pages/dataset.sql.gz
 */

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

$options = getopt('', ['products::', 'out::']);
$limit = max(50, (int) ($options['products'] ?? 600));
$out = (string) ($options['out'] ?? 'database/pages/dataset.sql.gz');

/** Таблицы, которые уезжают целиком: без них витрина не соберётся. */
$whole = [
    'brands',
    'attributes',
    'attribute_category',
    'menus',
    'header_menus',
    'header_menu_items',
    'banners',
    'banner_settings',
    'home_sections',
    'page_sort_settings',
    'cities',
    'delivery_methods',
    'seo_metas',
];

echo "Срез базы для Pages: товаров до {$limit}\n";

/*
 * Товары берём по нескольку из каждого раздела: так в демонстрации есть и
 * наполненные разделы, и карточки с характеристиками.
 */
$productCodes = DB::table('products as p')
    ->join('product_categories as pc', 'pc.product_id', '=', 'p.onec_id')
    ->where('p.status', true)
    ->where('p.site_status', true)
    ->where('p.stock', '!=', 0)
    ->whereNotNull('p.slug')
    ->orderBy('pc.category_id')
    ->orderBy('p.id')
    ->limit($limit * 3)
    ->pluck('p.onec_id')
    ->unique()
    ->take($limit)
    ->values()
    ->all();

echo 'товаров в срезе: ', count($productCodes), "\n";

/*
 * Разделы берём только те, где есть выбранные товары, и достраиваем цепочку
 * родителей: иначе меню и хлебные крошки ведут в пустоту.
 */
$categoryCodes = DB::table('product_categories')
    ->whereIn('product_id', $productCodes)
    ->distinct()
    ->pluck('category_id')
    ->filter()
    ->all();

$kept = array_flip($categoryCodes);
$queue = $categoryCodes;

while ($queue !== []) {
    $parents = DB::table('categories')
        ->whereIn('onec_id', $queue)
        ->whereNotNull('parent_id')
        ->pluck('parent_id')
        ->unique()
        ->all();

    $queue = [];

    foreach ($parents as $parent) {
        if ($parent !== null && ! isset($kept[$parent])) {
            $kept[$parent] = true;
            $queue[] = $parent;
        }
    }
}

$categoryCodes = array_keys($kept);

echo 'разделов в срезе: ', count($categoryCodes), "\n";

/*
 * Пункты меню: оставляем ведущие на сохранённые разделы и те, что вообще не
 * про разделы (ссылки, тексты). Пункт без родителя в срезе тоже убираем.
 */
$menuItems = DB::table('menu_items')->get();
$keptMenu = [];

foreach ($menuItems as $item) {
    if ($item->type === 'category' && ! isset($kept[$item->category_id])) {
        continue;
    }

    $keptMenu[$item->id] = $item;
}

do {
    $removed = 0;

    foreach ($keptMenu as $id => $item) {
        if ($item->parent_id !== null && ! isset($keptMenu[$item->parent_id])) {
            unset($keptMenu[$id]);
            $removed++;
        }
    }
} while ($removed > 0);

echo 'пунктов меню в срезе: ', count($keptMenu), ' из ', count($menuItems), "\n";

$productIds = DB::table('products')->whereIn('onec_id', $productCodes)->pluck('id')->all();

/** Таблицы, привязанные к выбранным товарам: [таблица => [колонка, значения]]. */
$related = [
    'products' => ['onec_id', $productCodes],
    'product_categories' => ['product_id', $productCodes],
    'product_profiles' => ['product_id', $productCodes],
    'attribute_values' => ['product_onec_id', $productCodes],
    'packages' => ['product_onec_id', $productCodes],
    'product_category_sorts' => ['product_id', $productCodes],
];

$handle = gzopen($out, 'wb9');

if ($handle === false) {
    fwrite(STDERR, "Не удалось открыть {$out}\n");
    exit(1);
}

$write = static function (string $line) use ($handle): void {
    gzwrite($handle, $line . "\n");
};

$write('SET NAMES utf8mb4;');
$write('SET FOREIGN_KEY_CHECKS = 0;');

$dumpRows = static function (string $table, callable $query) use ($write): int {
    if (! Illuminate\Support\Facades\Schema::hasTable($table)) {
        echo "  нет таблицы {$table}\n";

        return 0;
    }

    // Миграции успевают создать свои строки (например, секции главной),
    // поэтому перед вставкой таблицу чистим.
    $write('DELETE FROM `' . $table . '`;');

    $columns = Illuminate\Support\Facades\Schema::getColumnListing($table);
    $quoted = implode(', ', array_map(static fn ($c) => "`{$c}`", $columns));
    $count = 0;
    $buffer = [];

    $query()->orderBy('id')->chunk(500, function ($rows) use (&$count, &$buffer, $columns, $quoted, $table, $write): void {
        foreach ($rows as $row) {
            $values = [];

            foreach ($columns as $column) {
                $value = $row->{$column} ?? null;

                if ($value === null) {
                    $values[] = 'NULL';

                    continue;
                }

                $values[] = "'" . addslashes((string) $value) . "'";
            }

            $buffer[] = '(' . implode(', ', $values) . ')';
            $count++;

            if (count($buffer) >= 200) {
                $write("INSERT INTO `{$table}` ({$quoted}) VALUES " . implode(",\n", $buffer) . ';');
                $buffer = [];
            }
        }
    });

    if ($buffer !== []) {
        $write("INSERT INTO `{$table}` ({$quoted}) VALUES " . implode(",\n", $buffer) . ';');
    }

    echo "  {$table}: {$count}\n";

    return $count;
};

foreach ($whole as $table) {
    $dumpRows($table, static fn () => DB::table($table));
}

$related['categories'] = ['onec_id', $categoryCodes];
$related['menu_items'] = ['id', array_keys($keptMenu)];

foreach ($related as $table => [$column, $values]) {
    $dumpRows($table, static fn () => DB::table($table)->whereIn($column, $values));
}

// Медиафайлы товаров: по ним витрина строит адреса фотографий
$dumpRows('media', static fn () => DB::table('media')
    ->where('model_type', 'App\\Models\\Product')
    ->whereIn('model_id', $productIds));

$write('SET FOREIGN_KEY_CHECKS = 1;');
gzclose($handle);

printf("Готово: %s, %.1f МБ\n", $out, filesize($out) / 1048576);
