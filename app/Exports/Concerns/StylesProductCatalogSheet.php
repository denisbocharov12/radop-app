<?php

declare(strict_types=1);

namespace App\Exports\Concerns;

use App\Models\Product;
use App\Services\Export\ProductExcelStatusResolver;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

/**
 * Shared styling for every product catalog export so all of them look the
 * same: 120px image rows, an #ffcc98 header band, #feff97 category bands,
 * cell-anchored centred product photos, and a coloured "Nota" status column.
 */
trait StylesProductCatalogSheet
{
    /** Row height that fits a ~120px product photo (Excel uses points: 120px ≈ 90pt). */
    protected int $catalogRowHeightPoints = 90;

    /** Header band colour (№, Cod, Denumirea produsului, …). */
    protected string $headerFillArgb = 'FFFFCC98';

    /** Category sub-header band colour. */
    protected string $categoryFillArgb = 'FFFEFF97';

    /** Column that holds the product photo. */
    protected string $imageColumn = 'E';

    /**
     * Paint the header rows (row 2 + 3 in these templates) with the orange band.
     */
    protected function styleHeaderRows(Worksheet $sheet, string $lastColumn): void
    {
        $range = "A2:{$lastColumn}3";
        $sheet->getStyle($range)
            ->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB($this->headerFillArgb);

        $sheet->getStyle($range)->getFont()->setBold(true);
        $sheet->getStyle($range)
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER)
            ->setVertical(Alignment::VERTICAL_CENTER)
            ->setWrapText(true);
    }

    /**
     * Paint a category sub-header row yellow, bold, left-aligned. The row is
     * NOT merged — the category name sits in the first cell.
     */
    protected function styleCategoryRow(Worksheet $sheet, int $row, string $lastColumn): void
    {
        $range = "A{$row}:{$lastColumn}{$row}";
        $sheet->getStyle($range)
            ->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB($this->categoryFillArgb);

        $sheet->getStyle($range)->getFont()->setBold(true);
        $sheet->getStyle("A{$row}")
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_LEFT)
            ->setVertical(Alignment::VERTICAL_CENTER);

        $sheet->getRowDimension($row)->setRowHeight(22);
    }

    protected function applyCatalogRowHeight(Worksheet $sheet, int $row): void
    {
        $sheet->getRowDimension($row)->setRowHeight($this->catalogRowHeightPoints);
    }

    /**
     * Place the product photo so it sits inside its cell, centred, and "moves
     * and sizes with cells" (two-cell anchor) for easy editing in Excel.
     */
    protected function placeProductImage(Worksheet $sheet, Product $product, int $row): void
    {
        $imagePath = $this->resolveProductImagePath($product);
        if ($imagePath === null) {
            return;
        }

        $cell = $this->imageColumn . $row;

        try {
            $drawing = new Drawing();
            $drawing->setName('Product Image');
            $drawing->setDescription('Product Image');
            $drawing->setPath($imagePath);

            // Two-cell anchor: top-left and bottom-right both inside the same
            // cell, inset by a small padding. editAs=twoCell makes Excel treat
            // it as "move and size with cells".
            $drawing->setCoordinates($cell);
            $drawing->setOffsetX(18);
            $drawing->setOffsetY(8);
            $drawing->setCoordinates2($cell);
            $drawing->setOffsetX2(150);
            $drawing->setOffsetY2(112);
            $drawing->setEditAs(Drawing::EDIT_AS_TWOCELL);

            $drawing->setWorksheet($sheet);
        } catch (\Throwable $e) {
            // Never let a single bad image break the whole export.
        }
    }

    /**
     * Write the NEW / HIT / SALE status into the Nota column with the right
     * font colour (NEW/HIT dark blue, SALE red).
     */
    protected function writeNota(Worksheet $sheet, Product $product, string $column, int $row): void
    {
        $status = ProductExcelStatusResolver::resolve($product);
        if ($status === null) {
            return;
        }

        $sheet->setCellValue("{$column}{$row}", $status['label']);
        $sheet->getStyle("{$column}{$row}")->getFont()->setBold(true)->getColor()->setARGB($status['argb']);
        $sheet->getStyle("{$column}{$row}")
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER)
            ->setVertical(Alignment::VERTICAL_CENTER);
    }

    protected function resolveProductImagePath(Product $product): ?string
    {
        if (!$product->hasMedia('products')) {
            return null;
        }

        try {
            $media = $product->getFirstMedia('products');
            if ($media === null) {
                return null;
            }

            $path = $media->hasGeneratedConversion('thumb')
                ? $media->getPath('thumb')
                : $media->getPath();

            return ($path !== '' && file_exists($path)) ? $path : null;
        } catch (\Throwable $e) {
            return null;
        }
    }
}
