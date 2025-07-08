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

final class BrandExport implements FromView, WithTitle, WithColumnWidths, WithStyles, WithDrawings
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
            'A' => 0.5,  // Пустой столбец
            'B' => 4,    // №
            'C' => 10,   // Код
            'D' => 50,   // Наименование
            'E' => 15,   // Бренд
            'F' => 20,   // Штрихкод
            'G' => 40,   // Фото
            'H' => 10,   // Упаковка (пачка)
            'I' => 10,   // Упаковка (короб)
            'J' => 50,   // Характеристики
            'K' => 15,   // Цена
        ];
    }

    public function styles(\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet)
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

        // Примерная ширина колонки G в пикселях
        // В PhpSpreadsheet ширина колонки 1 = примерно 7.5 пикселей, поэтому 40 * 7.5 = 300
        $columnWidthInPixels = 40 * 7.5;
        $rowHeight = 120;

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
                $drawing->setHeight($rowHeight);
                $drawing->setCoordinates('G' . ($rowOffset + $index));

                // Получаем фактическую ширину изображения в пикселях
                // Примерно, высота = 120, пропорции картинки сохраняются
                // Прикинем ширину изображения, чтобы сдвинуть по горизонтали

                // Установим горизонтальный сдвиг для центрирования
                $imageWidth = $drawing->getWidth();
                $offsetX = intval(($columnWidthInPixels - $imageWidth) / 2);
                if ($offsetX < 0) {
                    $offsetX = 0; // чтобы не было отрицательного сдвига
                }
                $drawing->setOffsetX($offsetX);

                $imageHeight = $drawing->getHeight();
                $offsetY = intval(($rowHeight - $imageHeight) / 2);
                if ($offsetY < 0) {
                    $offsetY = 0;
                }
                $drawing->setOffsetY($offsetY);

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
