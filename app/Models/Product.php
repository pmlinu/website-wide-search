<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Product extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'name',
        'description',
        'category',
        'price',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    /**
     * Get the indexable data array for the model.
     */
    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'category' => $this->category,
            'price' => (float) $this->price,
        ];
    }

    /**
     * Get the search result representation.
     */
    public function toSearchResult(): array
    {
        return [
            'type' => 'product',
            'id' => $this->id,
            'title' => $this->name,
            'snippet' => $this->getSnippet(),
            'link' => route('products.show', $this->id),
            'category' => $this->category,
            'price' => $this->price,
        ];
    }

    /**
     * Get a snippet of the content.
     */
    private function getSnippet(int $length = 150): string
    {
        return strlen($this->description) > $length
            ? substr($this->description, 0, $length) . '...'
            : $this->description;
    }
}

