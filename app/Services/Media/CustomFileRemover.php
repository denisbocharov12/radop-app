<?php

namespace App\Services\Media;

use Exception;
use Illuminate\Contracts\Filesystem\Factory;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\MediaCollections\Filesystem;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\FileRemover\FileRemover;

final class CustomFileRemover implements FileRemover
{
    public function __construct(protected Filesystem $mediaFileSystem, protected Factory $filesystem) {}

    public function removeAllFiles(Media $media): void
    {

        if ($media->conversions_disk && $media->disk !== $media->conversions_disk) {
            $this->removeFromConversionsDirectory($media, $media->conversions_disk);
            $this->removeFromMediaDirectory($media, $media->conversions_disk);
        }

        $this->removeFromConversionsDirectory($media, $media->disk);
        $this->removeFromMediaDirectory($media, $media->disk);
    }

    public function removeFromMediaDirectory(Media $media, string $disk): void
    {
        $mediaDirectory = $this->mediaFileSystem->getMediaDirectory($media);

        collect([$mediaDirectory])
            ->each(function (string $directory) use ($media, $disk) {
                try {
                    $allFilePaths = $this->filesystem->disk($disk)->allFiles($directory);
                    $imagePaths = array_filter(
                        $allFilePaths,
                        static fn(string $path) => Str::afterLast($path, '/') === $media->file_name
                    );
                    foreach ($imagePaths as $imagePath) {
                        $this->filesystem->disk($disk)->delete($imagePath);
                    }

                    if (! $this->filesystem->disk($disk)->allFiles($directory)) {
                        $this->filesystem->disk($disk)->deleteDirectory($directory);
                    }
                } catch (Exception $exception) {
                    report($exception);
                }
            });
    }

    public function removeFromConversionsDirectory(Media $media, string $disk): void
    {
        $conversionsDirectory = $this->mediaFileSystem->getMediaDirectory($media, 'conversions');

        collect([$conversionsDirectory])
            ->each(function (string $directory) use ($media, $disk) {
                try {
                    $allFilePaths = $this->filesystem->disk($disk)->allFiles($directory);
                    $conversions = $media->getMediaConversionNames() ?: [];
                    $conversionsFilePaths = array_map(
                        static fn(string $conversion) => $media->getPathRelativeToRoot($conversion),
                        $conversions,
                    );
                    $imagePaths = array_intersect($allFilePaths, $conversionsFilePaths);
                    foreach ($imagePaths as $imagePath) {
                        $this->filesystem->disk($disk)->delete($imagePath);
                    }

                    if (! $this->filesystem->disk($disk)->allFiles($directory)) {
                        $this->filesystem->disk($disk)->deleteDirectory($directory);
                    }
                } catch (Exception $exception) {
                    report($exception);
                }
            });
    }

    public function removeResponsiveImages(Media $media, string $conversionName): void
    {
        $responsiveImagesDirectory = $this->mediaFileSystem->getResponsiveImagesDirectory($media);

        $allFilePaths = $this->filesystem->disk($media->disk)->allFiles($responsiveImagesDirectory);

        $responsiveImagePaths = array_filter(
            $allFilePaths,
            fn(string $path) => Str::contains($path, $conversionName)
        );

        $this->filesystem->disk($media->disk)->delete($responsiveImagePaths);
    }

    public function removeFile(string $path, string $disk): void
    {
        $this->filesystem->disk($disk)->delete($path);
    }
}
