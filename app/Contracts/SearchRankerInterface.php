<?php

namespace App\Contracts;

use Illuminate\Support\Collection;

interface SearchRankerInterface
{
    /**
     * Rank search results based on relevance.
     *
     * @param Collection $results
     * @param string $query
     * @return Collection
     */
    public function rank(Collection $results, string $query): Collection;
}

