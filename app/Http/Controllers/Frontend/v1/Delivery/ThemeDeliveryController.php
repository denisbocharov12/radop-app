<?php
declare(strict_types=1);

namespace App\Http\Controllers\Frontend\v1\Delivery;

use App\Http\Controllers\Controller;

final class ThemeDeliveryController extends Controller
{
    public function index()
    {
        return view('frontend.v1.pages.delivery.index');
    }
}
