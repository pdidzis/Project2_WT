<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\JsonResponse;

class DataController extends Controller
{
    /**
     * Return 3 published books in random order.
     */
    public function getTopBooks(): JsonResponse
    {
        $books = Book::where('display', true)
            ->inRandomOrder()
            ->take(3)
            ->get();

        return response()->json($books);
    }

    /**
     * Return the selected book if it's published.
     */
    public function getBook(Book $book): JsonResponse
    {
        $selectedBook = Book::where([
            'id' => $book->id,
            'display' => true,
        ])->firstOrFail();

        return response()->json($selectedBook);
    }

    /**
     * Return 3 published books in random order, except the selected book.
     */
    public function getRelatedBooks(Book $book): JsonResponse
    {
        $books = Book::where('display', true)
            ->where('id', '<>', $book->id)
            ->inRandomOrder()
            ->take(3)
            ->get();

        return response()->json($books);
    }
}
