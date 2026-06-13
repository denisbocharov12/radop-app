<?php

declare(strict_types=1);

namespace App\Exports;

use App\Exports\Concerns\StylesProductCatalogSheet;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

final class PersonalizedThemeExcelProductsExport implements FromView, WithTitle, WithColumnWidths, WithStyles, WithEvents
{
    use StylesProductCatalogSheet;

    private const LAST_COLUMN = 'K';

    private readonly Collection $products;

    public function __construct(
        Collection $products,
        private readonly ?string $locale = null,
        private readonly ?User $user = null,
    ) {
        $this->products = $products->filter(function ($product): bool {
            return (bool) $product->status === true
                && (bool) $product->site_status === true
                && (int) $product->stock !== 0;
        })->values();
    }

    public function view(): View
    {
        if ($this->locale) {
            app()->setLocale($this->locale);
        }

        return view('frontend.v1.exports.personalized_brands_export', [
            'products' => $this->products,
            'user' => $this->user,
        ]);
    }

    public function title(): string
    {
        return app()->getLocale() === 'ru' ? 'RU' : 'RO';
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 10,
            'C' => 50,
            'D' => 12,
            'E' => 22,
            'F' => 16,
            'G' => 9,
            'H' => 9,
            'I' => 50,
            'J' => 12,
            'K' => 12,
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        $productsCount = $this->products->count();
        if ($productsCount === 0) {
            return [];
        }

        $startRow = 4;
        $endRow   = $startRow + $productsCount - 1;
        $last     = self::LAST_COLUMN;

        for ($row = $startRow; $row <= $endRow; $row++) {
            $this->applyCatalogRowHeight($sheet, $row);
        }

        $sheet->getStyle("A2:{$last}{$endRow}")
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER)
            ->setVertical(Alignment::VERTICAL_CENTER)
            ->setWrapText(true);

        $sheet->getStyle("C{$startRow}:C{$endRow}")
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_LEFT)
            ->setVertical(Alignment::VERTICAL_CENTER)
            ->setWrapText(true);

        $sheet->getStyle("A2:{$last}{$endRow}")
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_MEDIUM)
            ->setColor(new Color(Color::COLOR_BLACK));

        return [];
    }

    /**
     * @return array<class-string, callable>
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event): void {
                $sheet = $event->sheet->getDelegate();
                $last  = self::LAST_COLUMN;
                $startRow = 4;

                $sheet->getStyle('B:B')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_TEXT);
                $sheet->freezePane('A4');

                $this->styleHeaderRows($sheet, $last);

                foreach ($this->products as $index => $product) {
                    $row = $startRow + $index;
                    $this->placeProductImage($sheet, $product, $row);
                    $this->writeNota($sheet, $product, $last, $row);
                }
            },
        ];
    }
}
