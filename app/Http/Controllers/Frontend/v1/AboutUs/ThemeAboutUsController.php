<?php
declare(strict_types=1);

namespace App\Http\Controllers\Frontend\v1\AboutUs;

use App\Http\Controllers\Controller;
use App\Repositories\Brand\BrandRepository;

final class ThemeAboutUsController extends Controller
{
    public function __construct(
        private readonly BrandRepository $brandRepository,
    ) {
    }

    public function index()
    {
        $themeBrands = $this->brandRepository->getLimited();

        return view('frontend.v1.pages.about-us.index', compact([
            'themeBrands',
        ]));
    }
}
