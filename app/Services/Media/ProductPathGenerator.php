<?php

namespace App\Services\Media;

use App\Models\Product;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator;

final class ProductPathGenerator implements PathGenerator
{
    /**
     * @param Media $media
     * @return string
     */
    public function getPath(Media $media): string
    {
        return $this->getBasePath($media) . '/';
    }

    /**
     * @param Media $media
     * @return string
     */
    public function getPathForConversions(Media $media): string
    {
        return $this->getBasePath($media) . '/conversions/';
    }

    /**
     * @param Media $media
     * @return string
     */
    public function getPathForResponsiveImages(Media $media): string
    {
        return $this->getBasePath($media) . '/responsive-images/';
    }

    /**
     * @param Media $media
     * @return string
     */
    private function getBasePath(Media $media): string
    {
        $model = $media->model;

        if ($model instanceof Product && $model->onec_id) {
            return 'products/' . $model->onec_id;
        }

        return 'products/default';
    }
}

