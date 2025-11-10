<?php

namespace App\Contracts;

interface SearchLoggerInterface
{
    /**
     * Log a search query.
     *
     * @param string $query
     * @param int $resultsCount
     * @return void
     */
    public function log(string $query, int $resultsCount): void;
}

