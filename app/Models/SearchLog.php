<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SearchLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'query',
        'results_count',
        'user_id',
        'ip_address',
    ];

    protected $casts = [
        'results_count' => 'integer',
    ];

    /**
     * Get the user that made the search.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get top search terms.
     */
    public static function topSearches(int $limit = 10): array
    {
        return self::selectRaw('query, COUNT(*) as count')
            ->groupBy('query')
            ->orderByDesc('count')
            ->limit($limit)
            ->get()
            ->toArray();
    }

    /**
     * Get recent searches.
     */
    public static function recentSearches(int $limit = 20): array
    {
        return self::orderByDesc('created_at')
            ->limit($limit)
            ->get()
            ->toArray();
    }
}

