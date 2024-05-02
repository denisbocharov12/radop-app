<?php
declare(strict_types=1);

namespace App\Http\Controllers\Frontend\v1\Home;

use App\Http\Controllers\Controller;

final class ThemeHomeController extends Controller
{
    public function index()
    {
        return view('frontend.v1.pages.home.index');
    }
}
