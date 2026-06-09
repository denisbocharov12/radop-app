<?php

declare(strict_types=1);

namespace App\Exports\Concerns;

use App\Models\Product;
use App\Services\Export\ProductExcelStatusResolver;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
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
    /** Catalog product-row height, in Excel points (matches the "Высота строки" dialog). */
    protected int $catalogRowHeightPoints = 120;

    /** Product photo height in pixels; width auto-scales to keep aspect ratio. Leaves padding inside the row. */
    protected int $catalogImageHeightPx = 140;

    /**
     * Media conversions embedded into the workbook, smallest first.
     *
     * Excel stores the RAW image bytes — resizing the drawing's display height
     * does NOT shrink them — so embedding a small generated conversion (thumb
     * 150×150, then medium 264×264) is what keeps the file lightweight. The
     * full-resolution original is used only as a last resort when no conversion
     * exists.
     *
     * @var list<string>
     */
    protected array $catalogImageConversions = ['thumb', 'medium'];

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
     * Paint a category sub-header row yellow, bold, left-aligned.
     *
     * The whole band is merged (A → last column) so the category title spans the
     * full table width instead of being squashed into the narrow first (№, width 4)
     * column. Wrap is enabled so long names flow onto extra lines instead of being
     * clipped, and the row height auto-grows to fit them.
     */
    protected function styleCategoryRow(Worksheet $sheet, int $row, string $lastColumn): void
    {
        $range = "A{$row}:{$lastColumn}{$row}";

        if (!$sheet->getCell("A{$row}")->isInMergeRange()) {
            $sheet->mergeCells($range);
        }

        $sheet->getStyle($range)
            ->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB($this->categoryFillArgb);

        $sheet->getStyle($range)->getFont()->setBold(true);
        $sheet->getStyle($range)
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_LEFT)
            ->setVertical(Alignment::VERTICAL_CENTER)
            ->setWrapText(true);

        // Cosmetic: the band reads as one clean empty strip — strip the inner
        // per-column grid lines but keep a visible outer frame around the row.
        // (Runs in AfterSheet, i.e. after the export's styles() drew the grid,
        // so this override wins.)
        $sheet->getStyle($range)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_NONE);
        $sheet->getStyle($range)->getBorders()->getOutline()
            ->setBorderStyle(Border::BORDER_MEDIUM)
            ->setColor(new Color(Color::COLOR_BLACK));

        // -1 = auto height: the row grows to fit a wrapped (multi-line) title,
        // with 22pt as the effective minimum for a single line.
        $sheet->getRowDimension($row)->setRowHeight(-1);
    }

    protected function applyCatalogRowHeight(Worksheet $sheet, int $row): void
    {
        $sheet->getRowDimension($row)->setRowHeight($this->catalogRowHeightPoints);
    }

    /**
     * Place the product photo inside its cell WITHOUT distorting it.
     *
     * The previous two-cell anchor forced every image into a fixed box
     * (≈132×104px) regardless of its real proportions, which squashed tall or
     * wide photos. Here we set only the height and let the width auto-scale
     * (resizeProportional), so the original aspect ratio is always preserved.
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

            // Keep aspect ratio: setHeight() recomputes width from the image's
            // native dimensions (resizeProportional is true by default).
            $drawing->setResizeProportional(true);
            $drawing->setHeight($this->catalogImageHeightPx);

            // One-cell anchor with a little padding: the photo keeps its own
            // size and is not stretched to the cell box.
            $drawing->setCoordinates($cell);
            $drawing->setOffsetX(20);
            $drawing->setOffsetY(8);
            $drawing->setEditAs(Drawing::EDIT_AS_ONECELL);

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

            // Prefer a small generated conversion (thumb → medium) to keep the
            // workbook lightweight. Embedding the full-res original is what
            // bloats the file, so it is only the last-resort fallback.
            foreach ($this->catalogImageConversions as $conversion) {
                if ($media->hasGeneratedConversion($conversion)) {
                    $conversionPath = $media->getPath($conversion);
                    if ($conversionPath !== '' && file_exists($conversionPath)) {
                        return $conversionPath;
                    }
                }
            }

            $path = $media->getPath();

            return ($path !== '' && file_exists($path)) ? $path : null;
        } catch (\Throwable $e) {
            return null;
        }
    }
}
