<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class BlogPost extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'title',
        'body',
        'tags',
        'published_at',
    ];

    protected $casts = [
        'tags' => 'array',
        'published_at' => 'datetime',
    ];

    /**
     * Get the indexable data array for the model.
     */
    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'body' => $this->body,
            'tags' => implode(' ', $this->tags ?? []),
            'published_at' => $this->published_at?->timestamp,
        ];
    }

    /**
     * Get the search result representation.
     */
    public function toSearchResult(): array
    {
        return [
            'type' => 'blog_post',
            'id' => $this->id,
            'title' => $this->title,
            'snippet' => $this->getSnippet(),
            'link' => route('blog.show', $this->id),
            'published_at' => $this->published_at?->toIso8601String(),
            'tags' => $this->tags,
        ];
    }

    /**
     * Get a snippet of the content.
     */
    private function getSnippet(int $length = 150): string
    {
        return strlen($this->body) > $length
            ? substr($this->body, 0, $length) . '...'
            : $this->body;
    }

    /**
     * Determine if the model should be searchable.
     */
    public function shouldBeSearchable(): bool
    {
        return !is_null($this->published_at) && $this->published_at->isPast();
    }
}

