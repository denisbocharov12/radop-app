<?php

namespace App\Http\Mappers\SeoMeta;

use App\Data\SeoMeta\SeoMetaData;
use Illuminate\Http\Request;

class SeoMetaDataMapper
{
    public function mapFromRequestToData(Request $request): SeoMetaData
    {
        return new SeoMetaData(
            $request->input('page_type'),
            $request->input('page_id'),
            $request->input('locale'),
            $request->input('title'),
            $request->input('description'),
            $request->input('keywords'),
            $request->input('og_image'),
            $request->input('canonical'),
            $request->input('robots'),
            $request->attachments,
        );
    }
}
