<?php
declare(strict_types=1);

namespace App\Http\Controllers\Frontend\v1\Cookie;

use App\Http\Controllers\Controller;

final class ThemeCookieController extends Controller
{
    public function index()
    {
        return view('frontend.v1.pages.cookie.index');
    }
}
