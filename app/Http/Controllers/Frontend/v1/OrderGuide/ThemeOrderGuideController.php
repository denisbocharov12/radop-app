<?php
declare(strict_types=1);

namespace App\Http\Controllers\Frontend\v1\OrderGuide;

use App\Http\Controllers\Controller;

final class ThemeOrderGuideController extends Controller
{
    public function index()
    {
        return view('frontend.v1.pages.order-guide.index');
    }
}
