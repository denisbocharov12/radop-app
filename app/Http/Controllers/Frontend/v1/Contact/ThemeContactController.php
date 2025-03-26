<?php
declare(strict_types=1);

namespace App\Http\Controllers\Frontend\v1\Contact;

use App\Http\Controllers\Controller;

final class ThemeContactController extends Controller
{
    public function index()
    {
        return view('frontend.v1.pages.contact.index');
    }
}
