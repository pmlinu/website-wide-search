<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SearchLogRequest;
use App\Models\SearchLog;
use Illuminate\Http\JsonResponse;

/**
 * Search Log Controller following Single Responsibility Principle
 * Validation handled by FormRequests
 */
class SearchLogController extends Controller
{
    /**
     * Get top search terms.
     * 
     * Uses FormRequest for validation (Single Responsibility Principle)
     */
    public function topSearches(SearchLogRequest $request): JsonResponse
    {
        try {
            $topSearches = SearchLog::topSearches($request->getLimit(10));

            return response()->json([
                'success' => true,
                'data' => $topSearches,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get top searches: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get recent search queries.
     * 
     * Uses FormRequest for validation (Single Responsibility Principle)
     */
    public function recentSearches(SearchLogRequest $request): JsonResponse
    {
        try {
            $recentSearches = SearchLog::recentSearches($request->getLimit(20));

            return response()->json([
                'success' => true,
                'data' => $recentSearches,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get recent searches: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get search statistics.
     */
    public function statistics(): JsonResponse
    {
        try {
            $stats = [
                'total_searches' => SearchLog::count(),
                'unique_queries' => SearchLog::distinct('query')->count(),
                'searches_today' => SearchLog::whereDate('created_at', today())->count(),
                'searches_this_week' => SearchLog::whereBetween('created_at', [
                    now()->startOfWeek(),
                    now()->endOfWeek()
                ])->count(),
                'top_searches' => SearchLog::topSearches(5),
            ];

            return response()->json([
                'success' => true,
                'data' => $stats,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get statistics: ' . $e->getMessage(),
            ], 500);
        }
    }
}

