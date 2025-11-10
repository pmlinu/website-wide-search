<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Page extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'title',
        'content',
    ];

    /**
     * Get the indexable data array for the model.
     */
    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
        ];
    }

    /**
     * Get the search result representation.
     */
    public function toSearchResult(): array
    {
        return [
            'type' => 'page',
            'id' => $this->id,
            'title' => $this->title,
            'snippet' => $this->getSnippet(),
            'link' => route('pages.show', $this->id),
        ];
    }

    /**
     * Get a snippet of the content.
     */
    private function getSnippet(int $length = 150): string
    {
        return strlen($this->content) > $length
            ? substr($this->content, 0, $length) . '...'
            : $this->content;
    }
}

