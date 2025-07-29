<?php

namespace App\Http\Controllers\v1\Order;

use App\Excel\Order\OrderReportExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\OrderReportRequest;
use App\Repositories\Order\OrderRepository;
use App\Repositories\User\UserRepository;
use App\Services\Order\OrderReportManager;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Maatwebsite\Excel\Facades\Excel;

final class OrderReportController extends Controller
{
    public function __construct(
        private readonly OrderRepository $orderRepository,
        private readonly OrderReportManager $orderReportManager,
        private readonly UserRepository $userRepository,
    ) {
    }

    /**
     * @param OrderReportRequest $request
     * @return JsonResponse
     */
    public function generateExcelReport(OrderReportRequest $request): JsonResponse
    {
        $reportData = $this->orderReportManager->generateReport(
            $request->get('start_date'),
            $request->get('end_date'),
            $request->get('user_id')
        );

        return response()->json([
            'success' => true,
            'message' => 'Отчет успешно сгенерирован',
            'data' => $reportData
        ]);
    }

    /**
     * @param OrderReportRequest $request
     */
    public function downloadExcelReport(OrderReportRequest $request)
    {
        $orders = $this->orderRepository->getOrdersForReport($request->get('start_date'), $request->get('end_date'), $request->get('user_id'));

        $fileName = 'order_report_' . Carbon::now()->format('Y-m-d_H-i-s') . '.xlsx';

        return Excel::download(new OrderReportExport($orders), $fileName);
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $managers = $this->userRepository->getManagers();

        return view('reports.index', compact('managers'));
    }
}
