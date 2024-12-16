<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ProductDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductCreateRequest;
use App\Models\Brand;
use App\Models\MainCategory;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\VariantDetail;
use App\Models\VariantMaster;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ProductController extends Controller
{
    use FileUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(ProductDataTable $dataTable)
    {
        return $dataTable->render('admin.product.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       $mainCategories = MainCategory::where('status', 1)
    ->whereHas('categories', function ($query) {
        $query->where('status', 1);
    })
    ->with(['categories' => function ($query) {
        $query->where('status', 1)
            ->with(['subcategories' => function ($query) {
                $query->where('status', 1);
            }]);
    }])->get();
        $brands = Brand::where('status', 1)->get();
        $variantMasters = VariantMaster::whereNotIn('name', ['Material', 'Units', 'Weight Type'])
            ->with('details')
            ->get();
        $materials = VariantDetail::where('status', 1)
            ->whereHas('variantMaster', function ($query) {
                $query->where('name', 'material');
            })
            ->get();
        $units = VariantDetail::where('status', 1)
            ->whereHas('variantMaster', function ($query) {
                $query->where('name', 'units');
            })
            ->get();
        $weightTypes = VariantDetail::where('status', 1)
            ->whereHas('variantMaster', function ($query) {
                $query->where('name', 'Weight Type');
            })
            ->get();

        return view('admin.product.create', compact('brands', 'mainCategories', 'variantMasters', 'materials', 'units', 'weightTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductCreateRequest $request)
    {
        $filePath = $this->uploadImage($request, 'file', '', '/uploads/products');
        $product = new Product();
        $product->sku = $request->sku;
        $product->name = $request->name;
        $product->slug = $request->slug;
        $catList = explode('-', $request->category);
        $product->mainCategory()->associate($catList[0]);
        $product->category()->associate($catList[1]);
        if (isset($catList[2])) {
            $product->subCategory()->associate($catList[2]);
        }
        $product->description = $request->description;
        $product->specification = $request->specification;
        $product->brand = $request->brand;
        $product->material = $request->material;
        $product->units = $request->units;
        $product->weight_type = $request->weight_type;
        $product->other_code = $request->other_code;
        $product->gst = $request->gst;
        $product->has_variants = $request->has_variants;
        if ($request->has_variants == 0) {
            $product->offer_price = $request->offer_price;
            $product->sale_price = $request->sale_price;
            $product->distributor_price = $request->distributor_price;
            $product->wholesale_price = $request->wholesale_price;
            $product->min_order_qty = $request->min_order_qty;
            $product->weight = $request->weight;
            $product->qty = $request->qty;
        } else {
            $product->variation_ids = $request->variant_master_detail;
        }
        $product->seo_title = $request->seo_title;
        $product->seo_description = $request->seo_description;
        $product->status = $request->status;
        $product->priority = $request->priority;
        $product->file = $filePath;

        $product->save();

        // insert into product variations if has_variants is 1
        if ($request->has_variants == 1) {
            $skus = $request->input('skus', []);
            $variationCodes = $request->input('variation_codes', []);
            $salePrices = $request->input('sale_prices', []);
            $offerPrices = $request->input('offer_prices', []);
            $distributorPrices = $request->input('distributor_prices', []);
            $minOrderQtys = $request->input('min_order_qtys', []);
            $wholesalePrices = $request->input('wholesale_prices', []);
            $weights = $request->input('weights', []);
            $qtys = $request->input('qtys', []);
            $statuses = $request->input('statuses', []);
            $variationImages = $request->file('variation_images', []);

            foreach ($skus as $index => $sku) {
                $variant = new ProductVariant();
                $variant->product_id = $product->id;
                $variant->sku = $sku;
                $variant->variation_code = $variationCodes[$index] ?? null;
                $variant->sale_price = $salePrices[$index] ?? null;
                $variant->offer_price = $offerPrices[$index] ?? null;
                $variant->distributor_price = $distributorPrices[$index] ?? null;
                $variant->min_order_qty = $minOrderQtys[$index] ?? null;
                $variant->wholesale_price = $wholesalePrices[$index] ?? null;
                $variant->weight = $weights[$index] ?? null;
                $variant->qty = $qtys[$index] ?? null;
                $variant->status = $statuses[$index] ?? 1;
                $variant->save();

                // Handle variant image upload
                if (isset($variationImages[$index])) {
                    $variantImageFile = $variationImages[$index];
                    $uploadDir = public_path('uploads/products');

                    // Ensure the directory exists
                    if (!file_exists($uploadDir)) {
                        mkdir($uploadDir, 0755, true);
                    }

                    // Rename the file using product slug and variant code
                    $extension = $variantImageFile->getClientOriginalExtension();
                    $filename = $product->slug . '_' . uniqid() . '.' . $extension;

                    // Move the file to the target directory
                    $variantImageFile->move($uploadDir, $filename);

                    // Check if the file was moved successfully
                    $filePath = $uploadDir . '/' . $filename;
                    if (file_exists($filePath)) {
                        // Save image details in the database
                        $variantImage = new ProductImage();
                        $variantImage->product_id = $product->id;
                        $variantImage->variant_id = $variant->id;
                        $variantImage->image_path = 'uploads/products/' . $filename; // Save relative path
                        $variantImage->save();
                    } else {
                        // Handle error if the file couldn't be moved
                        throw new \Exception("Failed to move variant image '{$filename}' to {$uploadDir}");
                    }
                }
            }
        }

        if ($request->hasFile('media')) {
            $images = $request->file('media');
            $productSlug = $product->slug; // Assuming the product slug is already set

            foreach ($images as $index => $image) {
                // Define the upload directory
                $uploadDir = public_path('uploads/products');
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0755, true); // Create the directory if it doesn't exist
                }

                // Generate a unique filename with the product slug and loop index
                $extension = $image->getClientOriginalExtension();
                $filename = $productSlug . '_' . uniqid() . '_' . $index . '.' . $extension;

                // Move the file to the target directory
                $image->move($uploadDir, $filename);

                // Verify the file was successfully moved
                $filePath = $uploadDir . '/' . $filename;
                if (file_exists($filePath)) {
                    // Save the image path in the database
                    $productImage = new ProductImage();
                    $productImage->product_id = $product->id;
                    $productImage->image_path = 'uploads/products/' . $filename; // Relative path
                    $productImage->order = $index;
                    $productImage->save();
                } else {
                    // Handle the case where the file couldn't be moved (optional)
                    throw new \Exception("File '{$filename}' could not be saved to {$uploadDir}");
                }
            }
        }

        return response(['status' => 'success', 'message' => 'Product created successfully']);
        /* toastr()->success('Product Created Successfully');
        return to_route('admin.products.index'); */
    }

    public function generateExcelTemplate()
    {
        try {
            $spreadsheet = new Spreadsheet();

            // Create Product Sheet
            $productSheet = $spreadsheet->setActiveSheetIndex(0);
            $productSheet->setTitle('Products');
            $productHeaders = [
                'sku',
                'name',
                'slug',
                'main_category_id',
                'category_id',
                'sub_category_id',
                'description',
                'specification',
                'brand',
                'material',
                'units',
                'weight_type',
                'other_code',
                'gst',
                'has_variants',
                'sale_price',
                'offer_price',
                'distributor_price',
                'wholesale_price',
                'min_order_qty',
                'weight',
                'qty',
                'seo_title',
                'seo_description',
                'status',
                'priority'
            ];
            $productSheet->fromArray($productHeaders, null, 'A1');

            // Create Variant Sheet
            $variantSheet = $spreadsheet->createSheet();
            $variantSheet->setTitle('Variants');
            $variantHeaders = [
                'product_sku',
                'variant_sku',
                'variation_code',
                'sale_price',
                'offer_price',
                'distributor_price',
                'wholesale_price',
                'min_order_qty',
                'weight',
                'qty',
                'status',
                'image_path'
            ];
            $variantSheet->fromArray($variantHeaders, null, 'A1');

            // Output Excel file
            $writer = new Xlsx($spreadsheet);
            $fileName = 'product_import_sample.xlsx';
            $filePath = storage_path('app/' . $fileName); // Use storage/app

            // Ensure directory exists
            if (!file_exists(storage_path('app'))) {
                mkdir(storage_path('app'), 0755, true);
            }

            $writer->save($filePath);

            return response()->download($filePath)->deleteFileAfterSend(true);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to generate Excel sheet: ' . $e->getMessage()], 500);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::findOrFail($id);
        return view('admin.product.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $product = Product::with([
            'mainCategory',
            'category',
            'subCategory',
            'brandName',
            'images',
            'variants.images'
        ])->findOrFail($id);

        /* $mainCategories = MainCategory::where('status', 1)
        ->whereHas('categories', function ($query) {
        $query->where('status', 1)
        ->whereHas('subcategories', function ($query) {
        $query->where('status', 1);
        });
        })
        ->with(['categories' => function ($query) {
        $query->where('status', 1)
        ->with(['subcategories' => function ($query) {
        $query->where('status', 1);
        }]);
        }])
        ->get(); */

        $mainCategories = MainCategory::where('status', 1)
            ->whereHas('categories', function ($query) {
                $query->where('status', 1);
            })
            ->with([
                'categories' => function ($query) {
                    $query->where('status', 1)
                        ->with([
                            'subcategories' => function ($query) {
                                $query->where('status', 1);
                            }
                        ]);
                }
            ])
            ->get();

        $brands = Brand::where('status', 1)->get();

        $variantMasters = VariantMaster::whereNotIn('name', ['Material', 'Units', 'Weight Type'])
            ->with('details')
            ->get();

        $materials = VariantDetail::where('status', 1)
            ->whereHas('variantMaster', function ($query) {
                $query->where('name', 'material');
            })
            ->get();

        $units = VariantDetail::where('status', 1)
            ->whereHas('variantMaster', function ($query) {
                $query->where('name', 'units');
            })
            ->get();

        $weightTypes = VariantDetail::where('status', 1)
            ->whereHas('variantMaster', function ($query) {
                $query->where('name', 'Weight Type');
            })
            ->get();

        return view('admin.product.edit', compact(
            'product',
            'brands',
            'mainCategories',
            'variantMasters',
            'materials',
            'units',
            'weightTypes'
        ));
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
