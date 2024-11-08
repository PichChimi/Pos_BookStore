<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Models\Authors;
use App\Models\Genres;

class BookController extends Controller
{
    public function index(){
        $author = Authors::get();
        $genres = Genres::get();
        $book = Book::get();
        return view('pages.book',[
            'authorses' => $author,
            'genreses' => $genres,
            'books' => $book
        ]);
    }

    
    public function store(Request $request)
{
    // Validate the request
    $request->validate([
        'title_en' => 'required|string|max:255',
        'title_kh' => 'required|string|max:255',
        'barcode' => 'required|string|unique:books,barcode|max:50',
        'des' => 'nullable|string',
        'cover_book' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
        'authors_id' => 'required|integer|exists:authors,id',
        'genres_id' => 'required|integer|exists:genres,id',
    ]);

    // Handle file upload if profile image is uploaded
    if ($request->hasFile('cover_book')) {
        $profilePath = $request->file('cover_book')->store('book', 'public');
    }

    // Create the new user
    Book::create([
        'title_en' => $request->title_en,
        'title_kh' => $request->title_kh,
        'barcode' => $request->barcode,
        'des' => $request->des,
        'cover_book' => $profilePath,
        'authors_id' => $request->authors_id,
        'genres_id' => $request->genres_id
    ]);

    return response()->json(['success' => 'User created successfully!']);
}

public function update(Request $request, $id)
{
    // Find the user by ID
    $book = Book::findOrFail($id);

    // Handle file upload if profile image is uploaded
    if ($request->hasFile('cover_book')) {
        $profilePath = $request->file('cover_book')->store('book', 'public');
        $book->cover_book = $profilePath; // Update profile path
    }

    // Update the user's information
        $book->title_en = $request->title_en;
        $book->title_kh = $request->title_kh;
        $book->barcode = $request->barcode;
        $book->des = $request->des;
        $book->authors_id = $request->authors_id;
        $book->genres_id = $request->genres_id;

       $book->save(); // Save the updates

    return response()->json(['success' => 'User updated successfully!']);
}

public function edit($id)
{
    // Find the user by ID and return the data
    $book = Book::findOrFail($id);

    return response()->json([
        'id' => $book->id,
        'title_en' => $book->title_en,
        'title_kh' => $book->title_kh,
        'barcode' => $book->barcode,
        'des' => $book->des,
        'cover_book' => $book->cover_book,
        'authors_id' => $book->authors_id,
        'genres_id' => $book->genres_id

    ]);
}

public function delete(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
        ]);

        // Find the record by its ID
        $book = Book::find($request->id);
        $book->delete();

    }

    public function deleteSelected(Request $request)
        {
            $bookIds = $request->input('ids'); // Get the selected role IDs

            if (!empty($bookIds)) {
                Book::whereIn('id', $bookIds)->delete(); // Delete roles with the selected IDs
                return response()->json(['success' => true]);
            } else {
                return response()->json(['error' => 'No roles selected.'], 400);
            }
        }

}
