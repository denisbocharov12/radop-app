<?php

namespace App\Services\Product;

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
}
