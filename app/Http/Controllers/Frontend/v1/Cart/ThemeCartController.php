<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend\v1\Cart;
use App\Http\Controllers\Controller;

final class ThemeCartController extends Controller
{
    public function index()
    {
        return view('frontend.v1.pages.cart.index');
    }
}
