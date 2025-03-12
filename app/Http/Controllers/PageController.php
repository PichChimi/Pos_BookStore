<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Sale;
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

        $dailyRevenue = Sale::selectRaw("SUM(total) as revenue, TO_CHAR(created_at, 'YYYY-MM-DD') as day")
        ->groupBy(DB::raw("TO_CHAR(created_at, 'YYYY-MM-DD')")) // Correct grouping
        ->orderBy(DB::raw("TO_CHAR(created_at, 'YYYY-MM-DD')")) // Order correctly
        ->get();

        // Prepare data for Chart.js
        $days = [];
        $revenues = [];

        foreach ($dailyRevenue as $data) {
            $days[] = $data->day; // Store date string
            $revenues[] = $data->revenue; // Store revenue
        }

        return view('pages.home',[
            'bookcount' => $book,
            'usercount' => $user,
            'saleDetailCount' => $saleDetail,
            'days' => $days,
            'revenues' => $revenues
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
