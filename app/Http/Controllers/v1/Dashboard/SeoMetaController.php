<?php

namespace App\Http\Controllers\v1\Dashboard;

use App\Exceptions\Attachments\AttachmentNotFoundException;
use App\Exceptions\Attachments\AttachmentNotFoundValidationException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Media\ModelMediaDeleteRequest;
use App\Models\SeoMeta;
use App\Repositories\SeoMetaRepository;
use Illuminate\Http\Request;
use App\Services\SeoMetaManager;
use App\Http\Requests\SeoMeta\SeoMetaRequest;
use App\Http\Requests\SeoMeta\SeoMetaUpdateRequest;
use App\Http\Mappers\SeoMeta\SeoMetaDataMapper;
use App\Enums\PageTypes;

class SeoMetaController extends Controller
{
    private SeoMetaRepository $seoMetaRepository;
    private SeoMetaManager $seoMetaManager;
    private SeoMetaDataMapper $seoMetaDataMapper;
    private PageTypes $pageTypes;

    public function __construct(SeoMetaRepository $seoMetaRepository, SeoMetaManager $seoMetaManager, SeoMetaDataMapper $seoMetaDataMapper, PageTypes $pageTypes)
    {
        $this->seoMetaRepository = $seoMetaRepository;
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
        $groups = SeoMeta::query()
            ->select('page_type', 'page_id')
            ->groupBy('page_type', 'page_id')
            ->orderBy('page_type')
            ->orderBy('page_id')
            ->paginate(20);

        $groupedSeoMetas = $groups->getCollection()->map(function ($item) {
            $ru = SeoMeta::query()
                ->where('page_type', $item->page_type)
                ->where('page_id', $item->page_id)
                ->where('locale', 'ru')
                ->first();
            $ro = SeoMeta::query()
                ->where('page_type', $item->page_type)
                ->where('page_id', $item->page_id)
                ->where('locale', 'ro')
                ->first();

            return [
                'page_type' => $item->page_type,
                'page_id' => $item->page_id,
                'ru' => $ru,
                'ro' => $ro,
            ];
        });

        $groups->setCollection($groupedSeoMetas);

        return view('v1.seo_meta.index', [
            'seoMetas' => $groups,
        ]);
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

    /**
     * @param SeoMetaRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
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
        $pageTypes = $this->pageTypes->getAll();
        $staticPages = $this->pageTypes->getStaticPages();
        $dynamicPages = $this->pageTypes->getDynamicPages();

        $ru = SeoMeta::query()
            ->where('page_type', $seoMeta->page_type)
            ->where('page_id', $seoMeta->page_id)
            ->where('locale', 'ru')
            ->first();
        $ro = SeoMeta::query()
            ->where('page_type', $seoMeta->page_type)
            ->where('page_id', $seoMeta->page_id)
            ->where('locale', 'ro')
            ->first();

        return view('v1.seo_meta.edit', [
            'pageTypes' => $pageTypes,
            'staticPages' => $staticPages,
            'dynamicPages' => $dynamicPages,
            'seoMeta' => $seoMeta,
            'seoMetaRu' => $ru,
            'seoMetaRo' => $ro,
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
     * @param ModelMediaDeleteRequest $request
     * @param SeoMeta $seoMeta
     * @return \Illuminate\Http\JsonResponse
     * @throws AttachmentNotFoundValidationException
     */
    public function deleteMedia(ModelMediaDeleteRequest $request, SeoMeta $seoMeta)
    {
        try {
            $this->seoMetaManager->deleteMediaFromBrand($request, $seoMeta);

            return response()->json(['status' => true]);
        } catch (AttachmentNotFoundException $e) {
            throw new AttachmentNotFoundValidationException();
        }
    }
}
