<?php

namespace App\Contracts;

interface SearchServiceInterface
{
    /**
     * Perform a unified search across all content types.
     *
     * @param string $query
     * @param int $perPage
     * @param int $page
     * @return array
     */
    public function search(string $query, int $perPage = 10, int $page = 1): array;

    /**
     * Get search suggestions for typeahead.
     *
     * @param string $query
     * @param int $limit
     * @return array
     */
    public function getSuggestions(string $query, int $limit = 5): array;

    /**
     * Rebuild search index for all models.
     *
     * @return array
     */
    public function rebuildIndex(): array;
}

