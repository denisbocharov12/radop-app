<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Spatie\Image\Image;
use Spatie\Image\Manipulations;

/**
 * Приводит исходные фото товаров к одному квадратному формату.
 *
 * Фотографии приходят от поставщиков вертикальными, горизонтальными и с
 * разными полями: сетка карточек из-за этого прыгает, а у товара рядом с
 * товаром разный масштаб. Команда вписывает снимок в квадрат, центрирует и
 * дополняет белым — пропорции самого товара не меняются.
 *
 * Работаем по папке-источнику (public/cert), а не по медиатеке: конверсии
 * сделаются уже из квадрата, и повторный импорт не вернёт старый формат.
 */
final class NormalizeProductImagesCommand extends Command
{
    protected $signature = 'products:normalize-images
        {--size=1000 : Сторона квадрата в пикселях}
        {--quality=85 : Качество JPEG}
        {--only= : Обработать файлы одного товара по коду 1С}
        {--path= : Другая папка с исходниками}
        {--backup= : Складывать оригиналы сюда перед заменой}
        {--dry-run : Только показать, что будет сделано}
        {--force : Обрабатывать и те файлы, которые уже квадратные}
        {--limit=0 : Остановиться после N файлов}';

    protected $description = 'Вписывает фото товаров в квадрат с белыми полями';

    public function handle(): int
    {
        $size = max(100, (int) $this->option('size'));
        $quality = min(100, max(40, (int) $this->option('quality')));
        $dir = rtrim($this->option('path') ?: public_path() . config('media-files.DIR_PATH'), '/\\') . DIRECTORY_SEPARATOR;
        $dryRun = (bool) $this->option('dry-run');
        $force = (bool) $this->option('force');
        $limit = (int) $this->option('limit');
        $backup = $this->option('backup') ? rtrim($this->option('backup'), '/\\') . DIRECTORY_SEPARATOR : null;

        if (! File::isDirectory($dir)) {
            $this->error("Папка с исходниками не найдена: {$dir}");

            return self::FAILURE;
        }

        $mask = $this->option('only')
            ? $this->option('only') . '{_[0-9]*,.*}'
            : '*';

        $files = array_values(array_filter(
            glob($dir . $mask, GLOB_BRACE) ?: [],
            static fn ($path) => is_file($path) && preg_match('/\.(jpe?g|png|webp)$/i', $path)
        ));

        if ($files === []) {
            $this->warn('Подходящих файлов не нашлось.');

            return self::SUCCESS;
        }

        if ($backup !== null && ! $dryRun) {
            File::ensureDirectoryExists($backup);
        }

        $this->info(sprintf('Файлов: %d, квадрат %dx%d, качество %d%s', count($files), $size, $size, $quality, $dryRun ? ', пробный прогон' : ''));

        $bar = $this->output->createProgressBar(count($files));
        $bar->start();

        $done = $skipped = $failed = 0;

        foreach ($files as $i => $path) {
            if ($limit > 0 && $done + $skipped >= $limit) {
                break;
            }

            $bar->advance();

            $info = @getimagesize($path);

            if ($info === false) {
                $failed++;
                $this->newLine();
                $this->warn('не изображение: ' . basename($path));

                continue;
            }

            [$width, $height] = $info;

            if (! $force && $width === $size && $height === $size) {
                $skipped++;

                continue;
            }

            if ($dryRun) {
                $done++;

                continue;
            }

            try {
                if ($backup !== null) {
                    File::copy($path, $backup . basename($path));
                }

                Image::load($path)
                    // FIT_FILL вписывает снимок целиком и добивает полями до
                    // квадрата: товар не обрезается и не растягивается.
                    ->fit(Manipulations::FIT_FILL, $size, $size)
                    ->background('ffffff')
                    ->quality($quality)
                    ->optimize()
                    ->save($path);

                $done++;
            } catch (\Throwable $e) {
                $failed++;
                $this->newLine();
                $this->warn(basename($path) . ': ' . $e->getMessage());
            }
        }

        $bar->finish();
        $this->newLine(2);

        $this->table(
            ['обработано', 'пропущено', 'ошибок'],
            [[$done, $skipped, $failed]]
        );

        if ($dryRun) {
            $this->comment('Пробный прогон: файлы не изменены.');
        }

        return $failed > 0 && $done === 0 ? self::FAILURE : self::SUCCESS;
    }
}
