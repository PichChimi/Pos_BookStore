<?php

namespace App\Http\Controllers;

use App\Models\Genres;
use Illuminate\Http\Request;

class GenresController extends Controller
{
    public function index(Request $request){
        $query = Genres::query(); // Use query builder

        if ($request->has('search') && !empty($request->search)) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('name_en', 'LIKE', "%$search%")
                  ->orWhere('name_kh', 'LIKE', "%$search%");
            });
        }
    
        $genress = $query->get(); // Fetch the filtered results
    
        // If it's an AJAX request, return only the genres list
        if ($request->ajax()) {
            return view('partials.genres-list', compact('genress'))->render();
        }
    
        // Return the full page for normal requests
        return view('pages.genres', compact('genress'));
    }

    public function store(Request $request){

        $validatedData = $request->validate([
            'name_en' => 'required|string|max:255',
            'name_kh' => 'required|string|max:255'
        ]);

        // Insert data into the database
        Genres::create([
            'name_en' => $validatedData['name_en'],
            'name_kh' => $validatedData['name_kh'],
           
        ]);
    }

    public function update(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'id' => 'required|integer',
            'name_en' => 'required|string|max:255',
            'name_kh' => 'required|string|max:255'
        ]);

        // Find the record by its ID
        $genres = Genres::find($request->id);

        if (!$genres) {
            return response()->json([
                'message' => 'Record not found!',
            ], 404);
        }

        // Update the record with the new data
        $genres->name_en = $request->name_en;
        $genres->name_kh = $request->name_kh;
        $genres->save();
    }

    public function delete(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
        ]);

        // Find the record by its ID
        $role = Genres::find($request->id);
        $role->delete();

    }

    public function deleteSelected(Request $request)
    {
            $genresIds = $request->input('ids'); // Get the selected role IDs

            if (!empty($genresIds)) {
                Genres::whereIn('id', $genresIds)->delete(); // Delete roles with the selected IDs
                return response()->json(['success' => true]);
            } else {
                return response()->json(['error' => 'No roles selected.'], 400);
            }
     }
}
