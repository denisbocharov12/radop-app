<?php

namespace App\Http\Controllers\v1\User;

use App\Excel\User\UserReportExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserReportRequest;
use App\Repositories\User\UserReportRepository;
use App\Repositories\User\UserRepository;
use App\Services\User\UserReportManager;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Maatwebsite\Excel\Facades\Excel;

final class UserReportController extends Controller
{
    public function __construct(
        private readonly UserReportRepository $userReportRepository,
        private readonly UserReportManager $userReportManager,
        private readonly UserRepository $userRepository,
    ) {
    }

    /**
     * @param UserReportRequest $request
     * @return JsonResponse
     */
    public function generateExcelReport(UserReportRequest $request): JsonResponse
    {
        $reportData = $this->userReportManager->generateReport(
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
     * @param UserReportRequest $request
     */
    public function downloadExcelReport(UserReportRequest $request)
    {
        $orderItems = $this->userReportRepository->getUserOrderItemsForReport(
            $request->get('start_date'), 
            $request->get('end_date'), 
            $request->get('user_id')
        );

        $fileName = 'user_report_' . Carbon::now()->format('Y-m-d_H-i-s') . '.xlsx';

        return Excel::download(
            new UserReportExport(
                $orderItems, 
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
        $users = $this->userRepository->getUsersWithOrders();

        return view('reports.user.index', compact('users'));
    }
} 