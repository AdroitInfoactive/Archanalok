<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\AddressCreateRequest;
use App\Models\Address;
use App\Models\FooterInfo;
use App\Models\MainCategory;
use App\Models\Order;
use App\Models\State;
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
        $userAddresses = Address::with('stateName')->where('user_id', auth()->user()->id)->get();
        $states = State::all();

        return view('frontend.dashboard.sections.address', compact('userAddresses', 'states'));
    }

    public function createAddress(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zip' => 'required|string|max:10',
            'company' => 'nullable|string|max:255',
            'gst' => 'nullable|string|max:255',
        ]);
    
        $addressData = [
            'user_id' => auth()->user()->id,
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'address' => $validated['address'],
            'city' => $validated['city'],
            'state' => $validated['state'],
            'zip' => $validated['zip'],
            'company' => $validated['company'],
            'gst' => $validated['gst'],
            'is_default_billing' => isset($request['is_default_billing']) ? $request['is_default_billing'] : 0,
            'is_default_shipping' => isset($request['is_default_shipping']) ? $request['is_default_shipping'] : 0,
        ];

        // Handle default billing logic
        if (isset($request['is_default_billing']) && $request['is_default_billing']) {
            // Reset default billing for all other addresses
            Address::where('user_id', auth()->user()->id)
                ->update(['is_default_billing' => false]);

            // Set the new address as default billing
            $addressData['is_default_billing'] = true;
        }

        // Handle default shipping logic
        if (isset($request['is_default_shipping']) && $request['is_default_shipping']) {
            // Reset default shipping for all other addresses
            Address::where('user_id', auth()->user()->id)
                ->update(['is_default_shipping' => false]);

            // Set the new address as default shipping
            $addressData['is_default_shipping'] = true;
        }

        // Create the new address
        Address::create($addressData);

        return response()->json(['message' => 'Address added successfully!']);
    }
    
    public function updateAddress(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zip' => 'required|string|max:10',
            'company' => 'nullable|string|max:255',
            'gst' => 'nullable|string|max:255',
        ]);

        $address = Address::findOrFail($id);

        // Update the address details
        $address->update([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'address' => $validated['address'],
            'city' => $validated['city'],
            'state' => $validated['state'],
            'zip' => $validated['zip'],
            'company' => $validated['company'],
            'gst' => $validated['gst'],
        ]);

        // Handle default billing and shipping address logic
        if (isset($request['is_default_billing']) && $request['is_default_billing']) {
            // Reset default billing for all other addresses
            Address::where('user_id', $address->user_id)
                ->where('id', '!=', $address->id)
                ->update(['is_default_billing' => false]);

            // Set this address as the default billing
            $address->is_default_billing = true;
        }

        if (isset($request['is_default_shipping']) && $request['is_default_shipping']) {
            // Reset default shipping for all other addresses
            Address::where('user_id', $address->user_id)
                ->where('id', '!=', $address->id)
                ->update(['is_default_shipping' => false]);

            // Set this address as the default shipping
            $address->is_default_shipping = true;
        }

        // Save the changes to the current address
        $address->save();

        return response()->json(['message' => 'Address updated successfully!']);
    }

    public function setDefaultAddress(Request $request)
    {
        $request->validate([
            'address_id' => 'required|exists:addresses,id',
            'type' => 'required|in:billing,shipping',
        ]);

        $userId = auth()->id();
        $addressId = $request->address_id;
        $type = $request->type;

        // Update the default address
        if ($type === 'billing') {
            Address::where('user_id', $userId)->update(['is_default_billing' => false]);
            Address::where('id', $addressId)->update(['is_default_billing' => true]);
        } elseif ($type === 'shipping') {
            Address::where('user_id', $userId)->update(['is_default_shipping' => false]);
            Address::where('id', $addressId)->update(['is_default_shipping' => true]);
        }
        return response()->json(['success' => true, 'message' => 'Default address updated successfully.']);
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
