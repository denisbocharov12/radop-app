<?php

declare(strict_types=1);

namespace App\Services\ONEC;

use stdClass;

final class ImportFailureAnalyzer
{
    private const IMAGE_TOO_LARGE_PATTERNS = [
        'Maximum allowed size',
        'exceeds the maximum',
        '10 MB',
        '10MB',
        'file is too large',
        'FileSizeLimitExceededException',
        'Spatie\\MediaLibrary\\MediaCollections\\Exceptions\\FileIsTooBig',
    ];

    private const UPDATE_PRODUCT_IMAGES_PATTERNS = [
        'updateProductImages',
        'ProductImagesManager',
        'addMedia',
        'addMediaFromDisk',
    ];

    /**
     * @param stdClass $failedJob {uuid: string, payload: string, exception: string, failed_at: string}
     * @return array{uuid: string, failed_at: string, reason_en: string, exception_preview: string, products: array<int, array{onec_id: string, title: string}>}
     */
    public function analyze(stdClass $failedJob): array
    {
        $payload = json_decode($failedJob->payload, true);
        $exception = $failedJob->exception ?? '';
        $reasonEn = $this->resolveReasonEn($exception);
        $productIdentifiers = $this->extractProductIdentifiersFromPayload($payload);

        return [
            'uuid' => $failedJob->uuid,
            'failed_at' => $failedJob->failed_at,
            'reason_en' => $reasonEn,
            'exception_preview' => $this->getExceptionPreview($exception),
            'products' => $productIdentifiers,
        ];
    }

    private function resolveReasonEn(string $exception): string
    {
        if (str_contains($exception, 'Spatie\\MediaLibrary') || $this->matchesAny($exception, self::IMAGE_TOO_LARGE_PATTERNS)) {
            return 'Product image file exceeds allowed size (max 10 MB).';
        }
        if ($this->matchesAny($exception, self::UPDATE_PRODUCT_IMAGES_PATTERNS)) {
            return 'Error while attaching/updating product images.';
        }
        if (str_contains($exception, 'Connection') && (str_contains($exception, 'refused') || str_contains($exception, 'timeout'))) {
            return 'Network/connection error during import.';
        }
        if (str_contains($exception, 'SQLSTATE') || str_contains($exception, 'QueryException')) {
            return 'Database error during product or category sync.';
        }
        if (str_contains($exception, 'Category::where') || str_contains($exception, 'Product::updateOrCreate')) {
            return 'Data validation or missing relation (category/product).';
        }

        $firstLine = explode("\n", trim($exception))[0] ?? '';
        $cleaned = preg_replace('/^.*?exception \'[^\']+\' with message \'/', '', $firstLine);
        $cleaned = preg_replace('/\' in .*$/', '', $cleaned ?? '');

        return strlen($cleaned) > 200 ? substr($cleaned, 0, 197) . '...' : ($cleaned ?: 'Unknown error.');
    }

    private function matchesAny(string $haystack, array $patterns): bool
    {
        foreach ($patterns as $pattern) {
            if (str_contains($haystack, $pattern)) {
                return true;
            }
        }
        return false;
    }

    private function getExceptionPreview(string $exception, int $maxLen = 300): string
    {
        $firstLine = explode("\n", trim($exception))[0] ?? '';
        if (strlen($firstLine) <= $maxLen) {
            return $firstLine;
        }
        return substr($firstLine, 0, $maxLen - 3) . '...';
    }

    /**
     * @param array<string, mixed>|null $payload
     * @return array<int, array{onec_id: string, title: string}>
     */
    private function extractProductIdentifiersFromPayload(?array $payload): array
    {
        if ($payload === null) {
            return [];
        }
        $command = $payload['data']['command'] ?? null;
        if ($command === null || !is_string($command)) {
            return [];
        }

        try {
            $job = @unserialize($command);
            if (!$job || !isset($job->importData) || !is_array($job->importData)) {
                return [];
            }
        } catch (\Throwable) {
            return [];
        }

        $result = [];
        foreach ($job->importData as $product) {
            $onecId = $product->id ?? $product->onec_id ?? null;
            $title = $product->name_ro_full ?? $product->name_ru_full ?? $product->name ?? (string) $onecId;
            if ($onecId !== null) {
                $result[] = ['onec_id' => (string) $onecId, 'title' => (string) $title];
            }
        }
        return $result;
    }
}
