<?php

use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\Api\SearchLogController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Public search endpoints
Route::get('/search', [SearchController::class, 'search']);
Route::get('/search/suggestions', [SearchController::class, 'suggestions']);

// Admin-only endpoints (requires authentication and admin role)
Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::post('/search/rebuild-index', [SearchController::class, 'rebuildIndex']);
    Route::get('/search/logs/top', [SearchLogController::class, 'topSearches']);
    Route::get('/search/logs/recent', [SearchLogController::class, 'recentSearches']);
    Route::get('/search/logs/statistics', [SearchLogController::class, 'statistics']);
});

// Authenticated user endpoint
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Health check
Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now()->toIso8601String(),
    ]);
});

