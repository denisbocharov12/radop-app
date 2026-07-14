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

    /**
     * Display box for a catalog photo, in pixels. The image is scaled to FIT
     * inside this box preserving aspect ratio (so wide "Asortat" photos can no
     * longer overflow the column) and is then centred horizontally + vertically.
     */
    protected int $catalogImageBoxWidthPx = 150;
    protected int $catalogImageBoxHeightPx = 140;

    /**
     * When a product has NO generated conversion, its original is downscaled on
     * the fly to at most this long-edge size (JPEG q75) before embedding — so a
     * missing thumbnail never bloats the workbook with a multi-MB photo.
     */
    protected int $catalogImageFallbackMaxPx = 300;

    /** Temp downscaled files to delete once the request/job ends. @var list<string> */
    private array $catalogTempImages = [];

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

        // Fixed group-header row height.
        $sheet->getRowDimension($row)->setRowHeight(20);
    }

    protected function applyCatalogRowHeight(Worksheet $sheet, int $row): void
    {
        $sheet->getRowDimension($row)->setRowHeight($this->catalogRowHeightPoints);
    }

    /**
     * Place the product photo inside its cell, scaled to FIT the display box
     * (preserving aspect ratio) and centred both horizontally and vertically.
     *
     * Fitting to the box — rather than just fixing the height — is what stops
     * wide composite "Asortat" photos from spilling past the column edge.
     */
    protected function placeProductImage(Worksheet $sheet, Product $product, int $row): void
    {
        $imagePath = $this->resolveProductImagePath($product);
        if ($imagePath === null) {
            return;
        }

        $size = @getimagesize($imagePath);
        if ($size === false || (int) $size[0] < 1 || (int) $size[1] < 1) {
            return;
        }
        [$nativeW, $nativeH] = $size;

        // Fit inside the box, preserving aspect ratio (never upscale past native).
        $scale = min(
            $this->catalogImageBoxWidthPx / $nativeW,
            $this->catalogImageBoxHeightPx / $nativeH,
            1.0
        );
        $width  = max(1, (int) round($nativeW * $scale));
        $height = max(1, (int) round($nativeH * $scale));

        // Centre horizontally in the column and vertically in the row.
        $colWidthPx  = $this->resolveColumnWidthPx($sheet, $this->imageColumn, $this->catalogImageBoxWidthPx + 30);
        $rowHeightPx = (int) round($this->catalogRowHeightPoints * 96 / 72);
        $offsetX = max(2, (int) round(($colWidthPx - $width) / 2));
        $offsetY = max(2, (int) round(($rowHeightPx - $height) / 2));

        try {
            $drawing = new Drawing();
            $drawing->setName('Product Image');
            $drawing->setDescription('Product Image');
            $drawing->setPath($imagePath);

            // Exact, pre-computed dimensions (aspect ratio already preserved).
            $drawing->setResizeProportional(false);
            $drawing->setWidth($width);
            $drawing->setHeight($height);

            $drawing->setCoordinates($this->imageColumn . $row);
            $drawing->setOffsetX($offsetX);
            $drawing->setOffsetY($offsetY);
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

    /**
     * Fill the whole product row with a light tint of its NEW / HIT / SALE status
     * colour (NEW green, HIT blue, SALE red — same scheme as the Nota column and
     * the storefront badges). Products with no status keep the default white row.
     */
    protected function fillProductRow(Worksheet $sheet, Product $product, string $lastColumn, int $row): void
    {
        $fill = ProductExcelStatusResolver::fill($product);
        if ($fill === null) {
            return;
        }

        $sheet->getStyle("A{$row}:{$lastColumn}{$row}")
            ->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB($fill);
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

            // No usable conversion → downscale the original on the fly so a
            // product whose thumbnails were never generated still embeds a small
            // image instead of a multi-MB original.
            $original = $media->getPath();
            if ($original === '' || !file_exists($original)) {
                return null;
            }

            return $this->downscaledTempImage($original) ?? $original;
        } catch (\Throwable $e) {
            return null;
        }
    }

    /**
     * Pixel width of a column as Excel will render it; falls back when the
     * column has no explicit width set yet.
     */
    private function resolveColumnWidthPx(Worksheet $sheet, string $column, int $fallback): int
    {
        try {
            $units = $sheet->getColumnDimension($column)->getWidth();
            if ($units > 0) {
                $font = $sheet->getParent()->getDefaultStyle()->getFont();

                return (int) round(\PhpOffice\PhpSpreadsheet\Shared\Drawing::cellDimensionToPixels($units, $font));
            }
        } catch (\Throwable $e) {
            // fall through to the fallback
        }

        return $fallback;
    }

    /**
     * Downscale an image to {@see self::$catalogImageFallbackMaxPx} on its long
     * edge (JPEG q75) into a temp file, registered for cleanup at shutdown.
     * Returns null (→ caller embeds the original) if GD is unavailable, the
     * source is unreadable, or the image is already small.
     */
    private function downscaledTempImage(string $source): ?string
    {
        if (!function_exists('imagecreatefromstring')) {
            return null;
        }

        $data = @file_get_contents($source);
        if ($data === false) {
            return null;
        }

        $src = @imagecreatefromstring($data);
        if ($src === false) {
            return null;
        }

        $w   = imagesx($src);
        $h   = imagesy($src);
        $max = $this->catalogImageFallbackMaxPx;
        $scale = min(1.0, $max / max($w, $h));

        // Already small in both dimensions and bytes — keep the original.
        if ($scale >= 1.0 && strlen($data) <= 60 * 1024) {
            imagedestroy($src);

            return null;
        }

        $nw = max(1, (int) round($w * $scale));
        $nh = max(1, (int) round($h * $scale));

        $dst   = imagecreatetruecolor($nw, $nh);
        $white = imagecolorallocate($dst, 255, 255, 255);
        imagefilledrectangle($dst, 0, 0, $nw, $nh, $white);
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $nw, $nh, $w, $h);

        $tmp = tempnam(sys_get_temp_dir(), 'catimg_');
        if ($tmp === false) {
            imagedestroy($src);
            imagedestroy($dst);

            return null;
        }
        $tmpJpg = $tmp . '.jpg';
        @unlink($tmp);

        $ok = imagejpeg($dst, $tmpJpg, 75);
        imagedestroy($src);
        imagedestroy($dst);

        if ($ok !== true || !file_exists($tmpJpg)) {
            return null;
        }

        $this->registerTempImage($tmpJpg);

        return $tmpJpg;
    }

    private function registerTempImage(string $path): void
    {
        $this->catalogTempImages[] = $path;
        register_shutdown_function(static function () use ($path): void {
            if (is_file($path)) {
                @unlink($path);
            }
        });
    }
}
