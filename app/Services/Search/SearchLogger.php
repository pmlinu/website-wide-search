<?php

namespace App\Services\Search;

use App\Contracts\SearchLoggerInterface;
use App\Models\SearchLog;
use Illuminate\Support\Facades\Log;

/**
 * Single Responsibility: Handle search query logging
 */
class SearchLogger implements SearchLoggerInterface
{
    /**
     * Log a search query with metadata.
     */
    public function log(string $query, int $resultsCount): void
    {
        try {
            SearchLog::create([
                'query' => $query,
                'results_count' => $resultsCount,
                'user_id' => auth()->id(),
                'ip_address' => request()->ip(),
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to log search query', [
                'query' => $query,
                'error' => $e->getMessage(),
            ]);
        }
    }
}

