<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Book extends Model
{
    /**
     * Define the relationship between a Book and an Author.
     * A Book belongs to an Author.
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }
}
