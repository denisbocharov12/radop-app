<?php

declare(strict_types=1);

namespace App\Http\Controllers\v1\Dashboard;

//use App\Enums\TransferStatuses;
use App\Http\Controllers\Controller;
//use App\Repositories\Contract\ContractRepository;
//use App\Repositories\Maintenance\MaintenanceRepository;
//use App\Repositories\Subject\SubjectRepository;
//use App\Repositories\Transfer\TransferRepository;

final class DashboardController extends Controller
{
//    private MaintenanceRepository $maintenanceRepository;
//    private ContractRepository $contractRepository;
//    private SubjectRepository $subjectRepository;
//    private TransferRepository $transferRepository;
//    private TransferStatuses $transferStatuses;
//
//    public function __construct(
//        MaintenanceRepository $maintenanceRepository,
//        ContractRepository $contractRepository,
//        SubjectRepository $subjectRepository,
//        TransferRepository $transferRepository,
//        TransferStatuses $transferStatuses
//    )
//    {
//        $this->maintenanceRepository = $maintenanceRepository;
//        $this->contractRepository = $contractRepository;
//        $this->subjectRepository = $subjectRepository;
//        $this->transferRepository = $transferRepository;
//        $this->transferStatuses = $transferStatuses;
//    }

    public function index()
    {
//        $maintenanceSubjects = $this->maintenanceRepository->getMaintenance();
//        $processingSubjects = $this->subjectRepository->getProcessingSubjects();
//        $suspectedContracts = $this->contractRepository->getSuspectedContracts();
//        $transfers = $this->transferRepository->getTransfersByStatuses();
//        $transferStatuses = $this->transferStatuses->getAllStatuses();
//
//        $unpaidSubjects = $this->subjectRepository->getProcessingSubjects();

        return view('dashboard.index');
//            , compact([
//            'maintenanceSubjects',
//            'processingSubjects',
//            'suspectedContracts',
//            'unpaidSubjects',
//            'transfers',
//            'transferStatuses'
//        ]));
    }
}
