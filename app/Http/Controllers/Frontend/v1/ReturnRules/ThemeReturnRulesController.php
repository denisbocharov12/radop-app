<?php
declare(strict_types=1);

namespace App\Http\Controllers\Frontend\v1\ReturnRules;

use App\Http\Controllers\Controller;

final class ThemeReturnRulesController extends Controller
{
    public function index()
    {
        return view('frontend.v1.pages.return-rules.index');
    }
}
