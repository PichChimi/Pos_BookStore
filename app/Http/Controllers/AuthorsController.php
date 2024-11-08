<?php

namespace App\Http\Controllers;

use App\Models\Authors;
use Illuminate\Http\Request;

class AuthorsController extends Controller
{
    public function index(){
        $author = Authors::get();
        return view('pages.authors',[
            'authors' => $author
        ]);
    }

    public function store(Request $request){

        $validatedData = $request->validate([
            'name_en' => 'required|string|max:255',
            'name_kh' => 'required|string|max:255',
            'nationality_en' => 'required|string|max:255',
            'nationality_kh' => 'required|string|max:255',
        ]);

        // Insert data into the database
        Authors::create([
            'name_en' => $validatedData['name_en'],
            'name_kh' => $validatedData['name_kh'],
            'nationality_en' => $validatedData['nationality_en'],
            'nationality_kh' => $validatedData['nationality_kh']
           
        ]);
    }

    public function update(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'id' => 'required|integer',
            'name_en' => 'required|string|max:255',
            'name_kh' => 'required|string|max:255',
            'nationality_en' => 'required|string|max:255',
            'nationality_kh' => 'required|string|max:255'
        ]);

        // Find the record by its ID
        $author = Authors::find($request->id);

        if (!$author) {
            return response()->json([
                'message' => 'Record not found!',
            ], 404);
        }

        // Update the record with the new data
        $author->name_en = $request->name_en;
        $author->name_kh = $request->name_kh;
        $author->nationality_en = $request->nationality_en;
        $author->nationality_kh = $request->nationality_kh;
        $author->save();
    }

    public function delete(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
        ]);

        // Find the record by its ID
        $role = Authors::find($request->id);
        $role->delete();

    }

    public function deleteSelected(Request $request)
    {
            $authorIds = $request->input('ids'); // Get the selected role IDs

            if (!empty($authorIds)) {
                Authors::whereIn('id', $authorIds)->delete(); // Delete roles with the selected IDs
                return response()->json(['success' => true]);
            } else {
                return response()->json(['error' => 'No roles selected.'], 400);
            }
     }
}
