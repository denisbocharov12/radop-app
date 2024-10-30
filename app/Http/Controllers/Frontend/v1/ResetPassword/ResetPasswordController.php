<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend\v1\ResetPassword;

use App\Enums\PasswordResetErrorCodes;
use App\Exceptions\PasswordReset\IdenticalPasswordException;
use App\Exceptions\PasswordReset\IdenticalPasswordValidationException;
use App\Exceptions\PasswordReset\PasswordResetException;
use App\Exceptions\User\UserNotFoundException;
use App\Exceptions\User\UserNotFoundValidationException;
use App\Http\Controllers\Controller;
use App\Http\Mappers\Theme\ThemePasswordResetDataMapper;
use App\Http\Requests\PasswordReset\PasswordResetRequest;
use App\Http\Requests\Theme\PasswordReset\PasswordForgetRequest;
use App\Services\ResetPassword\ResetPasswordManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class ResetPasswordController extends Controller
{
    public function __construct(
        private readonly ResetPasswordManager $resetPasswordManager,
        private readonly ThemePasswordResetDataMapper $themePasswordResetDataMapper,
    ) {
    }

    /**
     * @throws UserNotFoundValidationException
     */
    public function forget(PasswordForgetRequest $request)
    {
        try {
            $this->resetPasswordManager->sendResetPasswordMail($request->email);

            return redirect()->back();
        } catch (UserNotFoundException $e) {
            throw new UserNotFoundValidationException();
        }
    }

    public function reset(PasswordResetRequest $request)
    {
        $passwordResetData = $this->themePasswordResetDataMapper->mapFromRequestToNormalized($request);

        try {
            $this->resetPasswordManager->reset($passwordResetData);

            return redirect()->back();
        } catch (PasswordResetException) {
            throw new NotFoundHttpException(trans(PasswordResetErrorCodes::NOT_FOUND->value));
        } catch (UserNotFoundException) {
            throw new UserNotFoundValidationException();
        } catch (IdenticalPasswordException) {
            throw new IdenticalPasswordValidationException(
                Response::HTTP_BAD_REQUEST,
                trans(PasswordResetErrorCodes::IDENTICAL_PASSWORD->value)
            );
        }
    }
}
