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
        // $stocks = Stock::with('supplier')->get();
        $book = Book::get();
        $supplier = Supplier::get();
        return view('pages.stock',[
            'stocks' => $stock,
            'books' => $book,
            'suppliers' => $supplier
        ]);
    }

    public function store(Request $request)
{
    $request->validate([
        'book_id' => 'required|exists:books,id|integer', // Ensure book_id exists in books table
        'quantity' => 'required|integer|min:1', // Must be a positive integer
        'purchase_price' => 'nullable|numeric|min:0', // Optional for adding more quantity
        'selling_price' => 'nullable|numeric|min:0', // Optional for adding more quantity
        'supplier_id' => 'nullable|exists:suppliers,id|integer', // Optional for adding more quantity
    ]);

    // Check if stock already exists for the selected book
    $stock = Stock::where('book_id', $request->book_id)->first();

    if ($stock) {
        // Add more quantity to the existing stock
        $stock->quantity += $request->quantity;

        // Optionally update purchase_price, selling_price, and supplier_id if provided
        if ($request->has('purchase_price')) {
            $stock->purchase_price = $request->purchase_price;
        }
        if ($request->has('selling_price')) {
            $stock->selling_price = $request->selling_price;
        }
        if ($request->has('supplier_id')) {
            $stock->supplier_id = $request->supplier_id;
        }

        $stock->save();

        return response()->json([
            'message' => 'Quantity added successfully to existing stock!',
        ]);
    } else {
        // Create a new stock entry if it doesn't exist
        Stock::create([
            'book_id' => $request->book_id,
            'quantity' => $request->quantity,
            'purchase_price' => $request->purchase_price,
            'selling_price' => $request->selling_price,
            'supplier_id' => $request->supplier_id,
        ]);

        return response()->json([
            'message' => 'New stock created successfully!',
        ]);
    }
}

    // public function store(Request $request){

    //     $validatedData = $request->validate([
    //         'book_id' => 'required|exists:books,id|integer', // Ensure book_id exists in books table
    //         'quantity' => 'required|integer|min:1', // Must be a positive integer
    //         'purchase_price' => 'required|numeric|min:0', // Numeric and must be non-negative
    //         'selling_price' => 'required|numeric|min:0', // Numeric and must be non-negative
    //         'supplier_id' => 'required|exists:suppliers,id|integer', 
    //     ]);

    //     // Insert data into the database
    //     Stock::create([
    //         'book_id' => $validatedData['book_id'],
    //         'quantity' => $validatedData['quantity'],
    //         'purchase_price' => $validatedData['purchase_price'],
    //         'selling_price' => $validatedData['selling_price'],
    //         'supplier_id' => $validatedData['supplier_id']
    //     ]);
    // }

    // public function update(Request $request)
    // {
       
    //     // Find the record by its ID
    //     $stock = Stock::find($request->id);

    //     if (!$stock) {
    //         return response()->json([
    //             'message' => 'Record not found!',
    //         ], 404);
    //     }

    //     // Update the record with the new data
    //     $stock->book_id = $request->book_id;
    //     $stock->quantity = $request->quantity;
    //     $stock->purchase_price = $request->purchase_price;
    //     $stock->selling_price = $request->selling_price;
    //     $stock->supplier_id = $request->supplier_id;
    //     $stock->save();
    // }
    public function update(Request $request)
    {
        // Validate the incoming data
        $validatedData = $request->validate([
            'id' => 'required|exists:stocks,id',
            'book_id' => 'required|integer',
            'quantity' => 'required|integer|min:0',
            'purchase_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'supplier_id' => 'required|integer|exists:suppliers,id',
        ]);
    
        // Find the record by its ID
        $stock = Stock::find($validatedData['id']);
    
        if (!$stock) {
            return response()->json([
                'message' => 'Record not found!',
            ], 404);
        }
    
        // Update the record with the new data
        $stock->book_id = $validatedData['book_id'];
        $stock->quantity = $validatedData['quantity'];
        $stock->purchase_price = $validatedData['purchase_price'];
        $stock->selling_price = $validatedData['selling_price'];
        $stock->supplier_id = $validatedData['supplier_id'];
        $stock->save();
    
        // Return a success response
        return response()->json([
            'message' => 'Stock updated successfully!',
        ], 200);
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

     public function getDetails(Request $request)
{
    $stock = Stock::where('book_id', $request->book_id)->first();

    if ($stock) {
        return response()->json([
            'stock' => $stock,
        ]);
    }

    return response()->json([
        'message' => 'No stock found for this book.',
    ]);
}

// public function addQuantity(Request $request)
// {
//     $request->validate([
//         'book_id' => 'required|exists:books,id',
//         'quantity' => 'required|integer|min:1',
//     ]);

//     $stock = Stock::where('book_id', $request->book_id)->first();

//     if ($stock) {
//         $stock->quantity += $request->quantity;
//         $stock->save();

//         return response()->json([
//             'message' => 'Quantity added successfully!',
//         ]);
//     }

//     return response()->json([
//         'message' => 'Stock not found for the selected book.',
//     ], 404);
// }
    
}
