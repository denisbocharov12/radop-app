<?php

namespace App\Services\Product;

use App\Models\Product;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Spatie\Image\Image;

final class ProductImagesManager
{
    public static function getProductImagesFromAbsolutePath(string $onecId): ?array
    {
        $files = self::getProductImagesFiles($onecId);

        $imagesArray = [];

        foreach ($files as $key => $file) {
            $imagesArray[] = str_replace('/var/www/html/public/', '', $file);
        }

        return $imagesArray;
    }

    /**
     * Файлы товара в папке-источнике.
     *
     * Маска раньше была `<код>*`, поэтому товару с кодом 100 доставались
     * файлы товара 1000. Берём только `<код>_N.<ext>` и `<код>.<ext>`.
     *
     * @return array<int, string>
     */
    public static function getProductImagesFiles(string $onecId): array
    {
        $dir = public_path() . config('media-files.DIR_PATH');
        $files = glob($dir . $onecId . '{_[0-9]*,.*}', GLOB_BRACE);

        return $files === false ? [] : array_values(array_filter($files, 'is_file'));
    }

    /**
     * Нужно ли вообще трогать товар: количество исходников и количество уже
     * загруженных файлов. Совпало — при импорте номенклатуры товар пропускаем.
     */
    public static function sourceImagesCount(string $onecId): int
    {
        return count(self::getProductImagesFiles($onecId));
    }

    public static function mediaImagesCount(Product $product): int
    {
        return $product->getMedia('products')->count();
    }

    public static function imagesAreUpToDate(Product $product): bool
    {
        $sources = self::sourceImagesCount((string) $product->onec_id);

        return $sources > 0 && $sources === self::mediaImagesCount($product);
    }

    /**
     * Сжимает файл на месте: возвращать путь незачем, он не меняется.
     */
    private static function optimizeImage(string $filePath): void
    {
        Image::load($filePath)
            ->optimize()
            ->save();
    }


    /**
     * @param Product $product
     * @return void
     */
    public static function importProductImages(Product $product): void
    {
        $files = self::getProductImagesFiles($product->onec_id);

        if (empty($files)) {
            return;
        }

        foreach ($files as $file) {
            if (File::exists($file)) {
                $fileName = basename($file);
                $tempPath = storage_path('app/temp/' . $fileName);

                if (!File::exists(dirname($tempPath))) {
                    File::makeDirectory(dirname($tempPath), 0755, true);
                }

                File::copy($file, $tempPath);

                //$optimizedPath = self::optimizeImage($tempPath);

                $product->addMedia($file)
                    ->toMediaCollection('products', 'media');

                File::delete($tempPath);
                //File::delete($optimizedPath);
            }
        }
    }

    /**
     * @param Product $product
     * @return void
     */
    public static function updateProductImages(Product $product): void
    {
        $files = self::getProductImagesFiles($product->onec_id);

        if (empty($files)) {
            return;
        }

        $existingMedia = $product->getMedia('products');
        $existingFileNames = $existingMedia->pluck('file_name')->toArray();

        foreach ($files as $file) {
            if (File::exists($file)) {
                $fileName = basename($file);
                $newFileHash = md5_file($file);

                $existingMediaItem = $existingMedia->firstWhere('file_name', $fileName);

                if ($existingMediaItem) {
                    $existingFilePath = $existingMediaItem->getPath();
                    $existingFileHash = File::exists($existingFilePath) ? md5_file($existingFilePath) : null;

                    if ($newFileHash !== $existingFileHash) {
                        $existingMediaItem->delete();
                    } else {
                        continue;
                    }
                }

                $tempDisk = 'temp_import';

                Storage::disk($tempDisk)->put($fileName, File::get($file));

                $tempPath = Storage::disk($tempDisk)->path($fileName);

                $product->addMediaFromDisk($fileName, $tempDisk)
                    ->toMediaCollection('products', 'media');

                Storage::disk($tempDisk)->delete($fileName);
                File::delete($tempPath);
            }
        }
    }

    /**
     * @param Product $product
     * @return void
     */
    public static function importProductImagesSafe(Product $product): void
    {
        $files = self::getProductImagesFiles($product->onec_id);

        if (empty($files)) {
            return;
        }

        foreach ($files as $file) {
            if (File::exists($file)) {
                $fileName = basename($file);

                $tempDisk = 'temp_import';

                Storage::disk($tempDisk)->put($fileName, File::get($file));

                $tempPath = Storage::disk($tempDisk)->path($fileName);

                $fileName = basename($tempPath);
                Storage::disk($tempDisk)->put($fileName, File::get($tempPath));

                $product->addMediaFromDisk($fileName, $tempDisk)
                    ->toMediaCollection('products', 'media');

                Storage::disk($tempDisk)->delete($fileName);
                File::delete($tempPath);
            }
        }
    }

    /**
     * @param Product $product
     * @return array
     */
    public static function getProductMediaImages(Product $product): array
    {
        $media = $product->getMedia('products');

        if ($media->isEmpty()) {
            return [];
        }

        return $media->map(function ($item) {
            return [
                'id' => $item->id,
                'url' => $item->getUrl(),
            ];
        })->toArray();
    }

    /**
     * @param Product $product
     * @return bool
     */
    public static function hasProductImages(Product $product): bool
    {
        return $product->hasMedia('products');
    }

    /**
     * @param Product $product
     * @return void
     */
    public static function clearProductImages(Product $product): void
    {
        $product->clearMediaCollection('products');
    }

    /**
     * @param Product $product
     * @return void
     */
    public static function reoptimizeProductImages(Product $product): void
    {
        $media = $product->getMedia('products');

        if ($media->isEmpty()) {
            return;
        }

        /*
         * Раньше результат optimizeImage() (который ничего не возвращает)
         * использовался как путь: команда products:optimize-images падала, а
         * при удачном стечении обстоятельств плодила копии медиафайлов.
         * Сжимаем файл на месте и перегенерируем конверсии.
         */
        foreach ($media as $mediaItem) {
            $originalPath = $mediaItem->getPath();

            if (! File::exists($originalPath)) {
                continue;
            }

            self::optimizeImage($originalPath);

            $mediaItem->size = filesize($originalPath);
            $mediaItem->save();
        }
    }
}
