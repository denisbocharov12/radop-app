<?php

declare(strict_types=1);

namespace App\Enums;

final class ProductConditions
{
    public function getNewCondition(): string
    {
        return 'new';
    }

    public function getPopularCondition(): string
    {
        return 'popular';
    }

    public function getWinterCondition(): string
    {
        return 'winter';
    }

    public function getRegularCondition(): string
    {
        return 'regular';
    }

    public function getHotCondition(): string
    {
        return 'hot';
    }

    public function getFeaturedCondition(): string
    {
        return 'featured';
    }

    public function getAll(): array
    {
        return [
            'new' => 'New',
            'popular' => 'Popular',
            'winter' => 'Winter',
            'regular' => 'Regular',
            'hot' => 'Hot',
            'featured' => 'Featured',
        ];
    }
}
