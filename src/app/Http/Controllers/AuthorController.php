<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\HasMiddleware;

class AuthorController extends Controller implements HasMiddleware
{
    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return [
            'auth', // Apply the 'auth' middleware to restrict access
        ];
    }

    // Display all Authors
    public function list(): View
    {
        $items = Author::orderBy('name', 'asc')->get();

        return view(
            'author.list',
            [
                'title' => 'Authors',
                'items' => $items,
            ]
        );
    }

    // Display new Author form
    public function create(): View
    {
        return view(
            'author.form',
            [
                'title' => 'Add new author',
                'author' => new Author(), // Empty instance for creating
            ]
        );
    }

    // Create new Author
    public function put(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $author = new Author();
        $author->name = $validatedData['name'];
        $author->save();

        return redirect('/authors');
    }

    // Display Author editing form
    public function update(Author $author): View
    {
        return view(
            'author.form',
            [
                'title' => 'Edit author',
                'author' => $author,
            ]
        );
    }

    // Update existing Author data
    public function patch(Author $author, Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $author->name = $validatedData['name'];
        $author->save();

        return redirect('/authors');
    }

    // Delete an Author
    public function delete(Author $author): RedirectResponse
    {
        // Check for related Book items here if needed before deleting
        $author->delete();

        return redirect('/authors');
    }
}
