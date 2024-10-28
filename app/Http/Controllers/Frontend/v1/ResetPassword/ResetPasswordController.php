<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend\v1\ResetPassword;

use App\Enums\PasswordResetErrorCodes;
use App\Enums\User\UserErrorCodes;
use App\Exceptions\PasswordReset\IdenticalPasswordException;
use App\Exceptions\PasswordReset\IdenticalPasswordValidationException;
use App\Exceptions\PasswordReset\PasswordResetException;
use App\Exceptions\User\UserNotFoundException;
use App\Http\Controllers\Controller;
//use App\Http\Mappers\PasswordResetDataMapper;
use App\Http\Mappers\Theme\ThemePasswordResetDataMapper;
//use App\Http\Mappers\UserLogDataMapper;
use App\Http\Requests\PasswordReset\PasswordResetRequest;
use App\Http\Requests\Theme\PasswordReset\PasswordForgetRequest;
use App\Services\ResetPassword\ResetPasswordManager;
//use App\Services\User\UserActivityLogger;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class ResetPasswordController extends Controller
{
    public function __construct(
        private readonly ResetPasswordManager $resetPasswordManager,
        private readonly ThemePasswordResetDataMapper $themePasswordResetDataMapper,
//        private readonly UserActivityLogger $userActivityLogger,
//        private readonly UserLogDataMapper $userLogDataMapper,
    ) {
    }

    public function forget(PasswordForgetRequest $request): JsonResponse
    {
        try {
            $user = $this->resetPasswordManager->sendResetPasswordMail($request->email);

//            $userLogData = $this->userLogDataMapper->mapFromRequestAndUserToNormalized($request, $user);
//            $this->userActivityLogger->logForgetPassword($userLogData);

            return response()->json(status: Response::HTTP_OK);
        } catch (UserNotFoundException) {
            throw new NotFoundHttpException(trans(UserErrorCodes::NOT_FOUND->value));
        }
    }

    public function reset(PasswordResetRequest $request): JsonResponse
    {
        $passwordResetData = $this->themePasswordResetDataMapper->mapFromRequestToNormalized($request);

        try {
            $user = $this->resetPasswordManager->reset($passwordResetData);

//            $userLogData = $this->userLogDataMapper->mapFromRequestAndUserToNormalized($request, $user);
//            $this->userActivityLogger->logResetPassword($userLogData);

            return response()->json(status: Response::HTTP_OK);
        } catch (PasswordResetException) {
            throw new NotFoundHttpException(trans(PasswordResetErrorCodes::NOT_FOUND->value));
        } catch (UserNotFoundException) {
            throw new NotFoundHttpException(trans(UserErrorCodes::NOT_FOUND->value));
        } catch (IdenticalPasswordException) {
            throw new IdenticalPasswordValidationException(
                Response::HTTP_BAD_REQUEST,
                trans(PasswordResetErrorCodes::IDENTICAL_PASSWORD->value)
            );
        }
    }
}
