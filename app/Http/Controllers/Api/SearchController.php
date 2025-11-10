<?php

namespace App\Http\Controllers\Api;

use App\Contracts\SearchServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\SearchRequest;
use App\Http\Requests\SuggestionRequest;
use Illuminate\Http\JsonResponse;

/**
 * Search Controller following SOLID Principles:
 * - Dependency Inversion: Depends on SearchServiceInterface (abstraction)
 * - Single Responsibility: Only handles HTTP layer, validation in FormRequests
 */
class SearchController extends Controller
{
    public function __construct(
        protected SearchServiceInterface $searchService
    ) {}

    /**
     * Unified search across all content types.
     * 
     * Uses FormRequest for validation (Single Responsibility Principle)
     */
    public function search(SearchRequest $request): JsonResponse
    {
        try {
            $results = $this->searchService->search(
                $request->getQuery(),
                $request->getPerPage(),
                $request->getPage()
            );

            return response()->json([
                'success' => true,
                'data' => $results,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Search failed: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get search suggestions for typeahead.
     * 
     * Uses FormRequest for validation (Single Responsibility Principle)
     */
    public function suggestions(SuggestionRequest $request): JsonResponse
    {
        try {
            $suggestions = $this->searchService->getSuggestions(
                $request->getQuery(),
                $request->getLimit()
            );

            return response()->json([
                'success' => true,
                'data' => $suggestions,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get suggestions: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Rebuild search index (admin only).
     * 
     * No validation needed - simple POST endpoint
     */
    public function rebuildIndex(): JsonResponse
    {
        try {
            $results = $this->searchService->rebuildIndex();

            return response()->json([
                'success' => true,
                'message' => 'Search index rebuilt successfully',
                'data' => $results,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to rebuild index: ' . $e->getMessage(),
            ], 500);
        }
    }
}

