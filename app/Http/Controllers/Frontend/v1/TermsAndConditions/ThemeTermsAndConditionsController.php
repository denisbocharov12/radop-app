<?php
declare(strict_types=1);

namespace App\Http\Controllers\Frontend\v1\TermsAndConditions;

use App\Http\Controllers\Controller;

final class ThemeTermsAndConditionsController extends Controller
{
    public function index()
    {
        return view('frontend.v1.pages.terms-and-condition.index');
    }
}
