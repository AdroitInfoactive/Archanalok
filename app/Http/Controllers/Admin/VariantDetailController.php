<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\VariantDetailDataTable;
use App\Http\Controllers\Controller;
use App\Models\VariantDetail;
use App\Models\VariantMaster;
use Illuminate\Http\Request;

class VariantDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(VariantDetailDataTable $dataTable)
    {
       
        return $dataTable->render('admin.variant.details.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $variantMasters = VariantMaster::orderBy('position', 'asc')->get();

        return view('admin.variant.details.create', compact('variantMasters'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validation and store data
        $request->validate([
            'variant_master_id' => 'required',
            'name' => 'required|string|max:255|unique:variant_details,name',
            'position' => 'required|integer',
            'status' => 'required|boolean',
        ]);
        $variantDetail = new VariantDetail();
        $variantDetail->variant_master_id = $request->variant_master_id;
        $variantDetail->name = $request->name;
        $variantDetail->status = $request->status;
        $variantDetail->position = $request->position;
        $variantDetail->save();
        toastr()->success('Variant Detail Created Successfully');
        return to_route('admin.variant-details.index');
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
        $variantDetail = VariantDetail::findOrFail($id);
        $variantMasters = VariantMaster::all();
        return view('admin.variant.details.edit', compact('variantDetail', 'variantMasters'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // validation and store data
        $request->validate([
            'variant_master_id' => 'required',
            'name' => 'required|string|max:255|unique:variant_details,name,' . $id,
            'position' => 'required|integer',
            'status' => 'required|boolean',
        ]);
        $variantDetail = VariantDetail::findOrFail($id);
        $variantDetail->variant_master_id = $request->variant_master_id;
        $variantDetail->name = $request->name;
        $variantDetail->status = $request->status;
        $variantDetail->position = $request->position;
        $variantDetail->save();
        toastr()->success('Variant Detail Updated Successfully');
        return to_route('admin.variant-details.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $variantDetail = VariantDetail::findOrFail($id);
            $variantDetail->delete();
            return response(['status' => 'success', 'message' => 'Variant Details deleted successfully']);
        } catch (\Exception $e) {
            return response(['status' => 'error', 'message' => 'Something went wrong']);
        }
      
    }
}
