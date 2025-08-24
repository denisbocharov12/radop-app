<?php

declare(strict_types=1);

namespace App\Services\Banner;

use App\Exceptions\Banner\BannerNotFoundException;
use App\Http\Requests\Banner\BannerDeleteRequest;
use App\Repositories\Banner\BannerRepository;

final class BannerManager
{
    private BannerRepository $bannerRepository;

    public function __construct(
        BannerRepository $bannerRepository,
    )
    {
        $this->bannerRepository = $bannerRepository;
    }

    public function delete(BannerDeleteRequest $request): void
    {
        $bannerId = (int)$request->banner_id;

        $banner = $this->bannerRepository->getById($bannerId);

        if ($banner === null) {
            throw new BannerNotFoundException();
        }

        $banner->delete();
    }
} 