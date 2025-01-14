<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\BookRequest;

class BookController extends Controller
{
    // Call auth middleware
    public static function middleware(): array
    {
        return [
            'auth',
        ];
    }

    // Display all Books
    public function list(): View
    {
        $items = Book::orderBy('name', 'asc')->get();
        return view(
            'book.list',
            [
                'title' => 'Books',
                'items' => $items
            ]
        );
    }

    // Display new Book form
    public function create(): View
    {
        $authors = Author::orderBy('name', 'asc')->get();
        return view(
            'book.form',
            [
                'title' => 'Add new book',
                'book' => new Book(),
                'authors' => $authors,
            ]
        );
    }

    // Create new Book entry
    public function put(BookRequest $request): RedirectResponse
    {
        $book = new Book();
        $this->saveBookData($book, $request);
        return redirect('/books');
    }

    // Display Book edit form
    public function update(Book $book): View
    {
        $authors = Author::orderBy('name', 'asc')->get();
        return view(
            'book.form',
            [
                'title' => 'Edit book',
                'book' => $book,
                'authors' => $authors,
            ]
        );
    }

    // Update Book data
    public function patch(Book $book, BookRequest $request): RedirectResponse
    {
        $this->saveBookData($book, $request);
        return redirect('/books/update/' . $book->id);
    }

    // Delete Book
    public function delete(Book $book): RedirectResponse
    {
        if ($book->image) {
            unlink(getcwd() . '/images/' . $book->image);
        }

        $book->delete();

        return redirect('/books');
    }

    // Private method to validate and save Book data
    private function saveBookData(Book $book, BookRequest $request): void
    {
        $validatedData = $request->validated();
        $book->fill($validatedData);

        // Ensure boolean conversion for 'display' field
        $book->display = (bool) ($validatedData['display'] ?? false);

        // Handle image upload
        if ($request->hasFile('image')) {
            $uploadedFile = $request->file('image');
            $extension = $uploadedFile->clientExtension();
            $name = uniqid();
            $book->image = $uploadedFile->storePubliclyAs(
                '/',
                $name . '.' . $extension,
                'uploads'
            );
        }

        $book->save();
    }
}
