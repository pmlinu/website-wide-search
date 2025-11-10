<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Faq extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'question',
        'answer',
    ];

    /**
     * Get the indexable data array for the model.
     */
    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'question' => $this->question,
            'answer' => $this->answer,
        ];
    }

    /**
     * Get the search result representation.
     */
    public function toSearchResult(): array
    {
        return [
            'type' => 'faq',
            'id' => $this->id,
            'title' => $this->question,
            'snippet' => $this->getSnippet(),
            'link' => route('faqs.show', $this->id),
        ];
    }

    /**
     * Get a snippet of the content.
     */
    private function getSnippet(int $length = 150): string
    {
        return strlen($this->answer) > $length
            ? substr($this->answer, 0, $length) . '...'
            : $this->answer;
    }
}

