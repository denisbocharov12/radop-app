<?php

namespace App\Http\Controllers;

use App\Http\Mappers\BannerDataMapper;
use App\Models\Banner;
use App\Models\BannerSetting;
use App\Repositories\Banner\BannerRepository;
use App\Http\Requests\BannerRequest;
use App\Http\Requests\Banner\BannerDeleteRequest;
use App\Services\Banner\BannerManager;
use App\Exceptions\Banner\BannerNotFoundValidationException;
use App\Exceptions\Banner\BannerNotFoundException;
use App\Exceptions\NotAjaxRequestException;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function __construct(
        private readonly BannerDataMapper $bannerDataMapper,
        private readonly BannerRepository $bannerRepository,
        private readonly BannerManager $bannerManager,
    ){
    }

    public function index()
    {
        $banners = $this->bannerRepository->getAllPaginated();

        return view('banner.index', compact('banners'));
    }

    public function store(BannerRequest $request)
    {
        $bannerData = $this->bannerDataMapper->mapFromRequestToNormalized($request);
        $pathRu = '';
        $pathRo = '';

        if ($request->hasFile('image_ro')) {
            $pathRo = $request->file('image_ro')->store('banners', 'public');
        }

        if ($request->hasFile('image_ru')) {
            $pathRu = $request->file('image_ru')->store('banners', 'public');
        }

        $order = $bannerData->order;

        if (Banner::where('order', $order)->exists()) {
            $order = Banner::max('order') + 1;
        }

        Banner::create([
            'image_path_ru' => $pathRu,
            'image_path_ro' => $pathRo,
            'link' => $bannerData->link,
            'active' => $bannerData->active,
            'order' => $order,
        ]);

        return redirect()->back()->with('success', 'Баннер успешно добавлен');
    }

    public function edit(Banner $banner)
    {
        return view('banner.edit', compact([
            'banner',
        ]));
    }

    public function update(BannerRequest $request, Banner $banner)
    {
        $bannerData = $this->bannerDataMapper->mapFromRequestToNormalized($request);

        if ($request->hasFile('image_ro')) {
            $pathRo = $request->file('image_ro')->store('banners', 'public');
        } else {
            $pathRo = $banner->image_path_ro;
        }

        if ($request->hasFile('image_ru')) {
            $pathRu = $request->file('image_ru')->store('banners', 'public');
        } else {
            $pathRu = $banner->image_path_ru;
        }

        $order = $bannerData->order;

        $isActivating = !$banner->active && $bannerData->active;

        if ($isActivating) {
            $existing = $this->bannerRepository->checkIfBannedWithSameOrderExists($order, $banner);

            if ($existing) {
                $order = Banner::max('order') + 1;
            }
        }

        $banner->update([
            'image_path_ru' => $pathRu,
            'image_path_ro' => $pathRo,
            'link' => $bannerData->link,
            'active' => $bannerData->active,
            'order' => $order,
        ]);

        return redirect()->route('banner.edit', $banner)->with('success', 'Баннер успешно обновлён');
    }

    public function sortBanner()
    {
        $banners = Banner::where('active', true)->orderBy('order')->get();

        return view('banner.sort', compact('banners'));
    }

    public function sortBannerOrder(Request $request)
    {
        $banners = Banner::where('active', true)->orderBy('order')->get();

        foreach ($banners as $banner) {
            foreach ($request->order as $orderItem) {
                if ((int)$orderItem['id'] === $banner->id) {
                    $banner->update(['order' => $orderItem['position']]);
                }
            }
        }

        return response()->json(['status' => true, 'text' => 'Баннеры успешно отсортированы']);
    }

    public function editBannerSettings()
    {
        $settings = BannerSetting::first() ?? new BannerSetting([
            'rotation_speed'       => 3000,
            'new_slider_speed'     => 3000,
            'popular_slider_speed' => 3000,
            'sale_slider_speed'    => 3000,
        ]);

        return view('banner.settings', compact('settings'));
    }

    public function updateBannerSettings(Request $request)
    {
        $validated = $request->validate([
            'rotation_speed'       => 'required|integer|min:100',
            // Home product-slider auto-switch speed (ms). 0 = autoplay off.
            'new_slider_speed'     => 'required|integer|min:0',
            'popular_slider_speed' => 'required|integer|min:0',
            'sale_slider_speed'    => 'required|integer|min:0',
        ]);

        BannerSetting::updateOrCreate([], $validated);

        \Illuminate\Support\Facades\Cache::forget('home_page_slider_speeds');

        return redirect()->back()->with('success', 'Настройки обновлены.');
    }

    public function destroy(BannerDeleteRequest $request)
    {
        if (!$request->ajax()) {
            throw new NotAjaxRequestException();
        }

        try {
            $this->bannerManager->delete($request);

            return response()->json(['id' => $request->banner_id]);
        } catch (BannerNotFoundException $e) {
            throw new BannerNotFoundValidationException();
        }
    }
}
