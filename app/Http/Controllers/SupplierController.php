<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index(){
        $supplier = Supplier::get();
        return view('pages.supplier',[
            'suppliers' => $supplier
        ]);
    }

    public function store(Request $request){

        $validatedData = $request->validate([
            'name_en' => 'required|string|max:255',
            'name_kh' => 'required|string|max:255',
            'p_number' => 'required|string|max:13', // Adjust max length as necessary
            'company' => 'required|string|max:255',
            'address_en' => 'required|string|max:255',
            'address_kh' => 'required|string|max:255',
        ]);

        // Insert data into the database
        Supplier::create([
            'name_en' => $validatedData['name_en'],
            'name_kh' => $validatedData['name_kh'],
            'p_number' => $validatedData['p_number'],
            'company' => $validatedData['company'],
            'address_en' => $validatedData['address_en'],
            'address_kh' => $validatedData['address_kh']
           
        ]);
    }

    public function update(Request $request)
    {
       
        // Find the record by its ID
        $supplier = Supplier::find($request->id);

        if (!$supplier) {
            return response()->json([
                'message' => 'Record not found!',
            ], 404);
        }

        // Update the record with the new data
        $supplier->name_en = $request->name_en;
        $supplier->name_kh = $request->name_kh;
        $supplier->p_number = $request->p_number;
        $supplier->company = $request->company;
        $supplier->address_en = $request->address_en;
        $supplier->address_kh = $request->address_kh;
        $supplier->save();
    }

    public function delete(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
        ]);

        // Find the record by its ID
        $role = Supplier::find($request->id);
        $role->delete();

    }

    public function deleteSelected(Request $request)
    {
            $supIds = $request->input('ids'); // Get the selected role IDs

            if (!empty($supIds)) {
                Supplier::whereIn('id', $supIds)->delete(); // Delete roles with the selected IDs
                return response()->json(['success' => true]);
            } else {
                return response()->json(['error' => 'No roles selected.'], 400);
            }
     }
}
