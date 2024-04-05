<?php

declare(strict_types=1);

namespace App\Http\Controllers\v1;

use App\Exceptions\User\DuplicatedUserEmailException;
use App\Exceptions\User\DuplicatedUserEmailValidationException;
use App\Exceptions\User\DuplicatedUserNameException;
use App\Exceptions\User\DuplicatedUserNameValidationException;
use App\Http\Mappers\UserRegistrationDataMapper;
use App\Http\Requests\Auth\UserRegistrationRequest;
use App\Http\Resources\UserInfoResource;
use App\Services\Auth\RegistrationManager;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class RegistrationController
{
    private RegistrationManager $registrationManager;
    private UserRegistrationDataMapper $userRegistrationDataMapper;

    public function __construct(
        RegistrationManager $registrationManager,
        UserRegistrationDataMapper $userRegistrationDataMapper
    ) {
        $this->registrationManager = $registrationManager;
        $this->userRegistrationDataMapper = $userRegistrationDataMapper;
    }

    public function register(UserRegistrationRequest $request): JsonResponse
    {
        $userData = $this->userRegistrationDataMapper->mapFromRequestToNormalized($request);

        try {
            $user = $this->registrationManager->register($userData);

            //event(new CustomerRegisteredEvent($userData));

            return response()->json(new UserInfoResource($user), Response::HTTP_OK);
        } catch (DuplicatedUserEmailException $e) {
            throw new DuplicatedUserEmailValidationException();
        } catch (DuplicatedUserNameException $e) {
            throw new DuplicatedUserNameValidationException();
        }
    }
}
