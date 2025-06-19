<?php

declare(strict_types=1);

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;

final class BrandRoExport implements ShouldAutoSize, FromView, WithTitle
{
    public function __construct(
        private readonly Collection $products,
    ) {
    }

    public function view(): View
    {
        app()->setlocale('ro');

        return view('frontend.v1.exports.brands_ro', [
            'products' => $this->products,
        ]);
    }

    public function title(): string
    {
        return 'RO';
    }
}
