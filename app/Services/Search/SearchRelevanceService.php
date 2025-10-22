<?php
declare(strict_types=1);

namespace App\Services\Search;

final class SearchRelevanceService
{
    /**
     * @param string $normalizedValue
     * @param array<int, string> $articles
     * @return array{sql: string, bindings: array<int, string>}
     */
    public function getRelevanceOrderSql(string $normalizedValue, array $articles = []): array
    {
        $sqlParts = [];
        $bindings = [];

        if (!empty($articles)) {
            foreach ($articles as $article) {
                $sqlParts[] = "WHEN UPPER(products.title) LIKE UPPER(?) THEN 0";
                $bindings[] = '%' . $article . '%';

                $sqlParts[] = "WHEN UPPER(products.onec_id) LIKE UPPER(?) THEN 0";
                $bindings[] = '%' . $article . '%';

                $sqlParts[] = "WHEN UPPER(products.shtrih_code) LIKE UPPER(?) THEN 0";
                $bindings[] = '%' . $article . '%';
            }
        }

        $sqlParts[] = "WHEN LOWER(products.title) = LOWER(?) THEN 1";
        $bindings[] = $normalizedValue;

        $sqlParts[] = "WHEN LOWER(products.onec_id) = LOWER(?) THEN 1";
        $bindings[] = $normalizedValue;

        $sqlParts[] = "WHEN LOWER(products.title) LIKE LOWER(?) THEN 2";
        $bindings[] = $normalizedValue . '%';

        $sqlParts[] = "WHEN LOWER(products.onec_id) LIKE LOWER(?) THEN 2";
        $bindings[] = $normalizedValue . '%';

        $sqlParts[] = "ELSE 3";

        $sql = "
            CASE
            END ASC
        ";

        return [
            'sql' => $sql,
            'bindings' => $bindings,
        ];
    }
}

