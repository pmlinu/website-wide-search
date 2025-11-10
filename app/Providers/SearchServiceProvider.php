<?php

namespace App\Providers;

use App\Contracts\SearchLoggerInterface;
use App\Contracts\SearchRankerInterface;
use App\Contracts\SearchServiceInterface;
use App\Models\BlogPost;
use App\Models\Faq;
use App\Models\Page;
use App\Models\Product;
use App\Services\Search\IndexManager;
use App\Services\Search\SearchLogger;
use App\Services\Search\SearchRanker;
use App\Services\SearchService;
use Illuminate\Support\ServiceProvider;

/**
 * Service Provider for dependency injection bindings
 * Follows Dependency Inversion Principle
 */
class SearchServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Bind interfaces to implementations (DIP)
        $this->app->bind(SearchRankerInterface::class, SearchRanker::class);
        $this->app->bind(SearchLoggerInterface::class, SearchLogger::class);
        $this->app->bind(SearchServiceInterface::class, SearchService::class);
        
        // Bind IndexManager with dependencies
        $this->app->singleton(IndexManager::class, function ($app) {
            return new IndexManager([
                BlogPost::class,
                Product::class,
                Page::class,
                Faq::class,
            ]);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}

