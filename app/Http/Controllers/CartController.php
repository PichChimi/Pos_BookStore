<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Cart;
use App\Models\Stock;
use App\Models\Book;
use App\Models\Sale;
use App\Models\SaleDetail;
use Illuminate\Support\Facades\Auth;


class CartController extends Controller
{

    public function addToCart(Request $request)
    {
      
        $bookId = $request->input('book_id');
        $stockId = $request->input('stock_id');
    
        // Check if stock exists
        $stock = Stock::find($stockId);
        if (!$stock) {
            return response()->json(['error' => 'Stock item not found.'], 404);
        }
    
        // Check if item is already in cart
        $cartItem = Cart::where('stock_id', $stockId)->first();
    
        if ($cartItem) {
            // Increment quantity and update total
            $cartItem->quantity += 1;
            $cartItem->total = $cartItem->quantity * $stock->selling_price;
            $cartItem->save();
        } else {
            // Create new cart item
            Cart::create([
                'book_id' => $bookId,
                'stock_id' => $stockId,
                'quantity' => 1,
                'total' => $stock->selling_price, // Set total for the first quantity
            ]);
        }
    
        $totals = $this->calculateCartTotals();
        $cartHtml = view('pages.cart-summary', $totals)->render();

        return response()->json(['cartHtml' => $cartHtml]);
    }

        private function calculateCartTotals()
        {
            $cartItems = Cart::all();
            $subtotal = $cartItems->sum('total');
            $totalItems = $cartItems->sum('quantity');

            return compact('cartItems', 'subtotal', 'totalItems');
        }


    public function updateCartItem(Request $request, $cartId)
        {
            $cartItem = Cart::findOrFail($cartId);
              // Retrieve selling price from stock
            $sellingPrice = $cartItem->stock->selling_price;
            
            $cartItem->quantity = $request->quantity;
            $cartItem->total = $cartItem->quantity * $sellingPrice;
            $cartItem->save();
         

           // Get updated cart data
            $totals = $this->calculateCartTotals();
            $cartHtml = view('pages.cart-summary', $totals)->render();

            return response()->json([
                'cartHtml' => $cartHtml,
                'subtotal' => $totals['subtotal'],
                'totalItems' => $totals['totalItems']
           ]);
        }

        public function removeFromCart($cartId)
            {
                $cartItem = Cart::findOrFail($cartId);
                $cartItem->delete();

                // Recalculate cart summary
                $cartItems = Cart::all();
                $subtotal = $cartItems->sum('total');
                $totalItems = $cartItems->sum('quantity');

                $cartHtml = view('pages.cart-summary', compact('cartItems', 'subtotal', 'totalItems'))->render();

                return response()->json([
                    'message' => 'Item removed from cart successfully.',
                    'cartHtml' => $cartHtml
                ]);
            }


            public function addToCartByBarcode(Request $request)
                {
                    $barcode = $request->input('barcode');

                    // Find the book by barcode
                    $book = Book::where('barcode', $barcode)->first();

                    if (!$book) {
                        return response()->json(['error' => 'Book not found.'], 404);
                    }

                    // Assuming each book has one associated stock entry
                    $stock = Stock::where('book_id', $book->id)->first();
                    if (!$stock) {
                        return response()->json(['error' => 'Stock item not found.'], 404);
                    }

                    // Check if item is already in the cart
                    $cartItem = Cart::where('stock_id', $stock->id)->first();

                    if ($cartItem) {
                        $cartItem->quantity += 1;
                        $cartItem->total = $cartItem->quantity * $stock->selling_price;
                        $cartItem->save();
                    } else {
                        Cart::create([
                            'book_id' => $book->id,
                            'stock_id' => $stock->id,
                            'quantity' => 1,
                            'total' => $stock->selling_price,
                        ]);
                    }

                    $cartItems = Cart::all();
                    $subtotal = $cartItems->sum('total');
                    $totalItems = $cartItems->sum('quantity');

                    $cartHtml = view('pages.cart-summary', compact('cartItems', 'subtotal', 'totalItems'))->render();

                    return response()->json([
                        'success' => 'Item added to cart successfully.',
                        'cartHtml' => $cartHtml,
                    ]);
                }


                // public function pay(Request $request)
                // {
                //     try {
                //         // Start database transaction
                //         DB::beginTransaction();
                
                //         // Fetch all cart items
                //         $cartItems = Cart::all();
                
                //         if ($cartItems->isEmpty()) {
                //             return response()->json(['error' => 'Cart is empty.'], 400);
                //         }
                
                //         // Calculate totals
                //         $subtotal = $cartItems->sum('total');
                
                //         // Create Sale record
                //         $sale = Sale::create([
                //             'customers_id' => 1, // Replace with actual customer ID
                //             'employee_id' => 1,  // Replace with actual employee ID
                //             'sub_total' => $subtotal,
                //             'total' => $subtotal,
                //         ]);
                
                //         // Create SaleDetail records and adjust stock
                //         foreach ($cartItems as $cartItem) {
                //             $stock = Stock::where('book_id', $cartItem->book_id)->first();
                
                //             if (!$stock || $stock->quantity < $cartItem->quantity) {
                //                 DB::rollBack();
                //                 return response()->json(['error' => 'Insufficient stock for book ID ' . $cartItem->book_id], 400);
                //             }
                
                //             SaleDetail::create([
                //                 'sale_id' => $sale->id,
                //                 'book_id' => $cartItem->book_id,
                //                 'quantity' => $cartItem->quantity,
                //                 'unit_price' => $stock->selling_price,
                //                 'total' => $cartItem->total,
                //             ]);
                
                //             $stock->quantity -= $cartItem->quantity;
                //             $stock->save();
                //         }
                
                //         // Clear the cart
                //         Cart::truncate();
                
                //         // Commit the transaction
                //         DB::commit();
                
                //         return response()->json(['message' => 'Payment successful.']);
                //     } catch (\Exception $e) {
                //         DB::rollBack();
                //         return response()->json(['error' => 'Payment failed: ' . $e->getMessage()], 500);
                //     }
                // }

                public function pay(Request $request)
                {
                    try {
                        DB::beginTransaction();

                        // Fetch cart items
                        $cartItems = Cart::with('book')->get();
                        if ($cartItems->isEmpty()) {
                            return response()->json(['error' => 'Your cart is empty.'], 400);
                        }

                        // Create a sale record
                        $sale = Sale::create([
                            'customers_id' => 1, // Replace with actual customer ID
                            'employee_id' => Auth::user()->id,
                            'sub_total' => $cartItems->sum('total'),
                            'total' => $cartItems->sum('total'),
                        ]);

                        // Add details to SaleDetailTbl and update stock
                        foreach ($cartItems as $cartItem) {
                            $stock = Stock::where('book_id', $cartItem->book_id)->first();
                            if ($stock && $stock->quantity >= $cartItem->quantity) {
                                $stock->decrement('quantity', $cartItem->quantity);

                                SaleDetail::create([
                                    'sale_id' => $sale->id,
                                    'book_id' => $cartItem->book_id,
                                    'quantity' => $cartItem->quantity,
                                    'unit_price' => $stock->selling_price,
                                    'total' => $cartItem->total,
                                ]);
                            } else {
                                return response()->json(['errorstock' => 'Not enough stock for ' . $cartItem->book->title_en], 400);
                            }
                        }

                        // Clear the cart
                        Cart::truncate();

                        DB::commit();

                        // Generate invoice HTML
                        $invoiceHtml = view('partials.invoice', compact('sale', 'cartItems'))->render();

                        return response()->json(['message' => 'Payment successful!', 'invoiceHtml' => $invoiceHtml]);
                    } catch (\Exception $e) {
                        DB::rollBack();
                        return response()->json(['error' => $e->getMessage()], 500);
                    }
                }
                

}
