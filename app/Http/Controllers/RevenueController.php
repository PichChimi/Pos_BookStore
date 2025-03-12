<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Sale;
use Carbon\Carbon;

class RevenueController extends Controller
{
    public function index()
    {
        // Fetch monthly revenue data
       
        // $monthlyRevenue = Sale::selectRaw('SUM(total) as revenue, TO_CHAR(created_at, \'DD\') as month')
        // ->groupByRaw('TO_CHAR(created_at, \'DD\')')
        // ->orderByRaw('TO_CHAR(created_at, \'DD\')')
        // ->get();

        // $monthlyRevenue = Sale::selectRaw('SUM(total) as revenue, TO_CHAR(created_at, \'YYYY-MM-DD\') as day')
        // ->groupByRaw('TO_CHAR(created_at, \'YYYY-MM-DD\')')
        // ->orderByRaw('TO_CHAR(created_at, \'YYYY-MM-DD\')')
        // ->get();

        // // Format data for Chart.js
        // $months = [];
        // $revenues = [];

        // foreach ($monthlyRevenue as $data) {
        //     $months[] = Carbon::create()->month($data->month)->format('M');
        //     $revenues[] = $data->revenue;
        // }

        // return view('reports.revenue', compact('months', 'revenues'));

        // Fetch daily revenue data from Oracle
        // Fetch daily revenue from Oracle
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

    return view('reports.revenue', compact('days', 'revenues'));

    }
}
