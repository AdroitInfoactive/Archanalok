<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class OrderController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Auth::check()) {
            throw ValidationException::withMessages(['Please login for Checking the orders']);
        }
        $userId = Auth::user()->id;

        // Get the orders for the user in descending order
        $orders = Order::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();
            // ->paginate(10);

        // Get the count of orders
        $orderCount = $orders->count();

        // Get the last ordered date (if orders exist)
        $lastOrderedDate = $orders->first()?->created_at ? $orders->first()->created_at->format('d-m-Y H:i:s') : null;

        // Pass the data to the view
        return view('frontend.orders.index', compact('orders', 'orderCount', 'lastOrderedDate'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order = Order::findOrFail($id);
        return view('frontend.orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
