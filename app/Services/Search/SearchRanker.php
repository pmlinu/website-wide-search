<?php

namespace App\Services\Search;

use App\Contracts\SearchRankerInterface;
use Illuminate\Support\Collection;

/**
 * Single Responsibility: Handle search result ranking
 */
class SearchRanker implements SearchRankerInterface
{
    /**
     * Rank search results by relevance and recency.
     */
    public function rank(Collection $results, string $query): Collection
    {
        return $results->sortByDesc(function ($item) use ($query) {
            return $this->calculateScore($item, $query);
        })->values();
    }

    /**
     * Calculate relevance score for a search result.
     */
    protected function calculateScore(array $item, string $query): float
    {
        $score = 0;
        
        // Title exact match (highest priority)
        if (isset($item['title']) && strcasecmp($item['title'], $query) === 0) {
            $score += 150;
        }
        
        // Title partial match
        if (isset($item['title']) && stripos($item['title'], $query) !== false) {
            $score += 100;
        }
        
        // Content/snippet match
        if (isset($item['snippet']) && stripos($item['snippet'], $query) !== false) {
            $score += 50;
        }
        
        // Recency bonus for blog posts
        if ($item['type'] === 'blog_post' && isset($item['published_at'])) {
            $score += $this->calculateRecencyBonus($item['published_at']);
        }
        
        return $score;
    }

    /**
     * Calculate recency bonus for time-sensitive content.
     */
    protected function calculateRecencyBonus(string $publishedAt): float
    {
        $publishedDate = strtotime($publishedAt);
        $daysSincePublished = (time() - $publishedDate) / (60 * 60 * 24);
        
        // More recent posts get higher scores (up to 30 points)
        return max(0, 30 - ($daysSincePublished / 10));
    }
}

