<?php

namespace App\Http\Controllers\v1\User\Subscribe;

use App\Exceptions\Subscribe\SubscribeNotFoundException;
use App\Exceptions\Subscribe\SubscribeNotFoundValidationException;
use App\Http\Controllers\Controller;
use App\Http\Mappers\MaibRegisterRecurrentTransactionDataMapper;
use App\Http\Requests\Maib\MaibAddRecurrentTransactionRequest;
use App\Models\Subject;
use App\Models\Subscribe;
use App\Models\SubscribeHistory;
use App\Repositories\Subject\SubjectRepository;
use App\Repositories\Subscribe\SubscribeRepository;
use App\Services\Maib\MaibManager;
use App\Services\Transaction\TransactionRecurrentManager;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

final class UserSubscribeController extends Controller
{
    private const AGREE = 'agree';

    private MaibManager $maibManager;
    private MaibRegisterRecurrentTransactionDataMapper $maibRegisterRecurrentTransactionDataMapper;
    private TransactionRecurrentManager $transactionRecurrentManager;
    private SubscribeRepository $subscribeRepository;
    private SubjectRepository $subjectRepository;

    public function __construct(
        MaibManager $maibManager,
        MaibRegisterRecurrentTransactionDataMapper $maibRegisterRecurrentTransactionDataMapper,
        TransactionRecurrentManager $transactionRecurrentManager,
        SubscribeRepository $subscribeRepository,
        SubjectRepository $subjectRepository
    )
    {
        $this->maibManager = $maibManager;
        $this->maibRegisterRecurrentTransactionDataMapper = $maibRegisterRecurrentTransactionDataMapper;
        $this->transactionRecurrentManager = $transactionRecurrentManager;
        $this->subscribeRepository = $subscribeRepository;
        $this->subjectRepository = $subjectRepository;
    }

    public function show(Subscribe $subscribe)
    {
        $user = Auth::guard('user')->user();

        if ($user->can('show', $subscribe)) {

            return view('user.v1.subscribe.subscribe_existed', compact([
                'user',
                'subscribe'
            ]));
        } else {
            abort(503);
        }
    }

    public function get(Subject $subject)
    {
        $user = Auth::guard('user')->user();

        if ($user->can('view', $subject)) {
            return view('user.v1.subscribe.subscribe', compact([
                'user',
                'subject'
            ]));
        } else {
            return redirect()->back();
        }
    }

    public function destroy(Subscribe $subscribe, MaibAddRecurrentTransactionRequest $request)
    {
        $user = Auth::guard('user')->user();

        if ($user->can('show', $subscribe)) {

            $maibRegisterTransactionData = $this->maibRegisterRecurrentTransactionDataMapper->mapFromRequestToNormalized($request);

            if ($maibRegisterTransactionData->paymentAgree === self::AGREE) {
                try {
                    $this->maibManager->revertMaibRecurrentTransaction($subscribe);

                    return redirect()->route('user.subject.show', $subscribe->subject);
                } catch (SubscribeNotFoundException) {
                    throw new SubscribeNotFoundValidationException();
                }
            }
        } else {
            abort(503);
        }
    }

    public function thankYou(Subscribe $subscribe)
    {
        $user = Auth::guard('user')->user();

        if ($user->can('show', $subscribe)) {

            return view('user.v1.subscribe.thank-you', compact([
                'subscribe'
            ]));
        } else {
            abort(503);
        }
    }

    public function list(Subscribe $subscribe)
    {
        $user = Auth::guard('user')->user();

        if ($user->can('show', $subscribe)) {

            $subscribeHistories = $this->subscribeRepository->getSubscribeHistoryList($subscribe->id);
            $subjects = $this->subjectRepository->getByUserId($user->id);

            return view('user.v1.subscribe.list', compact([
                'subscribe',
                'user',
                'subjects',
                'subscribeHistories'
            ]));
        } else {
            abort(503);
        }
    }

    public function index()
    {
        $user = Auth::guard('user')->user();

        $subscribeHistories = $this->subscribeRepository->getSubscribeHistoryListByUserId($user->id);
        $subjects = $this->subjectRepository->getByUserId($user->id);

        return view('user.v1.subscribe.subscribes', compact([
            'user',
            'subjects',
            'subscribeHistories'
        ]));
    }

    public function generateNewSubscribeHistory(SubscribeHistory $subscribeHistory)
    {
        $user = Auth::guard('user')->user();

        if ($user->can('show', $subscribeHistory->subscribe)) {

            $data = $this->transactionRecurrentManager->generateSubscribeHistoryData($subscribeHistory);
            $pdf = Pdf::loadView('pdf.generated_subscribe_history', $data);

            return $pdf->stream('subscribe_'.$subscribeHistory->subscribe->subject->number.'_'.$subscribeHistory->created_at->format('d.m.Y H:i:s').'.pdf');
        } else {
            abort(503);
        }
    }
}
