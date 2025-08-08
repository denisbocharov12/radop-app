<?php

namespace App\Http\Controllers\v1\Order;

use App\Excel\Order\CityOrderReportExport;
use App\Excel\Order\OrderReportExport;
use App\Excel\Order\StatusOrderReportExport;
use App\Excel\Order\UserTypeOrderReportExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\OrderReportRequest;
use App\Repositories\City\CityRepository;
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
        private readonly CityRepository $cityRepository,
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
     * @param OrderReportRequest $request
     * @return JsonResponse
     */
    public function generateCityExcelReport(OrderReportRequest $request): JsonResponse
    {
        $reportData = $this->orderReportManager->generateCityReport(
            $request->get('start_date'),
            $request->get('end_date'),
            $request->get('city_id')
        );

        return response()->json([
            'success' => true,
            'message' => 'Отчет по городу успешно сгенерирован',
            'data' => $reportData
        ]);
    }

    /**
     * @param OrderReportRequest $request
     */
    public function downloadCityExcelReport(OrderReportRequest $request)
    {
        $orders = $this->orderRepository->getOrdersForCityReport($request->get('start_date'), $request->get('end_date'), $request->get('city_id'));

        $fileName = 'city_order_report_' . Carbon::now()->format('Y-m-d_H-i-s') . '.xlsx';

        return Excel::download(
            new CityOrderReportExport(
                $orders,
                $request->get('start_date'),
                $request->get('end_date')
            ),
            $fileName
        );
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $managers = $this->userRepository->getManagers();

        return view('reports.index', compact('managers'));
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function cityIndex()
    {
        $cities = $this->cityRepository->getAllSorted();

        return view('reports.city.index', compact('cities'));
    }

    /**
     * @param OrderReportRequest $request
     * @return JsonResponse
     */
    public function generateStatusExcelReport(OrderReportRequest $request): JsonResponse
    {
        $reportData = $this->orderReportManager->generateStatusReport(
            $request->get('start_date'),
            $request->get('end_date'),
            $request->get('status_id')
        );

        return response()->json([
            'success' => true,
            'message' => 'Отчет по статусам успешно сгенерирован',
            'data' => $reportData
        ]);
    }

    /**
     * @param OrderReportRequest $request
     */
    public function downloadStatusExcelReport(OrderReportRequest $request)
    {
        $orders = $this->orderRepository->getOrdersForStatusReport($request->get('start_date'), $request->get('end_date'), $request->get('status_id'));

        $fileName = 'status_order_report_' . Carbon::now()->format('Y-m-d_H-i-s') . '.xlsx';

        return Excel::download(
            new StatusOrderReportExport(
                $orders,
                $request->get('start_date'),
                $request->get('end_date')
            ),
            $fileName
        );
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function statusIndex()
    {
        $statuses = [
            ['id' => 'pending', 'name' => 'В ожидании'],
            ['id' => 'processing', 'name' => 'В обработке'],
            ['id' => 'shipped', 'name' => 'Отправлен'],
            ['id' => 'delivered', 'name' => 'Доставлен'],
            ['id' => 'cancelled', 'name' => 'Отменен']
        ];

        return view('reports.status.index', compact('statuses'));
    }

    /**
     * @param OrderReportRequest $request
     * @return JsonResponse
     */
    public function generateUserTypeExcelReport(OrderReportRequest $request): JsonResponse
    {
        $reportData = $this->orderReportManager->generateUserTypeReport(
            $request->get('start_date'),
            $request->get('end_date'),
            $request->get('user_type_id')
        );

        return response()->json([
            'success' => true,
            'message' => 'Отчет по типам пользователей успешно сгенерирован',
            'data' => $reportData
        ]);
    }

    /**
     * @param OrderReportRequest $request
     */
    public function downloadUserTypeExcelReport(OrderReportRequest $request)
    {
        $orders = $this->orderRepository->getOrdersForUserTypeReport($request->get('start_date'), $request->get('end_date'), $request->get('user_type_id'));

        $fileName = 'user_type_order_report_' . Carbon::now()->format('Y-m-d_H-i-s') . '.xlsx';

        return Excel::download(
            new UserTypeOrderReportExport(
                $orders,
                $request->get('start_date'),
                $request->get('end_date')
            ),
            $fileName
        );
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function userTypeIndex()
    {
        $userTypes = [
            ['id' => 'iur', 'name' => 'Юридические лица'],
            ['id' => 'fiz', 'name' => 'Физические лица']
        ];

        return view('reports.user-type.index', compact('userTypes'));
    }
}
