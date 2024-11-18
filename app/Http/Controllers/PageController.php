<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Cart;
use App\Models\Genres;
use App\Models\User;
use App\Models\SaleDetail;

class PageController extends Controller
{
   
    public function index()
    {
        $book = Book::count();
        $user = User::count();
        $saleDetail = SaleDetail::count();
        return view('pages.home',[
            'bookcount' => $book,
            'usercount' => $user,
            'saleDetailCount' => $saleDetail
        ]);
    }

    public function sale()
    {

        $cartItems = Cart::all();
        $subtotal = $cartItems->sum('total');
        $totalItems = $cartItems->sum('quantity');
        $books = Book::all(); // Assuming you want to display books in the view
        $genre = Genres::get();

        return view('pages.sale', [
            'cartItems' => $cartItems,
            'subtotal' => $subtotal,
            'totalItems' => $totalItems,
            'books' => $books,
            'genres' => $genre
        ]);

    }
    
}
