<?php
declare(strict_types=1);

namespace App\Services\Search;

final class SearchRelevanceService
{
    /**
     * @param string $normalizedValue
     * @return array{sql: string, bindings: array<int, string>}
     */
    public function getRelevanceOrderSql(string $normalizedValue): array
    {
        $sql = "
            CASE
                WHEN LOWER(products.title) = LOWER(?) THEN 1
                WHEN LOWER(products.onec_id) = LOWER(?) THEN 1
                WHEN LOWER(products.title) LIKE LOWER(?) THEN 2
                WHEN LOWER(products.onec_id) LIKE LOWER(?) THEN 2
                ELSE 3
            END ASC
        ";

        $bindings = [
            $normalizedValue,
            $normalizedValue,
            $normalizedValue . '%',
            $normalizedValue . '%',
        ];

        return [
            'sql' => $sql,
            'bindings' => $bindings,
        ];
    }
}

