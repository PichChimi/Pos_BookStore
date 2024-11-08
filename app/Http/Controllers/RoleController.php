<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $role = Role::get();
        return view('pages.role',[
            'roles' => $role
        ]);
    }

    public function store(Request $request){

        $validatedData = $request->validate([
            'name_en' => 'required|string|max:255',
            'name_kh' => 'required|string|max:255'
        ]);

        // Insert data into the database
          Role::create([
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
        $role = Role::find($request->id);

        if (!$role) {
            return response()->json([
                'message' => 'Record not found!',
            ], 404);
        }

        // Update the record with the new data
        $role->name_en = $request->name_en;
        $role->name_kh = $request->name_kh;
        $role->save();
    }

    public function delete(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
        ]);

        // Find the record by its ID
        $role = Role::find($request->id);
        $role->delete();

    }

    public function deleteSelected(Request $request)
    {
            $roleIds = $request->input('ids'); // Get the selected role IDs

            if (!empty($roleIds)) {
                Role::whereIn('id', $roleIds)->delete(); // Delete roles with the selected IDs
                return response()->json(['success' => true]);
            } else {
                return response()->json(['error' => 'No roles selected.'], 400);
            }
     }
}
