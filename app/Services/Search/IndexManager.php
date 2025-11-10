<?php

namespace App\Services\Search;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Single Responsibility: Manage search index operations
 */
class IndexManager
{
    /**
     * @var array
     */
    protected array $searchableModels;

    public function __construct(array $searchableModels)
    {
        $this->searchableModels = $searchableModels;
    }

    /**
     * Rebuild search index for all models.
     */
    public function rebuildAll(): array
    {
        $results = [];
        
        foreach ($this->searchableModels as $model) {
            $results[class_basename($model)] = $this->rebuildForModel($model);
        }
        
        return $results;
    }

    /**
     * Rebuild search index for a specific model.
     */
    protected function rebuildForModel(string $model): array
    {
        try {
            $modelInstance = new $model();
            
            // Clear old index (only for drivers that use separate tables like meilisearch, algolia)
            // The database driver searches directly on model tables, so no need to clear
            $scoutDriver = config('scout.driver');
            if (in_array($scoutDriver, ['meilisearch', 'algolia'])) {
                // For these drivers, Scout handles the clearing automatically
                $model::makeAllSearchableUsing(function ($query) {
                    return $query->limit(0);
                })->searchable();
            }
            
            // Re-index in chunks
            $count = $model::count();
            $model::makeAllSearchable();
            
            return [
                'status' => 'success',
                'count' => $count,
            ];
        } catch (\Exception $e) {
            Log::error("Failed to rebuild index for {$model}", [
                'error' => $e->getMessage(),
            ]);
            
            return [
                'status' => 'error',
                'message' => $e->getMessage(),
            ];
        }
    }
}

