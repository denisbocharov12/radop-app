<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend\v1\User\Auth;

use App\Exceptions\NotAjaxRequestException;
use App\Http\Controllers\Controller;
use App\Http\Mappers\Theme\ThemeLoginDataMapper;
use App\Http\Requests\Theme\User\ThemeUserLoginRequest;
use App\Models\User;
use App\Services\Theme\Product\ThemeProductManager;
use App\Services\Theme\User\ThemeUserManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Repositories\Product\ProductRepository;

final class ThemeUserLoginController extends Controller
{
    public function __construct(
        private readonly ThemeUserManager     $themeUserManager,
        private readonly ThemeLoginDataMapper $themeLoginDataMapper,
        private readonly ProductRepository    $productRepository,
        private readonly ThemeProductManager $themeProductManager,
    )
    {
    }

    /**
     * @param ThemeUserLoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
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

            $guestSessionId = config('shopping_cart.default_session_id');
            $userSessionId = $user->id;
            $guestCart = \Cart::session($guestSessionId)->getContent();
            foreach ($guestCart as $item) {
                $product = $this->productRepository->getById($item->id);
                if ($product === null) {
                    continue;
                }
                $price = $this->themeProductManager->getProductTotalSum($product);
                \Cart::session($userSessionId)->add([
                    'id' => $item->id,
                    'name' => $item->name,
                    'price' => $price,
                    'quantity' => $item->quantity,
                    'attributes' => $item->attributes,
                    'associatedModel' => $product,
                ]);
            }
            \Cart::session($guestSessionId)->clear();

            $response = array_merge($this->themeUserManager->generateResponse(true), [
                (string) config('analytics.json_payload_keys.customer_account_login_succeeded') => (object) [],
            ]);

            return response()->json($response);
        }

        $response = $this->themeUserManager->generateResponse(false);

        return response()->json($response);
    }

    public function logout(Request $request)
    {

        Session::forget('user');

        auth()->guard('user')->user()->tokens()->delete();

        $sessionId = config('shopping_cart.default_session_id');

        if (auth()->guard('user')->user()) {
            $sessionId = auth()->guard('user')->user()->id;
        }

        \Cart::session($sessionId)->clear();

        Auth::guard('user')->logout();

        toastr()->success(__('theme.logout-message') . '<button type="button" class="btn-toast-clear" onclick="toastr.clear()">' . __('theme.notification_close_btn_text') . '</button>');

        return redirect()->route('theme.home');
    }

    public function showLoginForm()
    {
        return view('frontend.v1.pages.login.login');
    }
}
