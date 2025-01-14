<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Book extends Model
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
        'display', // Include 'display' if you plan to update this field via mass assignment
    ];

    /**
     * Define the relationship between a Book and an Author.
     * A Book belongs to an Author.
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }
}
