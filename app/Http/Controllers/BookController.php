<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Models\Authors;
use App\Models\Genres;

class BookController extends Controller
{
    public function index(Request $request){

        // -------- Not Reload Page --------
        $query = Book::with(['genres']);

        if ($request->has('search') && !empty($request->search)) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('title_en', 'LIKE', "%$search%")
                ->orWhere('title_kh', 'LIKE', "%$search%");
            });
        }

        $books = $query->get();
        $authorses = Authors::all();
        $genreses = Genres::all();

        // If it's an AJAX request, return only the book list
        if ($request->ajax()) {
            return view('partials.book-list', compact('books'))->render();
        }

        // Return the full page for normal requests
        return view('pages.book', compact('authorses', 'genreses', 'books'));
        
        // -------- End Not Reload Page --------

        // -------- Static --------
        // $query = Book::query();
        // if ($request->has('search')) {
        //     $search = trim($request->input('search'));
        //     $query->where(function ($q) use ($search) {
        //         $q->where('title_en', 'LIKE', "%$search%")
        //         ->orWhere('title_kh', 'LIKE', "%$search%");
        //     });
        // }
        // $books = $query->get();
        // $authors = Authors::all();
        // $genres = Genres::all();

        // return view('pages.book', [
        //     'authorses' => $authors,
        //     'genreses' => $genres,
        //     'books' => $books
        // ]);
         // -------- end Static --------
       
    }

    
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'title_en' => 'required|string|max:255',
            'title_kh' => 'required|string|max:255',
            'des' => 'nullable|string',
            'cover_book' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
            'authors_id' => 'required|integer|exists:authors,id',
            'genres_id' => 'required|integer|exists:genres,id',
        ]);
    
        // Cambodian prefix for EAN-13 barcodes
        $prefix = '885';
    
        do {
            $randomNumber = str_pad(mt_rand(1, 9999999), 7, '0', STR_PAD_LEFT); 
            $barcode = $prefix . $randomNumber; 
        } while ($this->bookCodeExists($barcode)); // Check for unique barcode
    
        // Handle file upload if a cover image is uploaded
        $profilePath = null;
        if ($request->hasFile('cover_book')) {
            $profilePath = $request->file('cover_book')->store('book', 'public');
        }
    
        // Create the new book record
        Book::create([
            'title_en' => $request->title_en,
            'title_kh' => $request->title_kh,
            'barcode' => $barcode,
            'des' => $request->des,
            'cover_book' => $profilePath,
            'authors_id' => $request->authors_id,
            'genres_id' => $request->genres_id,
        ]);
    
        return response()->json(['success' => 'Book created successfully!']);
    }
    
    // Check if the barcode already exists
    public function bookCodeExists($barcode)
    {
        return Book::where('barcode', $barcode)->exists();
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
        // $book->barcode = $request->barcode;
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
        // 'barcode' => $book->barcode,
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

        public function getBooksByGenre(Request $request)
        {
            $genreId = $request->input('genre_id');

            // Fetch books based on genre or fetch all
            if ($genreId === 'all') {
                $books = Book::with('stocks')->get();
            } else {
                $books = Book::where('genres_id', $genreId)->with('stocks')->get();
            }

            // Return a partial view to update the frontend
            return response()->json([
                'html' => view('partials.books', compact('books'))->render(),
    ]);
        }

        

}
