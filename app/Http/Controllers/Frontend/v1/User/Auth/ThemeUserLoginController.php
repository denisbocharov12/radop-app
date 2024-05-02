<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend\v1\User\Auth;

use App\Exceptions\NotAjaxRequestException;
use App\Http\Controllers\Controller;
use App\Http\Mappers\Theme\ThemeLoginDataMapper;
use App\Http\Requests\Theme\User\ThemeUserLoginRequest;
use App\Models\User;
use App\Repositories\User\UserRepository;
use App\Services\Theme\User\ThemeUserManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

final class ThemeUserLoginController extends Controller
{
    public function __construct(
        private readonly ThemeUserManager $themeUserManager,
        private readonly UserRepository $userRepository,
        private readonly ThemeLoginDataMapper $themeLoginDataMapper
    )
    {
    }

    public function login(ThemeUserLoginRequest $request)
    {
        if (!$request->ajax()) {
            throw new NotAjaxRequestException();
        }

        $loginData = $this->themeLoginDataMapper->mapFromRequestToNormalized($request);
        $credentials = $this->themeUserManager->getCredentials($loginData);

        $this->themeUserManager->putSession($request);

        if (Auth::guard('user')->attempt($credentials)) {
            /** @var User $user */

            $user = Auth::guard('user')->user();
            $user->createToken(config('app.name'));

            $response = $this->themeUserManager->generateResponse(true);

            return response()->json($response);
        }

        $response = $this->themeUserManager->generateResponse(false);

        return response()->json($response);
        //return redirect()->back()->withErrors(['auth' => 'Неверный логин или пароль.']);
    }

    public function logout(Request $request){

        Session::forget('user');

        auth()->guard('user')->user()->tokens()->delete();

        Auth::guard('user')->logout();

        toastr()->success('Вы успешно вышли с аккаунта','Успех');

        return redirect()->route('theme.home');
    }
}
