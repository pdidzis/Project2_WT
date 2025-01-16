<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use JsonSerializable;

class Book extends Model implements JsonSerializable
{
    use HasFactory;

    /**
     * Define fillable attributes for mass assignment.
     */
    protected $fillable = [
        'name',
        'author_id',
        'description',
        'price',
        'year',
        'genre', // Included 'genre'
        'display',
    ];

    /**
     * Define the relationship between a Book and an Author.
     * A Book belongs to an Author.
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }

    /**
     * Serialize the JSON data for the main data object.
     */
    public function jsonSerialize(): mixed
    {
        return [
            'id' => intval($this->id),
            'name' => $this->name,
            'description' => $this->description,
            'author' => $this->author->name,
            'genre' => $this->genre, // Added 'genre' field
            'price' => number_format($this->price, 2),
            'year' => intval($this->year),
            'image' => $this->image ? asset('images/' . $this->image) : null,
            'display' => (bool) $this->display,
        ];
    }
}
