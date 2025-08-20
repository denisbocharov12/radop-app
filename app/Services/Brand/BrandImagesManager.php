<?php

namespace App\Services\Brand;

use App\Models\Brand;
use Illuminate\Support\Facades\File;
use Spatie\Image\Image;

final class BrandImagesManager
{
    /**
     * @param string $onecId
     * @return array
     */
    public static function getBrandImagesFiles(string $onecId): array
    {
        $dir = public_path() . config('media-files.DIR_PATH');
        $files = glob($dir . "{$onecId}*");

        return $files ?: [];
    }

    /**
     * @param string $filePath
     * @return void
     */
    private static function optimizeImage(string $filePath): void
    {
        Image::load($filePath)
            ->optimize()
            ->save();
    }

    /**
     * @param Brand $brand
     * @return void
     */
    public static function importBrandImages(Brand $brand): void
    {
        $files = self::getBrandImagesFiles($brand->onec_id);

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

                self::optimizeImage($tempPath);

                $brand->addMedia($tempPath)
                    ->toMediaCollection('media', config('media-files.DISK_NAME'));

                File::delete($tempPath);
            }
        }
    }

    /**
     * @param Brand $brand
     * @return bool
     */
    public static function hasBrandImages(Brand $brand): bool
    {
        return $brand->hasMedia('media');
    }

    /**
     * @param Brand $brand
     * @return void
     */
    public static function clearBrandImages(Brand $brand): void
    {
        $brand->clearMediaCollection('media');
    }
}


