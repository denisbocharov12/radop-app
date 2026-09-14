<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/*
 * Local development only. A database imported from production references
 * product photos, brand logos and banners that are not on this disk. The
 * built-in server still serves every file that exists; anything under /media
 * or /storage it cannot find reaches Laravel and is redirected to the same
 * path on STOREFRONT_MEDIA_FALLBACK_URL, so pages render with real images
 * without copying the media library. Never active outside `local`.
 */
if (app()->environment('local') && config('storefront.media_fallback_url')) {
    Route::get('{root}/{path}', static fn (string $root, string $path) => redirect()->away(
        rtrim((string) config('storefront.media_fallback_url'), '/') . '/' . $root . '/' . $path
    ))->where(['root' => 'media|storage', 'path' => '.*'])->name('dev.media-fallback');
}
