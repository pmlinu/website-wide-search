<?php

namespace App\Services;

use App\Contracts\SearchLoggerInterface;
use App\Contracts\SearchRankerInterface;
use App\Contracts\SearchServiceInterface;
use App\Models\BlogPost;
use App\Models\Faq;
use App\Models\Page;
use App\Models\Product;
use App\Services\Search\IndexManager;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * Main Search Service following SOLID principles:
 * - Single Responsibility: Orchestrate search operations
 * - Open/Closed: Open for extension via interfaces
 * - Liskov Substitution: Uses interfaces for dependencies
 * - Interface Segregation: Focused interfaces (Ranker, Logger)
 * - Dependency Inversion: Depends on abstractions (interfaces)
 */
class SearchService implements SearchServiceInterface
{
    /**
     * Searchable models configuration
     */
    protected array $searchableModels = [
        BlogPost::class,
        Product::class,
        Page::class,
        Faq::class,
    ];

    /**
     * Dependency Injection of abstractions (DIP)
     */
    public function __construct(
        protected SearchRankerInterface $ranker,
        protected SearchLoggerInterface $logger,
        protected IndexManager $indexManager
    ) {}

    /**
     * Perform a unified search across all content types.
     */
    public function search(string $query, int $perPage = 10, int $page = 1): array
    {
        $results = $this->performSearch($query);
        
        // Delegate ranking to specialized class (SRP)
        $sortedResults = $this->ranker->rank($results, $query);
        
        // Paginate results
        $paginated = $this->paginateResults($sortedResults, $perPage, $page);
        
        // Delegate logging to specialized class (SRP)
        $this->logger->log($query, $sortedResults->count());
        
        return [
            'query' => $query,
            'total' => $sortedResults->count(),
            'per_page' => $perPage,
            'current_page' => $page,
            'last_page' => ceil($sortedResults->count() / $perPage),
            'data' => $paginated,
        ];
    }

    /**
     * Get search suggestions (typeahead).
     */
    public function getSuggestions(string $query, int $limit = 5): array
    {
        $suggestions = [];
        
        foreach ($this->searchableModels as $model) {
            $results = $model::search($query)->take($limit)->get();
            
            foreach ($results as $result) {
                $suggestions[] = [
                    'type' => $this->getModelType($model),
                    'text' => $this->getSuggestionText($result),
                    'id' => $result->id,
                ];
            }
        }
        
        return array_slice(
            array_unique($suggestions, SORT_REGULAR),
            0,
            $limit
        );
    }

    /**
     * Rebuild search index for all models.
     */
    public function rebuildIndex(): array
    {
        return $this->indexManager->rebuildAll();
    }

    /**
     * Perform search across all searchable models.
     */
    protected function performSearch(string $query): Collection
    {
        $allResults = collect();
        
        foreach ($this->searchableModels as $model) {
            try {
                $results = $model::search($query)->get();
                
                foreach ($results as $result) {
                    $allResults->push($result->toSearchResult());
                }
            } catch (\Exception $e) {
                Log::error("Search error for {$model}", [
                    'error' => $e->getMessage(),
                ]);
            }
        }
        
        return $allResults;
    }

    /**
     * Paginate results collection.
     */
    protected function paginateResults(Collection $results, int $perPage, int $page): array
    {
        return $results->forPage($page, $perPage)->values()->toArray();
    }

    /**
     * Get model type name from class.
     */
    protected function getModelType(string $model): string
    {
        return strtolower(str_replace('_', ' ', Str::snake(class_basename($model))));
    }

    /**
     * Extract suggestion text from model.
     */
    protected function getSuggestionText($model): string
    {
        return match(true) {
            isset($model->title) => $model->title,
            isset($model->name) => $model->name,
            isset($model->question) => $model->question,
            default => '',
        };
    }
}
