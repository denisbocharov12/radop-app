<?php

namespace App\Http\Controllers\v1\User;

use App\Http\Controllers\Controller;
use App\Http\Mappers\LoginDataMapper;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Services\Auth\LoginManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

final class UserAuthController extends Controller
{
    private LoginManager $loginManager;
    private LoginDataMapper $loginDataMapper;

    public function __construct(
        LoginManager $loginManager,
        LoginDataMapper $loginDataMapper
    ) {
        $this->loginManager = $loginManager;
        $this->loginDataMapper = $loginDataMapper;
    }

    public function login(){
        return view('user.v1.auth.login');
    }

    public function auth(LoginRequest $request)
    {
        $loginData = $this->loginDataMapper->mapFromRequestToNormalized($request);
        $credentials = $this->loginManager->getCredentials($loginData);

        if (Auth::guard('user')->attempt($credentials)) {
            /** @var User $user */

            $user = Auth::guard('user')->user();
            $user->createToken(config('app.name'));

            return redirect()->route('user.dashboard');
        }

        return redirect()->back()->withErrors(['auth' => 'Неверный логин или пароль.']);
    }

    public function logout(Request $request)
    {
        auth()->guard('user')->user()->tokens()->delete();

        Auth::guard('user')->logout();
        /** @phpstan-ignore-next-line */
        //$request->user()->currentAccessToken()->delete();

        return redirect()->route('user.login');
    }
}
