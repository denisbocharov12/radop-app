<?php

namespace App\Http\Controllers\v1\User\Transaction;

use App\Exceptions\Subject\SubjectNotFoundException;
use App\Exceptions\Subject\SubjectNotFoundValidationException;
use App\Exceptions\Subscribe\SubscribeNotFoundException;
use App\Exceptions\Subscribe\SubscribeNotFoundValidationException;
use App\Exceptions\Transaction\TransactionNotFoundException;
use App\Exceptions\Transaction\TransactionNotFoundValidationException;
use App\Http\Controllers\Controller;
use App\Http\Mappers\MaibRegisterTransactionDataMapper;
use App\Http\Mappers\SubjectCalculateDataMapper;
use App\Models\Transaction;
use App\Repositories\Subject\SubjectRepository;
use App\Repositories\Subscribe\SubscribeRepository;
use App\Repositories\Transaction\TransactionRepository;
use App\Services\Maib\MaibManager;
use App\Services\Subject\UserSubjectManager;
use App\Services\Transaction\TransactionManager;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

final class UserTransactionController extends Controller
{
    private const USER_DASHBOARD = 'user.dashboard';
    private const USER_TRANSACTION = 'user.transaction.show';
    private const USER_TRANSACTIONS_LIST = 'user.transaction.index';
    private const USER_THANK_YOU = 'user.subscribe.thank-you';
    private const USER_TRANSACTION_THANK_YOU = 'user.transaction.thank-you';

    private SubjectRepository $subjectRepository;
    private UserSubjectManager $userSubjectManager;
    private SubjectCalculateDataMapper $subjectCalculateDataMapper;
    private MaibRegisterTransactionDataMapper $maibRegisterTransactionDataMapper;
    private MaibManager $maibManager;
    private TransactionRepository $transactionRepository;
    private TransactionManager $transactionManager;
    private SubscribeRepository $subscribeRepository;

    public function __construct(
        SubjectRepository $subjectRepository,
        UserSubjectManager $userSubjectManager,
        SubjectCalculateDataMapper $subjectCalculateDataMapper,
        MaibRegisterTransactionDataMapper $maibRegisterTransactionDataMapper,
        MaibManager $maibManager,
        TransactionRepository $transactionRepository,
        TransactionManager $transactionManager,
        SubscribeRepository $subscribeRepository
    )
    {
        $this->subjectRepository = $subjectRepository;
        $this->userSubjectManager = $userSubjectManager;
        $this->subjectCalculateDataMapper = $subjectCalculateDataMapper;
        $this->maibRegisterTransactionDataMapper = $maibRegisterTransactionDataMapper;
        $this->maibManager = $maibManager;
        $this->transactionRepository = $transactionRepository;
        $this->transactionManager = $transactionManager;
        $this->subscribeRepository = $subscribeRepository;
    }

    public function index() {

        $user = Auth::guard('user')->user();

        $transactions = $this->transactionRepository->getWithTrashedByUserId($user->id);
        $subjects = $this->subjectRepository->getByUserId($user->id);

        return view('user.v1.transactions.transactions', compact([
            'transactions',
            'subjects',
            'user'
        ]));
    }

    public function show(Transaction $transaction) {

        $user = Auth::guard('user')->user();
        $subjects = $this->subjectRepository->getByUserId($user->id);

        if ($user->can('get', $transaction)) {

            return view('user.v1.transactions.transaction-detail', compact([
                'transaction',
                'user',
                'subjects'
            ]));
        } else {
            abort(503);
        }
    }

    public function get(Request $request) {

        $user = Auth::guard('user')->user();

        $transactionId = $request->input('trans_id');
        $transactionStatus = $request->input('error');

        if (!empty($transactionStatus)) {
            return redirect()->route(self::USER_DASHBOARD)->withErrors(['Ошибка' => 'Введены неверные данные карты.']);
        }

        $existedTransaction = $this->transactionRepository->getByTransactionNumber($transactionId);

        if ($existedTransaction === null) {
            throw new TransactionNotFoundValidationException();
        }

        $transactionByUser = $this->transactionRepository->getTransactionByUserIdAndTransactionId($user->id, $transactionId);

        if ($transactionByUser === null) {
            throw new TransactionNotFoundValidationException();
        }

        try {
            $this->maibManager->updateMaibTransactionDataDB($transactionId, $request->ip());

            return redirect()->route(self::USER_TRANSACTION_THANK_YOU, $existedTransaction);

        } catch (TransactionNotFoundException) {
            throw new TransactionNotFoundValidationException();
        }  catch (SubjectNotFoundException) {
            throw new SubjectNotFoundValidationException();
        }
    }

    public function getSubscribe(Request $request) {

        $user = Auth::guard('user')->user();

        $subscribeId = $request->input('trans_id');
        $transactionStatus = $request->input('error');

        if (!empty($transactionStatus)) {
            return redirect()->route(self::USER_DASHBOARD)->withErrors(['Ошибка' => 'Введены неверные данные карты.']);
        }

        $existedSubscribe = $this->subscribeRepository->getBySubscribeNumber($subscribeId);

        if (!$existedSubscribe === null) {
            throw new SubscribeNotFoundValidationException();
        }

        try {
            $this->maibManager->updateMaibTransactioRecurrentnDataDB($subscribeId, $request->ip());

            return redirect()->route(self::USER_THANK_YOU, $existedSubscribe);

        } catch (SubscribeNotFoundException) {
            throw new SubscribeNotFoundValidationException();
        }  catch (SubjectNotFoundException) {
            throw new SubjectNotFoundValidationException();
        }

//        if ($user->id === $existedSubscribe->user_id) {
//
//
//        }
    }

    public function generateNewTransaction(Transaction $transaction)
    {
        $user = Auth::guard('user')->user();

        if ($user->can('get', $transaction)) {
            $data = $this->transactionManager->generateTransactionData($transaction);

            $pdf = Pdf::loadView('pdf.generated_transaction', $data);

            return $pdf->stream('transaction_'.$transaction->subject->number.'_'.$transaction->created_at->format('d.m.Y H:i:s').'.pdf');
        } else {
            abort('503');
        }

    }

    public function thankYou(Transaction $transaction)
    {
        $user = Auth::guard('user')->user();

        if ($user->can('get', $transaction)) {

            return view('user.v1.transactions.thank-you', compact([
                'transaction'
            ]));
        } else {
            abort(503);
        }
    }

}
