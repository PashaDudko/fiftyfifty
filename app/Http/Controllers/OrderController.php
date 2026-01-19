<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = auth()->user()->orders;

        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $shops = Shop::all();

        return view('orders.create', compact('shops'));
    }

    public function store(Request $request) // Add OrderStoreRequest
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'current_amount' => 'required|numeric|min:0',
            'free_shipping_threshold' => 'required|numeric|min:0',
            'join_deadline_at' => 'nullable|date|after:now',
            'shop_id' => 'required|exists:shops,id',
        ]);

        $validated['user_id'] = Auth::id();

        Order::create($validated);

        return redirect()->route('orders.index')->with('success', 'Order created successfully!');
    }

    public function show(Order $order)
    {
        //
    }

    public function edit(Order $order)
    {
        //
    }

    public function update(Request $request, Order $order)
    {
        //
    }

    public function destroy(Order $order)
    {
        //
    }
}
