<?php

namespace App\Data\SeoMeta;

class SeoMetaData
{
    public function __construct(
        public string $page_type,
        public ?string $page_id,
        public string $locale,
        public ?string $title,
        public ?string $description,
        public ?string $keywords,
        public ?string $og_image,
        public ?string $canonical,
        public ?string $robots,
        public ?array $attachments,
    ) {}
}
