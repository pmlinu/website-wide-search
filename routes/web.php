<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Named routes for search result links
Route::name('blog.show')->get('/blog/{id}', function ($id) {
    return response()->json(['type' => 'blog_post', 'id' => $id]);
});

Route::name('products.show')->get('/products/{id}', function ($id) {
    return response()->json(['type' => 'product', 'id' => $id]);
});

Route::name('pages.show')->get('/pages/{id}', function ($id) {
    return response()->json(['type' => 'page', 'id' => $id]);
});

Route::name('faqs.show')->get('/faqs/{id}', function ($id) {
    return response()->json(['type' => 'faq', 'id' => $id]);
});

Route::get('/', function () {
    return response()->json([
        'message' => 'Laravel Search System API',
        'version' => '1.0.0',
        'endpoints' => [
            'GET /api/search?q={query}' => 'Search across all content',
            'GET /api/search/suggestions?q={query}' => 'Get search suggestions',
            'POST /api/search/rebuild-index' => 'Rebuild search index (admin)',
            'GET /api/search/logs/top' => 'Top search terms (admin)',
            'GET /api/search/logs/recent' => 'Recent searches (admin)',
            'GET /api/search/logs/statistics' => 'Search statistics (admin)',
        ],
    ]);
});

