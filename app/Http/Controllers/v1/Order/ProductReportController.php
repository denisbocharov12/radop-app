<?php

declare(strict_types=1);

namespace App\Http\Controllers\v1\Order;

use App\Excel\Order\ProductReportExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\ProductReportRequest;
use App\Services\Order\ProductReportManager;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;

final class ProductReportController extends Controller
{
    public function __construct(
        private readonly ProductReportManager $productReportManager,
    ) {
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('reports.products.index');
    }

    /**
     * @param ProductReportRequest $request
     * @return JsonResponse
     */
    public function generate(ProductReportRequest $request): JsonResponse
    {
        $reportData = $this->productReportManager->generateReport(
            $request->get('start_date'),
            $request->get('end_date'),
            $request->get('onec_id') ?: null
        );

        return response()->json([
            'success' => true,
            'message' => 'Отчет успешно сгенерирован',
            'data' => $reportData,
        ]);
    }

    /**
     * @param ProductReportRequest $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download(ProductReportRequest $request)
    {
        $reportData = $this->productReportManager->generateReport(
            $request->get('start_date'),
            $request->get('end_date'),
            $request->get('onec_id') ?: null
        );

        $rows = new Collection($reportData['products']);
        $fileName = 'product_report_' . Carbon::now()->format('Y-m-d_H-i-s') . '.xlsx';

        return Excel::download(
            new ProductReportExport(
                $rows,
                $request->get('start_date'),
                $request->get('end_date')
            ),
            $fileName
        );
    }
}
