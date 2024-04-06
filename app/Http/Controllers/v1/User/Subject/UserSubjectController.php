<?php

namespace App\Http\Controllers\v1\User\Subject;

use App\Exceptions\Maib\MaibRegisterTransactionException;
use App\Exceptions\Maib\MaibRegisterTransactionValidationException;
use App\Exceptions\NotAjaxRequestException;
use App\Exceptions\Subscribe\SubscribeExistedValidationException;
use App\Http\Controllers\Controller;
use App\Http\Mappers\MaibRegisterRecurrentTransactionDataMapper;
use App\Http\Mappers\MaibRegisterTransactionDataMapper;
use App\Http\Mappers\SubjectCalculateDataMapper;
use App\Http\Requests\Maib\MaibAddRecurrentTransactionRequest;
use App\Http\Requests\Maib\MaibAddTransactionRequest;
use App\Http\Requests\Subject\SubjectCalculateRequest;
use App\Models\Subject;
use App\Repositories\Subject\SubjectRepository;
use App\Repositories\Subscribe\SubscribeRepository;
use App\Services\Maib\MaibClient;
use App\Services\Maib\MaibManager;
use App\Services\Subject\UserSubjectManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class UserSubjectController extends Controller
{
    private const AGREE = 'agree';

    private SubjectRepository $subjectRepository;
    private UserSubjectManager $userSubjectManager;
    private SubjectCalculateDataMapper $subjectCalculateDataMapper;
    private MaibRegisterTransactionDataMapper $maibRegisterTransactionDataMapper;
    private MaibRegisterRecurrentTransactionDataMapper $maibRegisterRecurrentTransactionDataMapper;
    private MaibManager $maibManager;
    private SubscribeRepository $subscribeRepository;

    public function __construct(
        SubjectRepository $subjectRepository,
        UserSubjectManager $userSubjectManager,
        SubjectCalculateDataMapper $subjectCalculateDataMapper,
        MaibRegisterTransactionDataMapper $maibRegisterTransactionDataMapper,
        MaibRegisterRecurrentTransactionDataMapper $maibRegisterRecurrentTransactionDataMapper,
        MaibManager $maibManager,
        SubscribeRepository $subscribeRepository
    )
    {
        $this->subjectRepository = $subjectRepository;
        $this->userSubjectManager = $userSubjectManager;
        $this->subjectCalculateDataMapper = $subjectCalculateDataMapper;
        $this->maibRegisterTransactionDataMapper = $maibRegisterTransactionDataMapper;
        $this->maibRegisterRecurrentTransactionDataMapper = $maibRegisterRecurrentTransactionDataMapper;
        $this->maibManager = $maibManager;
        $this->subscribeRepository = $subscribeRepository;
    }

    public function show(Subject $subject)
    {
        $user = Auth::guard('user')->user();
        $subscribe = $this->subscribeRepository->getBySubjectIdWithoutTrashed($subject->id);

        if ($user->can('view', $subject)) {
            return view('user.v1.subject.subject', compact(['subject', 'subscribe']));
        } else {
            return redirect()->back();
        }

    }

    public function calculate(Subject $subject, SubjectCalculateRequest $request)
    {
        if (!$request->ajax())
        {
            throw new NotAjaxRequestException();
        }

        $user = Auth::guard('user')->user();

        if ($user->can('update', $subject)) {
            $subjectCalculateData = $this->subjectCalculateDataMapper->mapFromRequestToNormalized($request);

            return $this->userSubjectManager->calculatePrice($subject, $subjectCalculateData);

        } else {
            abort(403);
        }

    }

    public function registerSmsTransaction(Subject $subject, MaibAddTransactionRequest $request) {

        $user = Auth::guard('user')->user();

        if ($user->can('update', $subject)) {

            $maibRegisterTransactionData = $this->maibRegisterTransactionDataMapper->mapFromRequestToNormalized($request);

            if ($maibRegisterTransactionData->paymentAgree === self::AGREE) {
                try {
                    $transactionId = $this->maibManager->clientRegisterSmsTransaction($maibRegisterTransactionData, $request->ip(), $subject, $user);

                    if ($transactionId !== null) {

                        return Redirect::away($transactionId);
                    }

                } catch (MaibRegisterTransactionException $e) {
                    throw new MaibRegisterTransactionValidationException();
                }
            }

        }

        return redirect()->back()->withErrors(['payment_agree'=> 'Необходимо согласиться с правилами и условиями сайта.']);
    }

    public function registerRecurrentTransaction(Subject $subject, MaibAddRecurrentTransactionRequest $request) {

        $user = Auth::guard('user')->user();

        $existedSubscribe = $this->subscribeRepository->getBySubjectIdWithoutTrashed($subject->id);

        if (!empty($existedSubscribe)) {
            throw new SubscribeExistedValidationException();
        }

        if ($user->can('update', $subject)) {

            $maibRegisterTransactionData = $this->maibRegisterRecurrentTransactionDataMapper->mapFromRequestToNormalized($request);

            if ($maibRegisterTransactionData->paymentAgree === self::AGREE) {
                try {
                    $subscribeId = $this->maibManager->clientRegisterRecurrentTransaction($request->ip(), $subject, $user);

                    if ($subscribeId !== null) {

                        return Redirect::away($subscribeId);
                    }

                } catch (MaibRegisterTransactionException $e) {
                    throw new MaibRegisterTransactionValidationException();
                }
            }

        }

        return redirect()->back()->withErrors(['payment_agree'=> 'Необходимо согласиться с правилами и условиями сайта.']);
    }
}
