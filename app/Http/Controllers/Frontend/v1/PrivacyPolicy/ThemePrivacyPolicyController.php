<?php
declare(strict_types=1);

namespace App\Http\Controllers\Frontend\v1\PrivacyPolicy;

use App\Http\Controllers\Controller;

final class ThemePrivacyPolicyController extends Controller
{
    public function index()
    {
        return view('frontend.v1.pages.privacy-policy.index');
    }
}
