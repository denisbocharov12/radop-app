<?php

declare(strict_types=1);

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Mappers\LoginDataMapper;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\UserInfoResource;
use App\Models\User;
use App\Repositories\User\UserRepository;
use App\Services\Auth\LoginManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use function PHPUnit\Framework\isEmpty;

class AuthController extends Controller
{
    private LoginManager $loginManager;
    private LoginDataMapper $loginDataMapper;
    private UserRepository $userRepository;

    public function __construct(
        LoginManager $loginManager,
        LoginDataMapper $loginDataMapper,
        UserRepository $userRepository
    ) {
        $this->loginManager = $loginManager;
        $this->loginDataMapper = $loginDataMapper;
        $this->userRepository = $userRepository;
    }

    public function login(){
        return view('v1.auth.login');
    }

    public function auth(LoginRequest $request)
    {
        $loginData = $this->loginDataMapper->mapFromRequestToNormalized($request);
        $credentials = $this->loginManager->getCredentials($loginData);

        $checkedUser = $this->userRepository->getByUsernameOrEmail($loginData->username);

        if (!empty($checkedUser) && $checkedUser->hasRole('user')) {
            return redirect()->back()->withErrors(['role_permission' => 'Отказано в доступе']);
        }

        if (Auth::guard('web')->attempt($credentials)) {
            /** @var User $user */
            $user = Auth::guard('web')->user();

            return redirect()->route('dashboard.index');
        }

        return redirect()->route('login')->withErrors(['auth' => 'Неверный логин или пароль']);
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        /** @phpstan-ignore-next-line */
        //$request->user()->currentAccessToken()->delete();

        return redirect()->route('login');
    }

    public function userInfo(): JsonResponse
    {
        $user = User::find(Auth::id());

        /** @phpstan-ignore-next-line */
        return response()->json(new UserInfoResource($user), Response::HTTP_OK);
    }
}
