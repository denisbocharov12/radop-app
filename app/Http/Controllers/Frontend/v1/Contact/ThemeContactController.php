<?php
declare(strict_types=1);

namespace App\Http\Controllers\Frontend\v1\Contact;

use App\Enums\PageTypes;
use App\Http\Controllers\Controller;
use App\Repositories\SeoMetaRepository;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Traits\SEOTools;

final class ThemeContactController extends Controller
{
    use SEOTools;

    public function __construct(
        private readonly SeoMetaRepository $seoMetaRepository,
        private readonly PageTypes $pageTypes,
    )
    {
    }

    public function index()
    {
        $seo = $this->seoMetaRepository->getStatic($this->pageTypes->getContactType(), app()->getLocale());

        if ($seo !== null) {
            $this->seo()->setTitle($seo->title ?? trans('seo.title', [], app()->getLocale()));
            $this->seo()->setDescription($seo->description ?? trans('seo.description', [], app()->getLocale()));
            $this->seo()->addImages($seo->getFirstMediaUrl('files') ?? config('seotools.meta.defaults.default_image'));

            (array)$seoKeywords = $seo?->keywords !== null && $seo?->keywords !== '' ? explode(',', $seo?->keywords) : trans('seo.keywords', [], app()->getLocale());

            SeoMeta::setKeywords($seoKeywords);

            $this->seo()->opengraph()->setUrl(route('theme.contacts.index'));
            $this->seo()->opengraph()->addProperty('type', 'page');
            $this->seo()->jsonLd()->setType('WebPage');
        }

        return view('frontend.v1.pages.contact.index');
    }
}
