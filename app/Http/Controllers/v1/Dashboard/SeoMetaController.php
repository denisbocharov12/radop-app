<?php

namespace App\Http\Controllers\v1\Dashboard;

use App\Exceptions\Attachments\AttachmentNotFoundException;
use App\Exceptions\Attachments\AttachmentNotFoundValidationException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Media\ModelMediaDeleteRequest;
use App\Models\SeoMeta;
use Illuminate\Http\Request;
use App\Services\SeoMetaManager;
use App\Http\Requests\SeoMeta\SeoMetaRequest;
use App\Http\Requests\SeoMeta\SeoMetaUpdateRequest;
use App\Http\Mappers\SeoMeta\SeoMetaDataMapper;
use App\Enums\PageTypes;
use App\Services\Seo\CanonicalUrlResolver;

class SeoMetaController extends Controller
{
    private SeoMetaManager $seoMetaManager;
    private SeoMetaDataMapper $seoMetaDataMapper;
    private PageTypes $pageTypes;
    private CanonicalUrlResolver $canonicalResolver;

    /**
     * @param SeoMetaManager $seoMetaManager
     * @param SeoMetaDataMapper $seoMetaDataMapper
     * @param PageTypes $pageTypes
     */
    public function __construct(SeoMetaManager $seoMetaManager, SeoMetaDataMapper $seoMetaDataMapper, PageTypes $pageTypes, CanonicalUrlResolver $canonicalResolver)
    {
        $this->canonicalResolver = $canonicalResolver;
        $this->seoMetaManager = $seoMetaManager;
        $this->seoMetaDataMapper = $seoMetaDataMapper;
        $this->pageTypes = $pageTypes;
    }

    /**
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view('v1.seo_meta.index');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSeoMetas(Request $request)
    {
        $locale = $request->get('locale', 'ru');
        $search = $request->get('search', '');
        $page = $request->get('page', 1);

        $query = SeoMeta::query()
            ->where('locale', $locale)
            ->orderBy('page_type')
            ->orderBy('page_id');

        if ($search) {
            $query->where('page_type', 'like', "%$search%")
                ->orWhere('title', 'like', "%$search%");
        }

        $seoMetas = $query->paginate(20, ['*'], 'page', $page);

        $seoMetas->getCollection()->transform(function ($item) {
            $pageTypes = $this->pageTypes->getAll();
            $item->page_type_label = $pageTypes[$item->page_type] ?? $item->page_type;
            return $item;
        });

        $response = [
            'data' => $seoMetas->items(),
            'pagination' => [
                'current_page' => $seoMetas->currentPage(),
                'last_page' => $seoMetas->lastPage(),
                'per_page' => $seoMetas->perPage(),
                'total' => $seoMetas->total(),
            ]
        ];

        return response()->json($response);
    }

    /**
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $pageTypes = $this->pageTypes->getAll();
        $staticPages = $this->pageTypes->getStaticPages();
        $dynamicPages = $this->pageTypes->getDynamicPages();

        return view('v1.seo_meta.create', compact('pageTypes', 'staticPages', 'dynamicPages'));
    }

    public function store(SeoMetaRequest $request)
    {
        $data = $this->seoMetaDataMapper->mapFromRequestToData($request);

        $this->seoMetaManager->create($data, $request);

        return redirect()->route('seo_meta.index');
    }

    /**
     * @param SeoMeta $seoMeta
     * @return \Illuminate\View\View
     */
    public function edit(SeoMeta $seoMeta)
    {
        $pageTypes    = $this->pageTypes->getAll();
        $staticPages  = $this->pageTypes->getStaticPages();
        $dynamicPages = $this->pageTypes->getDynamicPages();

        // Suggest canonical URL if not already set
        $suggestedCanonical = $seoMeta->canonical
            ?? $this->canonicalResolver->resolve(
                $seoMeta->page_type,
                $seoMeta->page_id !== null ? (string) $seoMeta->page_id : null
            );

        return view('v1.seo_meta.edit', [
            'pageTypes'          => $pageTypes,
            'staticPages'        => $staticPages,
            'dynamicPages'       => $dynamicPages,
            'seoMeta'            => $seoMeta,
            'suggestedCanonical' => $suggestedCanonical,
        ]);
    }

    /**
     * @param SeoMetaUpdateRequest $request
     * @param SeoMeta $seoMeta
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(SeoMetaUpdateRequest $request, SeoMeta $seoMeta)
    {
        $data = $this->seoMetaDataMapper->mapFromRequestToData($request);

        $this->seoMetaManager->update($seoMeta, $data, $request);

        return redirect()->route('seo_meta.index');
    }

    /**
     * @param SeoMeta $seoMeta
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(SeoMeta $seoMeta)
    {
        $seoMeta->delete();

        return redirect()->route('seo_meta.index');
    }

    /**
     * @param SeoMeta $seoMeta
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroyAjax(SeoMeta $seoMeta)
    {
        try {
            $this->seoMetaManager->clearSeoMediaCollection($seoMeta);
            $seoMeta->delete();
            return response()->json(['status' => true, 'message' => 'Запись успешно удалена']);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'Ошибка при удалении записи'], 500);
        }
    }

    /**
     * @param ModelMediaDeleteRequest $request
     * @param SeoMeta $seoMeta
     * @return \Illuminate\Http\JsonResponse
     * @throws AttachmentNotFoundValidationException
     */
    public function deleteMedia(ModelMediaDeleteRequest $request, SeoMeta $seoMeta)
    {
        try {
            $this->seoMetaManager->deleteMediaFromSeo($request, $seoMeta);

            return response()->json(['status' => true]);
        } catch (AttachmentNotFoundException $e) {
            throw new AttachmentNotFoundValidationException();
        }
    }
}
