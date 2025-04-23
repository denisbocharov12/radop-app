<?php

namespace App\Http\Controllers\Frontend\v1\Filial;

use App\Exceptions\Filial\FilialNotPermittedToViewException;
use App\Exceptions\User\UserNotFoundException;
use App\Exceptions\User\UserNotFoundValidationException;
use App\Http\Controllers\Controller;
use App\Http\Mappers\Theme\ThemeFilialDataMapper;
use App\Http\Requests\Theme\Filial\ThemeFilialRequest;
use App\Models\Filial;
use App\Repositories\Filial\FilialRepository;
use App\Repositories\User\UserRepository;
use App\Services\Theme\Filial\ThemeFilialManager;
use Illuminate\Support\Facades\Auth;

class ThemeFilialController extends Controller
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly ThemeFilialDataMapper $themeFilialDataMapper,
        private readonly FilialRepository $filialRepository,
        private readonly ThemeFilialManager $themeFilialManager,
    ) {
    }

    public function index()
    {
        $user = Auth::guard('user')->user();

        $filials = $this->filialRepository->getAllByUserId($user->id);

        return view('frontend.v1.pages.filial.index', compact([
            'filials',
            'user'
        ]));
    }

    public function store(ThemeFilialRequest $request)
    {
        $user = Auth::guard('user')->user();
        $filialData = $this->themeFilialDataMapper->mapFromRequestToNormalized($request);

        try {
            $this->themeFilialManager->store($filialData, $user);

            return redirect()->route('theme.user.filial.index');

        } catch (UserNotFoundException) {
            throw new UserNotFoundValidationException();
        } catch (FilialNotPermittedToViewException) {
            return redirect()->back()->withErrors(['user_not_permitted_to_view_filial' => __('theme.user_not_permitted_to_view_filial')]);
        }
    }

    public function update(Filial $filial, ThemeFilialRequest $request)
    {
        $user = Auth::guard('user')->user();

        $filialData = $this->themeFilialDataMapper->mapFromRequestToNormalized($request);

        try {
            $this->themeFilialManager->update($filial, $filialData, $user);

            return redirect()->route('theme.user.filial.index');

        } catch (FilialNotPermittedToViewException) {
            return redirect()->back()->withErrors(['user_not_permitted_to_view_filial' => __('theme.user_not_permitted_to_view_filial')]);
        }

    }

    public function edit(Filial $filial)
    {
        $user = Auth::guard('user')->user();

        if (!$user->can('view', $filial)) {
            return redirect()->back()->withErrors(['user_not_permitted_to_view_filial' => __('theme.user_not_permitted_to_view_filial')]);
        }

        return view('frontend.v1.pages.filial.edit', compact([
            'filial',
        ]));
    }

    public function create()
    {
        return view('frontend.v1.pages.filial.create',);
    }

    public function destroy(Filial $filial)
    {

        $user = Auth::guard('user')->user();

        try {
            $this->themeFilialManager->delete($filial, $user);

            return redirect()->route('theme.user.filial.index');
        } catch (FilialNotPermittedToViewException) {
            return redirect()->back()->withErrors(['user_not_permitted_to_delete_filial' => __('theme.user_not_permitted_to_delete_filial')]);
        }
    }
}
