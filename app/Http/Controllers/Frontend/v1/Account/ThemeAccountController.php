<?php

namespace App\Http\Controllers\Frontend\v1\Account;

use App\Exceptions\User\DuplicatedUserEmailException;
use App\Exceptions\User\DuplicatedUserEmailValidationException;
use App\Http\Controllers\Controller;
use App\Http\Mappers\ClientUpdateDataMapper;
use App\Http\Mappers\Theme\ThemeAccountDataMapper;
use App\Http\Requests\Client\ClientRequest;
use App\Http\Requests\Theme\Account\ThemeAccountRequest;
use App\Models\User;
use App\Services\Theme\Account\ThemeAccountManager;
use Illuminate\Support\Facades\Auth;

final class ThemeAccountController extends Controller
{
    public function __construct(
        private readonly ThemeAccountDataMapper $themeAccountDataMapper,
        private readonly ThemeAccountManager $themeAccountManager
    )
    {
    }

    public function index()
    {
        $user = Auth::guard('user')->user();

        return view('frontend.v1.pages.account.index', compact([
            'user'
    ]));
    }

    public function update(User $user, ThemeAccountRequest $request)
    {
        $clientData = $this->themeAccountDataMapper->mapFromRequestToNormalized($request);

        try {
            $this->themeAccountManager->update($clientData, $user);

            return redirect()->route('theme.account.index');

        } catch (DuplicatedUserEmailException $e) {
            throw new DuplicatedUserEmailValidationException();
        }
    }

}
