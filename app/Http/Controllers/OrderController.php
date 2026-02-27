<?php

namespace App\Http\Controllers;

use App\Actions\AttachUserToOrderAction;
use App\Models\Order;
use App\Enums\Order as OrderEnum;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function __construct(readonly protected AttachUserToOrderAction $attachUserToOrderAction)
    {

    }

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

        $order = Order::create($validated);

        $this->attachUserToOrderAction->attach($order, auth()->id(), $request->current_amount);

        return redirect()->route('orders.index')->with('success', 'Order created successfully!');
    }

    public function show(Order $order)
    {
        return view('orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        $shops = Shop::all();

        return view('orders.edit', compact('order', 'shops'));
    }

    public function update(Request $request, Order $order)
    {
        $order->update($request->all());

        return redirect()->route('orders.index')
            ->with('success', 'Order is updated successfully!');
    }

    public function destroy(Order $order)
    {
        //
    }

    public function join(Request $request, Order $order)
    {
        $request->validate(['amount' => 'required|numeric|min:0.01']);

        $this->attachUserToOrderAction->attach($order, auth()->id(), $request->amount);

        return back()->with('success', 'You have been joined to this order!');
    }

    public function leave(Order $order)
    {
        $order->subscribers()->detach(auth()->id());

        return back()->with('success', 'You have been left to this order!');
    }

    public function updateAmount(Request $request, Order $order)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01'
        ]);

        $oldAmount = $order->subscribers()->where('user_id', auth()->id())->first()->pivot->amount;

        $order->subscribers()->updateExistingPivot(auth()->id(), [
            'amount' => $request->amount
        ]);

        $difference = $request->amount - $oldAmount;
        $order->increment('current_amount', $difference);

        return back()->with('success', 'Amount updated!');
    }
}

