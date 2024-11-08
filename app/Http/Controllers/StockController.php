<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\Book;
use App\Models\Supplier;
use Illuminate\Http\Request;

class StockController extends Controller
{

    public function index(){
        $stock = Stock::get();
        $book = Book::get();
        $supplier = Supplier::get();
        return view('pages.stock',[
            'stocks' => $stock,
            'books' => $book,
            'suppliers' => $supplier
        ]);
    }

    public function store(Request $request){

        $validatedData = $request->validate([
            'book_id' => 'required|exists:books,id|integer', // Ensure book_id exists in books table
            'quantity' => 'required|integer|min:1', // Must be a positive integer
            'purchase_price' => 'required|numeric|min:0', // Numeric and must be non-negative
            'selling_price' => 'required|numeric|min:0', // Numeric and must be non-negative
            'supplier_id' => 'required|exists:suppliers,id|integer', 
        ]);

        // Insert data into the database
        Stock::create([
            'book_id' => $validatedData['book_id'],
            'quantity' => $validatedData['quantity'],
            'purchase_price' => $validatedData['purchase_price'],
            'selling_price' => $validatedData['selling_price'],
            'supplier_id' => $validatedData['supplier_id']
        ]);
    }

    public function update(Request $request)
    {
       
        // Find the record by its ID
        $stock = Stock::find($request->id);

        if (!$stock) {
            return response()->json([
                'message' => 'Record not found!',
            ], 404);
        }

        // Update the record with the new data
        $stock->book_id = $request->book_id;
        $stock->quantity = $request->quantity;
        $stock->purchase_price = $request->purchase_price;
        $stock->selling_price = $request->selling_price;
        $stock->supplier_id = $request->supplier_id;
        $stock->save();
    }

    public function delete(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
        ]);

        // Find the record by its ID
        $stock = Stock::find($request->id);
        $stock->delete();

    }

    public function deleteSelected(Request $request)
    {
            $stockIds = $request->input('ids'); // Get the selected role IDs

            if (!empty($stockIds)) {
                Stock::whereIn('id', $stockIds)->delete(); // Delete roles with the selected IDs
                return response()->json(['success' => true]);
            } else {
                return response()->json(['error' => 'No roles selected.'], 400);
            }
     }
    
}
