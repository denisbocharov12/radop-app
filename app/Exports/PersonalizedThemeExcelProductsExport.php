<?php

declare(strict_types=1);

namespace App\Exports;

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
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

/**
 * @param Collection $products
 * @param string|null $locale
 * @param User $user
 */
final class PersonalizedThemeExcelProductsExport implements FromView, WithTitle, WithColumnWidths, WithStyles, WithEvents
{
    /**
     * @param Collection $products
     * @param string|null $locale
     * @param User $user
     */
    public function __construct(
        private readonly Collection $products,
        private readonly ?string $locale = null,
        private readonly User $user,
    ) {
    }

    /**
     * @return View
     */
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

    /**
     * @return string
     */
    public function title(): string
    {
        return app()->getLocale() === 'ru' ? 'RU' : 'RO';
    }

    /**
     * @return array
     */
    public function columnWidths(): array
    {
        return [
            'A' => 4,
            'B' => 10,
            'C' => 50,
            'D' => 15,
            'E' => 20,
            'F' => 20,
            'G' => 10,
            'H' => 10,
            'I' => 50,
            'J' => 15,
        ];
    }

    /**
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet): array
    {
        $productsCount = $this->products->count();
        $startRow = 4;
        $endRow = $startRow + $productsCount - 1;

        for ($row = $startRow; $row <= $endRow; $row++) {
            $sheet->getRowDimension($row)->setRowHeight(110);
        }

        $sheet->getStyle("A2:J{$endRow}")
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER)
            ->setVertical(Alignment::VERTICAL_CENTER)
            ->setWrapText(true);

        $sheet->getStyle("A2:J{$endRow}")
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_MEDIUM)
            ->setColor(new Color(Color::COLOR_BLACK));

        return [];
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $startRow = 4;

                foreach ($this->products as $index => $product) {
                    $row = $startRow + $index;

                    if ($product->hasMedia('products')) {
                        try {
                            $media = $product->getFirstMedia('products');
                            $imagePath = null;

                            if ($media && $media->hasGeneratedConversion('thumb')) {
                                $imagePath = $media->getPath('thumb');
                            } elseif ($media) {
                                $imagePath = $media->getPath();
                            }

                            if ($imagePath && file_exists($imagePath)) {
                                $drawing = new Drawing();
                                $drawing->setName('Product Image');
                                $drawing->setDescription('Product Image');
                                $drawing->setPath($imagePath);
                                $drawing->setWidthAndHeight(110, 110);
                                $drawing->setResizeProportional(true);
                                $drawing->setOffsetX(10);
                                $drawing->setOffsetY(5);
                                $drawing->setCoordinates("E{$row}");
                                $drawing->setWorksheet($sheet);
                            }
                        } catch (\Exception $e) {
                            continue;
                        }
                    }
                }
            },
        ];
    }
}
