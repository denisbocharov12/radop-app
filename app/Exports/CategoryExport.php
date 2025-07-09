<?php

declare(strict_types=1);

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;

final class CategoryExport implements FromView, WithTitle, WithColumnWidths, WithStyles, WithDrawings
{
    private array $downloadedImages = [];

    public function __construct(
        private readonly Collection $products,
    ) {
    }

    public function view(): View
    {
        return view('frontend.v1.exports.brands_export', [
            'products' => $this->products,
        ]);
    }

    public function title(): string
    {
        return app()->getLocale() === 'ru' ? 'RU' : 'RO';
    }

    public function columnWidths(): array
    {
        return [
            'A' => 0.5,
            'B' => 4,
            'C' => 10,
            'D' => 50,
            'E' => 15,
            'F' => 20,
            'G' => 40,
            'H' => 10,
            'I' => 10,
            'J' => 50,
            'K' => 15,
        ];
    }

    public function styles(\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet): array
    {
        $productsCount = $this->products->count();
        $startRow = 4;
        $endRow = $startRow + $productsCount - 1;

        for ($row = $startRow; $row <= $endRow; $row++) {
            $sheet->getRowDimension($row)->setRowHeight(120);
        }

        $sheet->getStyle("A2:K{$endRow}")
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER)
            ->setVertical(Alignment::VERTICAL_CENTER)
            ->setWrapText(true);

        $sheet->getStyle("A2:K{$endRow}")
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_MEDIUM)
            ->setColor(new Color(Color::COLOR_BLACK));

        return [];
    }

    public function drawings(): array
    {
        $drawings = [];
        $rowOffset = 4; // С какого ряда начинаются товары

        $cmToPixels = fn($cm) => intval($cm * 37.795275591);
        $widthInPixels = $cmToPixels(4);  // 4 см ширина
        $heightInPixels = $cmToPixels(6); // 6 см высота

        foreach ($this->products as $index => $product) {
            $imagesArray = \App\Services\Product\ProductImagesManager::getProductImagesFromAbsolutePath($product->onec_id);

            if (!empty($imagesArray)) {
                $imageUrl = config('app.url') . '/' . $imagesArray[0];

                $tempPath = storage_path('app/temp_product_' . $product->onec_id . '.jpg');
                file_put_contents($tempPath, file_get_contents($imageUrl));

                $drawing = new Drawing();
                $drawing->setName('Product Image');
                $drawing->setDescription($product->title);
                $drawing->setPath($tempPath);
                $drawing->setWidth($widthInPixels);
                $drawing->setHeight($heightInPixels);
                $drawing->setCoordinates('G' . ($rowOffset + $index));

                $columnWidthInPixels = 40 * 7.5;
                $rowHeight = 120;

                $offsetX = intval(($columnWidthInPixels - $widthInPixels) / 2);
                $drawing->setOffsetX(max(0, $offsetX));

                $offsetY = intval(($rowHeight - $heightInPixels) / 2);
                $drawing->setOffsetY(max(0, $offsetY));

                $drawings[] = $drawing;
                $this->downloadedImages[] = $tempPath;
            }
        }

        return $drawings;
    }

    public function __destruct()
    {
        foreach ($this->downloadedImages as $filePath) {
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
    }
}
