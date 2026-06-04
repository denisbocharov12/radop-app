<?php

declare(strict_types=1);

namespace App\Exports;

use App\Exports\Concerns\StylesProductCatalogSheet;
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

final class ThemeExcelGroupedCategoryProductsExport implements FromView, WithTitle, WithColumnWidths, WithStyles, WithEvents
{
    use StylesProductCatalogSheet;

    private const LAST_COLUMN = 'K';

    /**
     * @var array<int, array{category_name: string, products: Collection<int, \App\Models\Product>}>
     */
    private readonly array $groups;

    /**
     * @param array<int, array{category_name: string, products: Collection<int, \App\Models\Product>}> $groups
     * @param string|null $locale
     * @param string $viewName  row template — defaults to the storefront catalog;
     *                          pass the manager template for manager pricing.
     */
    public function __construct(
        array $groups,
        private readonly ?string $locale = null,
        private readonly string $viewName = 'frontend.v1.exports.categories_grouped_export',
    ) {
        $filtered = [];
        foreach ($groups as $g) {
            $prods = $g['products']->filter(static function ($product): bool {
                return (bool) $product->status === true
                    && (bool) $product->site_status === true
                    && (int) $product->stock !== 0;
            })->values();
            if ($prods->isNotEmpty()) {
                $filtered[] = [
                    'category_name' => $g['category_name'],
                    'products' => $prods,
                ];
            }
        }
        $this->groups = $filtered;
    }

    public function view(): View
    {
        if ($this->locale) {
            app()->setLocale($this->locale);
        }

        return view($this->viewName, [
            'groups' => $this->groups,
        ]);
    }

    public function title(): string
    {
        return app()->getLocale() === 'ru' ? 'RU' : 'RO';
    }

    /**
     * @return array<string, int>
     */
    public function columnWidths(): array
    {
        return [
            'A' => 46, // ~322px (≥320px) so the merged category band reads comfortably
            'B' => 10,
            'C' => 50,
            'D' => 15,
            'E' => 25,
            'F' => 20,
            'G' => 10,
            'H' => 10,
            'I' => 50,
            'J' => 15,
            'K' => 12,
        ];
    }

    /**
     * @return array<int, int>
     */
    public function styles(Worksheet $sheet): array
    {
        $lastRow = $this->resolveLastDataRow();
        if ($lastRow < 4) {
            return [];
        }

        $last = self::LAST_COLUMN;

        $sheet->getStyle("A2:{$last}{$lastRow}")
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER)
            ->setVertical(Alignment::VERTICAL_CENTER)
            ->setWrapText(true);

        foreach ($this->resolveProductRows() as $row) {
            $sheet->getStyle("C{$row}")
                ->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_LEFT)
                ->setVertical(Alignment::VERTICAL_CENTER)
                ->setWrapText(true);
        }

        $sheet->getStyle("A2:{$last}{$lastRow}")
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

                $sheet->getStyle('B:B')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_TEXT);
                $sheet->freezePane('A4');

                $this->styleHeaderRows($sheet, $last);

                $row = 4;
                foreach ($this->groups as $group) {
                    $this->styleCategoryRow($sheet, $row, $last);
                    $row++;

                    foreach ($group['products'] as $product) {
                        $this->applyCatalogRowHeight($sheet, $row);
                        $this->placeProductImage($sheet, $product, $row);
                        $this->writeNota($sheet, $product, $last, $row);
                        $row++;
                    }
                }
            },
        ];
    }

    private function resolveLastDataRow(): int
    {
        $row = 4;
        foreach ($this->groups as $group) {
            $row++;
            $row += $group['products']->count();
        }

        return $row - 1;
    }

    /**
     * @return array<int, int>
     */
    private function resolveProductRows(): array
    {
        $rows = [];
        $row = 4;
        foreach ($this->groups as $group) {
            $row++;
            foreach ($group['products'] as $_) {
                $rows[] = $row;
                $row++;
            }
        }

        return $rows;
    }
}
