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
        $dir = public_path() . config('media-files.DIR_PATH');
        $files = glob($dir . "$onecId*");

        $imagesArray = [];

        foreach ($files as $key => $file) {
            $imagesArray[] = str_replace('/var/www/html/public/', '', $file);
        }

        return $imagesArray;
    }

    /**
     * @param string $onecId
     * @return array
     */
    public static function getProductImagesFiles(string $onecId): array
    {
        $dir = public_path() . config('media-files.DIR_PATH');
        $files = glob($dir . "$onecId*");

        return $files;
    }

    /**
     * @param string $filePath
     * @return string
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

                if (!in_array($fileName, $existingFileNames)) {
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

        foreach ($media as $mediaItem) {
            $originalPath = $mediaItem->getPath();

            if (File::exists($originalPath)) {
                $optimizedPath = self::optimizeImage($originalPath);

                $mediaItem->copyMedia($optimizedPath)
                    ->toMediaCollection('products', 'media');

                File::delete($optimizedPath);
            }
        }
    }
}
