<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Serves the sitemaps that `php artisan sitemap:generate` writes into
 * storage/app/sitemap. Storage is a persistent volume in production, while
 * public/ is rebuilt from git on every deploy.
 */
final class SitemapController extends Controller
{
    public const SECTIONS = ['pages', 'categories', 'brands', 'products'];

    public function index(): BinaryFileResponse
    {
        return $this->serve('sitemap.xml');
    }

    public function section(string $section): BinaryFileResponse
    {
        return $this->serve('sitemap-' . $section . '.xml');
    }

    private function serve(string $file): BinaryFileResponse
    {
        $path = storage_path('app/sitemap/' . $file);
        if (!is_file($path)) {
            throw new NotFoundHttpException();
        }

        $response = response()->file($path, ['Content-Type' => 'text/xml; charset=UTF-8']);
        $response->setPublic();
        $response->setMaxAge(3600);
        $response->setAutoLastModified();

        return $response;
    }
}
