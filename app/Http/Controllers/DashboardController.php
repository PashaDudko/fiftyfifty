<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke()
    {
        return view('dashboard')->with('orders',
            Order::where('status', 'active')
                ->withCount('subscribers')
                ->get()
        );
    }
}
