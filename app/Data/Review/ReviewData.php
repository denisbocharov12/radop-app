<?php

namespace App\Data\Review;

/**
 * @property int $userId
 * @property string $productOnecId
 * @property string $text
 * @property float $score
 * @property bool $status
 * @property bool $isVerified
 */
final class ReviewData
{
    public function __construct(
        public readonly int $userId,
        public readonly string $productOnecId,
        public readonly string $text,
        public readonly float $score,
        public readonly bool $status,
        public readonly bool $isVerified,
    )
    {
    }
}

