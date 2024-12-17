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


class DashboardController extends Controller
{
    function index() : View {
        $footerInfo = FooterInfo::first();
        $mainCategory = MainCategory::where('status', 1) ->orderBy('position', 'asc')  ->get();
        $wishlist = Wishlist::where('user_id', auth()->user()->id)->latest()->get();
        // $orders = Order::where('user_id', auth()->user()->id)->get();
        // $totalOrders = Order::where('user_id', auth()->user()->id)->count();
        // $totalCompleteOrders = Order::where('user_id', auth()->user()->id)->where('order_status', 'delivered')->count();
        // $totalCancelOrders = Order::where('user_id', auth()->user()->id)->where('order_status', 'declined')->count();

        return view('frontend.dashboard.index', compact('wishlist', 'mainCategory', 'footerInfo'));
    }
    function address() : View {
        $footerInfo = FooterInfo::first();
        $mainCategory = MainCategory::where('status', 1) ->orderBy('position', 'asc')  ->get();
        $userAddresses = Address::where('user_id', auth()->user()->id)->get();

        return view('frontend.dashboard.sections.address', compact('userAddresses', 'mainCategory', 'footerInfo'));
    }
/* 
    public function createAddress(AddressCreateRequest $request)
    {
        $address = new Address();
        $address->user_id = auth()->user()->id;
        $address->first_name = $request->first_name;
        $address->last_name = $request->last_name ?? null; // Optional
        $address->phone = $request->phone;
        $address->email = $request->email;
        $address->address = $request->address;
        $address->city = $request->city;
        $address->state = $request->state;
        $address->country = $request->country;
        $address->zip = $request->zip;
        $address->is_default = $request->is_default ?? 0;
    
        $address->save();
    
        return response()->json(['success' => true, 'message' => 'Address added successfully!']);
    }
    

    function updateAddress(string $id, AddressCreateRequest $request) {
        // Fetch the address ensuring it belongs to the authenticated user
        $address = Address::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();
    
        // Update address fields
        $address->update([
            'first_name'   => $request->first_name,
            'last_name'    => $request->last_name,
            'email'        => $request->email,
            'phone'        => $request->phone,
            'address'      => $request->address,
            'city'         => $request->city,
            'state'        => $request->state,
            'country'      => $request->country,
            'zip'          => $request->zip,
            'is_default'   => $request->is_default ?? 0, // Default to 0 if null
        ]);
    
        toastr()->success('Address updated successfully.');
    
        return response()->json([
            'status'  => 'success',
            'message' => 'Address updated successfully.',
            'data'    => $address,
        ]);
    }
    
    function destroyAddress(string $id) {
        // Fetch the address ensuring it belongs to the authenticated user
        $address = Address::where('id', $id)
            ->where('user_id', auth()->id())
            ->first();
    
        if (!$address) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Address not found or access denied.',
            ], 404);
        }
    
        $address->delete();
    
        return response()->json([
            'status'  => 'success',
            'message' => 'Address deleted successfully.',
        ]);
    } */
    public function createAddress(Request $request) {
        $validatedData = $request->except('_token'); // Exclude _token field
    
        Address::create($validatedData + ['user_id' => auth()->id()]);
    
        return response()->json(['success' => true, 'message' => 'Address added successfully!']);
    }
    
    
    public function updateAddress($id, Request $request) {
        $validatedData = $request->except(['_token', '_method']); // Exclude _token and _method fields
    
        $address = Address::findOrFail($id);
        $address->update($validatedData);
    
        return response()->json(['success' => true, 'message' => 'Address updated successfully!']);
    }
    
    
    public function destroyAddress($id) {
        Address::findOrFail($id)->delete();
        return response()->json(['success' => true, 'message' => 'Address deleted successfully!']);
    }
    
    
}
