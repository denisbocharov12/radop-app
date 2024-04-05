<?php

declare(strict_types=1);

namespace App\Http\Controllers\v1;

use App\Exceptions\InvalidAttributeException;
use App\Exceptions\InvalidEmailVerificationTokenValidationException;
use App\Exceptions\ModelNotFoundException;
use App\Exceptions\User\UserNotFoundValidationException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\EmailVerificationRequest;
use App\Services\Auth\RegistrationManager;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class EmailConfirmationController extends Controller
{
    private RegistrationManager $registrationManager;

    public function __construct(
        RegistrationManager $registrationManager
    ) {
        $this->registrationManager = $registrationManager;
    }

    public function __invoke(EmailVerificationRequest $request): JsonResponse
    {
        try {
            $this->registrationManager->confirmEmail($request->get('token'));

            return response()->json('Ok', Response::HTTP_OK);
        } catch(InvalidAttributeException $e){
            throw new InvalidEmailVerificationTokenValidationException();
        } catch(ModelNotFoundException $e){
            throw new UserNotFoundValidationException();
        }
    }
}
