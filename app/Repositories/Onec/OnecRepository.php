<?php
namespace App\Repositories\Onec;

use Illuminate\Support\Facades\DB;

final class OnecRepository
{
    public function getProductImportBatches()
    {
        return DB::table('job_batches')
            ->where('name', 'like', '%' . 'Import Products' . '%')
            ->get()
            ->last()
        ;
    }

    public function getCategoryImportBatches()
    {
        return DB::table('job_batches')
            ->where('name', 'like', '%' . 'Import Categories' . '%')
            ->get()
            ->last()
         ;
    }

    public function getBrandImportBatches()
    {
        return DB::table('job_batches')
            ->where('name', 'like', '%' . 'Import Brands' . '%')
            ->get()
            ->last()
        ;
    }

    public function getAttributeImportBatches()
    {
        return DB::table('job_batches')
            ->where('name', 'like', '%' . 'Import Attributes' . '%')
            ->get()
            ->last()
        ;
    }

    public function getAttributeValueImportBatches()
    {
        return DB::table('job_batches')
            ->where('name', 'like', '%' . 'Import Attribute Values' . '%')
            ->get()
            ->last()
        ;
    }

    public function getDescriptionImportBatches()
    {
        return DB::table('job_batches')
            ->where('name', 'like', '%' . 'Import Descriptions' . '%')
            ->get()
            ->last()
        ;
    }

}
