<?php
declare(strict_types=1);

namespace App\Http\Controllers\Frontend\v1\Contact;

use App\Enums\PageTypes;
use App\Http\Controllers\Controller;
use App\Http\Requests\Theme\Contact\ThemeContactLeadRequest;
use App\Mail\ContactLeadMail;
use App\Repositories\SeoMetaRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
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
    /**
     * Заявка с формы: письмо менеджерам и ответ для витрины.
     *
     * Событие generate_lead отправляется на витрине только после успешного
     * ответа — как требует документация Google, не по клику на кнопку.
     */
    public function lead(ThemeContactLeadRequest $request): JsonResponse
    {
        $lead = [
            'name' => (string) $request->input('name'),
            'email' => (string) $request->input('email', ''),
            'phone' => (string) $request->input('phone', ''),
            'message' => (string) $request->input('message'),
            'page' => (string) $request->input('page', url()->previous()),
        ];

        try {
            Mail::to(config('mail.admin_email'))->send(new ContactLeadMail($lead));
        } catch (\Throwable $e) {
            // Письмо не ушло — заявку всё равно не теряем: она в журнале.
            Log::error('Заявка с сайта не отправлена письмом: ' . $e->getMessage(), $lead);

            return response()->json([
                'status' => false,
                'message' => __('contact.form_error'),
            ], 500);
        }

        Log::info('Заявка с сайта', $lead);

        return response()->json([
            'status' => true,
            'message' => __('contact.form_success'),
            'lead' => [
                'lead_source' => 'contact_form',
                'form_location' => $lead['page'],
            ],
        ]);
    }
}
