<?php

declare(strict_types=1);

namespace App\Excel\Brand;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

final class BrandExport implements WithMultipleSheets
{
    public function __construct(
        private readonly Collection $products
    ){
    }

    public function sheets(): array
    {
        return [
            new BrandRoExport($this->products),
            new BrandRuExport($this->products),
        ];
    }
}
