<?php

namespace App\Repositories\Onec;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

final class OnecRepository
{
    public function getProductImportBatches(): ?object
    {
        $batches = DB::table('job_batches')
            ->where('name', 'like', '%Import Products%')
            ->orderByDesc('id')
            ->get();

        return $batches->isEmpty() ? null : $batches->first();
    }

    /**
     * @return Collection<int, object>
     */
    public function getProductImportFailedJobs(?string $batchId = null): Collection
    {
        $batch = $batchId
            ? DB::table('job_batches')->where('id', $batchId)->first()
            : $this->getProductImportBatches();

        if ($batch === null) {
            return collect();
        }

        $failedIds = json_decode($batch->failed_job_ids ?? '[]', true);
        if (!is_array($failedIds) || empty($failedIds)) {
            return collect();
        }

        return DB::table('failed_jobs')
            ->whereIn('uuid', $failedIds)
            ->orderByDesc('failed_at')
            ->get();
    }

    public function getCategoryImportBatches(): ?object
    {
        $batches = DB::table('job_batches')
            ->where('name', 'like', '%Import Categories%')
            ->orderByDesc('id')
            ->get();

        return $batches->isEmpty() ? null : $batches->first();
    }

    public function getBrandImportBatches(): ?object
    {
        $batches = DB::table('job_batches')
            ->where('name', 'like', '%Import Brands%')
            ->orderByDesc('id')
            ->get();

        return $batches->isEmpty() ? null : $batches->first();
    }

    public function getAttributeImportBatches(): ?object
    {
        $batches = DB::table('job_batches')
            ->where('name', 'like', '%Import Attributes%')
            ->orderByDesc('id')
            ->get();

        return $batches->isEmpty() ? null : $batches->first();
    }

    public function getAttributeValueImportBatches(): ?object
    {
        $batches = DB::table('job_batches')
            ->where('name', 'like', '%Import Attribute Values%')
            ->orderByDesc('id')
            ->get();

        return $batches->isEmpty() ? null : $batches->first();
    }

    public function getDescriptionImportBatches(): ?object
    {
        $batches = DB::table('job_batches')
            ->where('name', 'like', '%Import Descriptions%')
            ->orderByDesc('id')
            ->get();

        return $batches->isEmpty() ? null : $batches->first();
    }

    public function getPackageImportBatches(): ?object
    {
        $batches = DB::table('job_batches')
            ->where('name', 'like', '%Import Packages%')
            ->orderByDesc('id')
            ->get();

        return $batches->isEmpty() ? null : $batches->first();
    }
}
