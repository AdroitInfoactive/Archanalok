<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VariantMaster;
use Illuminate\Http\Request;

class VariantMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $variants = VariantMaster::orderBy('position', 'asc')->paginate(20);

        return view('admin.variant.master.index', compact('variants'));
    }

    public function updateOrder(Request $request)
    {
        $order = $request->order;
    
        foreach ($order as $item) {
            $variant = VariantMaster::find($item['id']);
            if ($variant) {
                $variant->position = $item['position']; // Assuming a 'position' column exists in your table
                $variant->save();
            }
        }
    
        return response()->json(['message' => 'Order updated successfully'], 200);
    }
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:variant_masters,name',
        ]);

        $variant = VariantMaster::create([
            'name' => $request->name,
        ]);
    
        // Return the created variant
        return response()->json($variant);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        // Find the existing variant
        $variant = VariantMaster::findOrFail($id);
    
        // Validate the request only for the fields being updated
        $rules = [];
    
        // Check if name is present in the request
        if ($request->has('name')) {
            $rules['name'] = 'required|string|max:255|unique:variant_masters,name,' . $id; // Allow current variant's name
        }
    
        // Check if status is present in the request
        if ($request->has('status')) {
            $rules['status'] = 'required|boolean'; // Validate status
        }
    
        // Perform validation
        $request->validate($rules);
    
        // Update the variant with the request data
        $variant->update([
            'name' => $request->name ?? $variant->name, // Use existing name if not updating
            'status' => $request->status ?? $variant->status // Use existing status if not updating
        ]);
    
        return response()->json($variant);
    }
    
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
      
        try {
            $variant = VariantMaster::findOrFail($id);
            $variant->delete();
            return response(['status' => 'success', 'message' => 'Variant  deleted successfully']);
        } catch (\Exception $e) {
            return response(['status' => 'error', 'message' => 'Something went wrong']);

        }
    }


}
