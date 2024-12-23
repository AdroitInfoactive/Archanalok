<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\AddressCreateRequest;
use App\Models\Address;
use App\Models\FooterInfo;
use App\Models\MainCategory;
use App\Models\Order;
use App\Models\Wishlist;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;


class DashboardController extends BaseController
{
    function index() : View {
        $wishlist = Wishlist::where('user_id', auth()->user()->id)->latest()->get();
        // $orders = Order::where('user_id', auth()->user()->id)->get();
        // $totalOrders = Order::where('user_id', auth()->user()->id)->count();
        // $totalCompleteOrders = Order::where('user_id', auth()->user()->id)->where('order_status', 'delivered')->count();
        // $totalCancelOrders = Order::where('user_id', auth()->user()->id)->where('order_status', 'declined')->count();

        return view('frontend.dashboard.index', compact('wishlist'));
    }
    function address() : View {
        $userAddresses = Address::where('user_id', auth()->user()->id)->get();

        return view('frontend.dashboard.sections.address', compact('userAddresses'));
    }

    public function createAddress(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'phone' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zip' => 'required|string|max:10',
            'country' => 'required|string|max:255',
            'is_default' => 'nullable|boolean',
        ]);
    
        Address::create($validated + ['user_id' => auth()->id()]);
        return response()->json(['message' => 'Address added successfully!']);
    }
    
    
    public function updateAddress(Request $request, $id)
{
    $validated = $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'nullable|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'required|string|max:15',
        'address' => 'required|string|max:255',
        'city' => 'required|string|max:255',
        'state' => 'required|string|max:255',
        'zip' => 'required|string|max:10',
        'country' => 'required|string|max:255',
        'is_default' => 'nullable|boolean',
    ]);

    $address = Address::findOrFail($id);
    $address->update($validated);
    return response()->json(['message' => 'Address updated successfully!']);
}

    
function destroyAddress(string $id) {
    $address = Address::findOrFail($id);
    if($address && $address->user_id === auth()->user()->id){
        $address->delete();
        return response(['status' => 'success', 'message' => 'Deleted Successfully']);

    }
    return response(['status' => 'error', 'message' => 'something went wrong!']);
}

    
    
}
