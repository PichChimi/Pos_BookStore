<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Cart;

class PageController extends Controller
{
   
    public function index()
    {
        return view('pages.home');
    }

    public function sale()
    {

        $cartItems = Cart::all();
        $subtotal = $cartItems->sum('total');
        $totalItems = $cartItems->sum('quantity');
        $books = Book::all(); // Assuming you want to display books in the view

        return view('pages.sale', [
            'cartItems' => $cartItems,
            'subtotal' => $subtotal,
            'totalItems' => $totalItems,
            'books' => $books,
        ]);

    }
    
}
