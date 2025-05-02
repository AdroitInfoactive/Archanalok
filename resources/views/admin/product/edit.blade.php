@extends('admin.layouts.master')

@section('content')
<link rel="stylesheet" href="{{ asset('admin/assets/css/product-page.css') }}">
<section class="section">
  <div class="section-header">
    <span onclick="goBack()" style="cursor:pointer;font-size:1.5em">
      <i class="fas fa-arrow-left"></i>
    </span>&nbsp;
    <h1>Edit Product</h1>
  </div>
</section>

<div class="container container-custom">
  <form action="{{ route('admin.products.update', $product->id) }}"
        method="POST"
        enctype="multipart/form-data"
        id="product-form">
    @csrf @method('PUT')

    {{-- ================= Product Details ================= --}}
    <div class="card mb-4">
      <div class="card-header"><h4>Product Details</h4></div>
      <div class="card-body">
        {{-- Category Dropdown --}}
        <div class="form-group">
          <label for="category">Category *</label>
          <select id="category" name="category" class="form-control select2">
            <option value="">Select Category</option>
            @foreach($mainCategories as $mc)
              <optgroup label="{{ $mc->name }}">
                @foreach($mc->categories as $c)
                  <option value="{{ $mc->id }}-{{ $c->id }}-0"
                          {{ $c->subcategories->isNotEmpty() ? 'disabled' : '' }}
                          {{ $product->main_category_id==$mc->id && $product->category_id==$c->id?'selected':'' }}>
                    -- {{ $c->name }}
                  </option>
                  @foreach($c->subcategories as $sc)
                    <option value="{{ $mc->id }}-{{ $c->id }}-{{ $sc->id }}"
                            {{ $product->main_category_id==$mc->id && $product->category_id==$c->id && $product->sub_category_id==$sc->id?'selected':'' }}>
                      ---- {{ $sc->name }}
                    </option>
                  @endforeach
                @endforeach
              </optgroup>
            @endforeach
          </select>
        </div>

        {{-- Name & Slug --}}
        <div class="form-group">
          <label for="name">Title *</label>
          <input type="text" name="name" id="name" class="form-control"
                 value="{{ old('name',$product->name) }}">
         
        </div>

        {{-- Description --}}
        <div class="form-group">
          <label for="description">Description</label>
          <textarea name="description" id="description"
                    class="form-control summernote">{{ old('description',$product->description) }}</textarea>
        </div>

        {{-- Specification --}}
        <div class="form-group">
          <label for="specification">Specification / Additional Information</label>
          <textarea name="specification" id="specification"
                    class="form-control summernote">{{ old('specification',$product->specification) }}</textarea>
        </div>

        {{-- Brand --}}
        <div class="form-group">
          <label for="brand">Brand</label>
          <select name="brand" id="brand" class="form-control select2">
            <option value="">Select a brand</option>
            @foreach($brands as $b)
              <option value="{{ $b->id }}"
                      {{ old('brand',$product->brand)==$b->id?'selected':'' }}>
                {{ $b->name }}
              </option>
            @endforeach
          </select>
        </div>

        {{-- Material / Units / Weight Type --}}
        <div class="form-row">
          <div class="form-group col-md-4">
            <label for="material">Material *</label>
            <select name="material" id="material" class="form-control select2" required>
              <option value="">Select Material</option>
              @foreach($materials as $m)
                <option value="{{ $m->id }}"
                        {{ old('material',$product->material)==$m->id?'selected':'' }}>
                  {{ $m->name }}
                </option>
              @endforeach
            </select>
          </div>
          <div class="form-group col-md-4">
            <label for="units">Units *</label>
            <select name="units" id="units" class="form-control select2" required>
              <option value="">Select Units</option>
              @foreach($units as $u)
                <option value="{{ $u->id }}"
                        {{ old('units',$product->units)==$u->id?'selected':'' }}>
                  {{ $u->name }}
                </option>
              @endforeach
            </select>
          </div>
          <div class="form-group col-md-4">
            <label for="weight_type">Weight Type *</label>
            <select name="weight_type" id="weight_type" class="form-control select2" required>
              <option value="">Select Weight Type</option>
              @foreach($weightTypes as $wt)
                <option value="{{ $wt->id }}"
                        {{ old('weight_type',$product->weight_type)==$wt->id?'selected':'' }}>
                  {{ $wt->name }}
                </option>
              @endforeach
            </select>
          </div>
        </div>
      </div>
    </div>

    {{-- ================= Images & Files ================= --}}
    <div class="card mb-4">
      <div class="card-header"><h4>Media</h4></div>
      <div class="card-body">
        {{-- Image uploader (existing images + dropzone) --}}
        <div class="d-flex justify-content-between mb-2">
          <h5>Images</h5>
          <button type="button" id="delete-selected" class="btn btn-danger d-none">
            Delete Selected
          </button>
        </div>
        <div id="media-container" class="media-container d-flex flex-wrap gap-3 dropzone">
          @forelse($product->images->where('variant_id', null) as $img)
            <div class="media-item media-item-small" data-id="{{ $img->id }}">
              <input type="checkbox" class="image-checkbox" data-id="{{ $img->id }}">
              <img src="{{ asset($img->image_path) }}" class="img-thumbnail"
                   style="width:150px;height:150px;object-fit:cover">
            </div>
          @empty
            <p>No images. Upload below.</p>
          @endforelse
          <div class="media-item add-image-placeholder">
            <label for="file-input"><div class="add-image-icon">+</div></label>
            <input type="file" id="file-input" name="media[]" class="d-none"
                   accept="image/*" multiple>
          </div>
        </div>

        {{-- Brochure PDF --}}
        <div class="form-group mt-3">
          <label for="file">Brochure File (If any)</label>
          <input type="file" name="file" id="file" class="form-control"
                 accept="application/pdf">
          @if($product->file)
            <p class="mt-2">
              Current: <a href="{{ asset($product->file) }}" target="_blank">
              {{ basename($product->file) }}</a>
            </p>
          @endif
        </div>
      </div>
    </div>

    {{-- ================= Codes, GST, Priority, Status ================= --}}
    <div class="card mb-4">
      <div class="card-body">
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="sku">SKU *</label>
            <input type="text" name="sku" id="sku" class="form-control"
                   value="{{ old('sku',$product->sku) }}">
          </div>
          <div class="form-group col-md-6">
            <label for="other_code">Other Code (comma‑sep)</label>
            <input type="text" name="other_code" id="other_code" class="form-control"
                   value="{{ old('other_code',$product->other_code) }}">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-4">
            <label for="gst">GST %</label>
            <input type="text" name="gst" id="gst" class="form-control"
                   value="{{ old('gst',$product->gst) }}">
          </div>
          <div class="form-group col-md-4">
            <label for="priority">Priority *</label>
            <input type="text" name="priority" id="priority" class="form-control"
                   value="{{ old('priority',$product->priority) }}">
          </div>
          <div class="form-group col-md-4">
            <label for="status">Status</label>
            <select name="status" id="status" class="form-control">
              <option value="1" {{ old('status',$product->status)==1?'selected':'' }}>Active</option>
              <option value="0" {{ old('status',$product->status)==0?'selected':'' }}>Inactive</option>
            </select>
          </div>
        </div>
      </div>
    </div>

    {{-- ================= Variant Toggle ================= --}}
    <div class="card mb-4">
      <div class="card-body">
        <label>Product Has Variants</label>
        <div class="form-check form-check-inline">
          <input type="radio" name="has_variants" id="variants_yes" value="1"
                 class="form-check-input" {{ $product->has_variants?'checked':'' }}>
          <label class="form-check-label" for="variants_yes">Yes</label>
        </div>
        <div class="form-check form-check-inline">
          <input type="radio" name="has_variants" id="variants_no" value="0"
                 class="form-check-input" {{ !$product->has_variants?'checked':'' }}>
          <label class="form-check-label" for="variants_no">No</label>
        </div>
      </div>
    </div>

    {{-- ================= Variation Details ================= --}}
    <div class="card mb-4 variation-yes d-none">
      <div class="card-header"><h4>Variation Details</h4></div>
      <div class="card-body">
        {{-- Master/Detail --}}
        <div class="form-group">
          <label>Select Applicable Variations</label>
          <div id="variant-options" class="row">
            @foreach($variantMasters as $vm)
              @php
                $saved   = json_decode(old('variant_master_detail',$product->variation_ids),true)?:[];
                $checked = array_column($saved[$vm->id]['details']??[],'id');
              @endphp
              <div class="col-md-2 mb-3">
                <div class="card p-2" style="height:250px;overflow-y:auto;">
                  <strong>{{ $vm->name }}</strong><hr>
                  @foreach($vm->details as $d)
                    <div class="form-check">
                      <input type="checkbox"
                             class="form-check-input variant-checkbox"
                             data-masterid="{{ $vm->id }}"
                             data-detail="{{ $d->name }}"
                             data-detailid="{{ $d->id }}"
                             value="{{ $d->id }}"
                             {{ in_array($d->id,$checked)?'checked':'' }}>
                      <label class="form-check-label">{{ $d->name }}</label>
                    </div>
                  @endforeach
                </div>
              </div>
            @endforeach
          </div>
        </div>

        <input type="hidden" name="variant_master_detail" id="variant-master-detail">

        <button type="button" id="generate-variations" class="btn btn-primary mb-3">
          Generate Variations
        </button>
        @if($product->has_variants)
             <a href="#" class="btn btn-md btn-info mb-3" data-toggle="modal" data-target="#variationsModal"> View old Variations </a>
        @endif
{{-- popup old varient details --}}
@if($product->has_variants)
  <div class="modal fade" id="variationsModal" tabindex="-1" role="dialog" aria-labelledby="variationsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="variationsModalLabel">Variation Details</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="table-responsive">
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Image</th>
                  <th>Variation</th>
                  <th>SKU</th>
                  <th>Sale Price</th>
                  <th>Offer Price</th>
                  <th>Distributor Price</th>
                  <th>Min Order Qty</th>
                  <th>Wholesale Price</th>
                  <th>Weight</th>
                  <th>Available Quantity</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                @foreach($product->variants as $variant)
                  <tr>
                    <td>
                      @if($variant->images->isNotEmpty())
                        <img src="{{ asset($variant->images->first()->image_path) }}"
                             alt="Variant Image"
                             class="img-thumbnail"
                             style="width:50px;height:50px;object-fit:cover">
                      @else
                        <span>No Image</span>
                      @endif
                    </td>
                    <td>{{ $variant->variation_code }}</td>
                    <td>{{ $variant->sku }}</td>
                    <td>{{ number_format($variant->sale_price,2) }}</td>
                    <td>{{ number_format($variant->offer_price,2) }}</td>
                    <td>{{ number_format($variant->distributor_price,2) }}</td>
                    <td>{{ $variant->min_order_qty }}</td>
                    <td>{{ number_format($variant->wholesale_price,2) }}</td>
                    <td>{{ $variant->weight }}</td>
                    <td>{{ $variant->qty }}</td>
                    <td>{{ $variant->status ? 'Active' : 'Inactive' }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
@endif

{{-- end popup --}}

        <div class="table-responsive d-none" id="variations-table">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>Image</th>
                <th>Variation</th>
                <th>SKU</th>
                <th>Sale Price</th>
                <th>Offer Price</th>
                <th>Distributor Price</th>
                <th>Min Order Qty</th>
                <th>Wholesale Price</th>
                <th>Weight</th>
                <th>Qty</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody id="variations-body"></tbody>
          </table>
        </div>
      </div>
    </div>

    {{-- ================= Pricing (no variants) ================= --}}
    <div class="card mb-4 variation-no d-none">
      <div class="card-header"><h4>Pricing Details</h4></div>
      <div class="card-body">
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="sale_price">Sale Price</label>
            <input type="number" name="sale_price" id="sale_price" class="form-control"
                   step="0.01" value="{{ $product->sale_price }}">
          </div>
          <div class="form-group col-md-6">
            <label for="offer_price">Offer Price</label>
            <input type="number" name="offer_price" id="offer_price" class="form-control"
                   step="0.01" value="{{ $product->offer_price }}">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-4">
            <label for="distributor_price">Distributor Price</label>
            <input type="number" name="distributor_price" id="distributor_price" class="form-control"
                   step="0.01" value="{{ $product->distributor_price }}">
          </div>
          <div class="form-group col-md-4">
            <label for="wholesale_price">Wholesale Price</label>
            <input type="number" name="wholesale_price" id="wholesale_price" class="form-control"
                   step="0.01" value="{{ $product->wholesale_price }}">
          </div>
          <div class="form-group col-md-4">
            <label for="min_order_qty">Min Order Qty</label>
            <input type="number" name="min_order_qty" id="min_order_qty" class="form-control"
                   value="{{ $product->min_order_qty }}">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="weight">Weight</label>
            <input type="number" name="weight" id="weight" class="form-control"
                   step="0.01" value="{{ $product->weight }}">
          </div>
          <div class="form-group col-md-6">
            <label for="qty">Available Quantity</label>
            <input type="number" name="qty" id="qty" class="form-control"
                   value="{{ $product->qty }}">
          </div>
        </div>
      </div>
    </div>

    <hr>
    {{-- ================= SEO Start ================= --}}
     <div class="card mb-4">
      <div class="card card-primary">
          <div class="card-header">
              <h4>Search Engine Listing</h4>
              <button type="button" id="edit-seo-btn" class="btn btn-sm float-right">
                  <i class="fas fa-pencil-alt"></i>
              </button>
          </div>
          <div class="card-body">
            <div id="seo-fields" style="display: none;">
                <div class="form-group">
                    <label>SEO Title</label>
                    <input type="text" name="seo_title" id="seo_title"
                        value="{{ old('seo_title', $product->seo_title) }}"
                        class="form-control">
                </div>
                <div class="form-group">
                    <label>SEO Description</label>
                    <textarea name="seo_description" id="seo_description"
                        class="form-control">{{ old('seo_description', $product->seo_description) }}</textarea>
                </div>
                <div class="form-group">
                    <label>URL Handle</label>
                    <input type="text" name="slug" id="slug"
                        value="{{ old('slug', $product->slug) }}"
                        class="form-control" />
                    <input type="hidden" name="old_slug" id="old-slug" value="{{ $product->slug }}">
                    <input type="hidden" name="new_slug" id="new-slug" value="{{ $product->slug }}">
                    <input type="hidden" name="full_old_slug" id="full-old-slug"
                        value="{{ $product->slug }}">
                    <input type="hidden" name="full_new_slug" id="full-new-slug"
                        value="{{ $product->slug }}">
                    <div style="display: flex; align-items: center;">
                        <input type="checkbox" id="create-url-redirect" name="create_url_redirect" value="1"
                            style="display: none; margin-right: 5px;">
                        <label for="create-url-redirect" id="redirect-label" style="display: none;">
                            Create a URL redirect for<br>
                            <strong>{{ old('slug', $product->slug) }} → <span
                                    id="generated-url"></span></strong>
                        </label>
                    </div>
                </div>
            </div>
            <div class="seo-preview">
                <div class="preview-container">
                    <p class="preview-url" id="preview-url">
                        {{ $actual_link = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://".$_SERVER['HTTP_HOST']."/" }}<span
                            id="generated-url-preview">{{ old('slug', $product->slug) }}</span>
                    </p>
                    <p class="preview-title" id="preview-title">
                        {{ old('seo_title', $product->seo_title) }}</p>
                    <p class="preview-description" id="preview-description">
                        {{ old('seo_description', $product->seo_description) }}
                    </p>
                </div>
            </div>
        </div>
      </div>
  </div>
  {{-- ================= SEO End ================= --}}
    <hr>
    <div class="text-center mt-3">
      <button type="submit" class="btn btn-success">Update Product</button>
      <button type="button" class="btn btn-danger" onclick="goBack()">Go Back</button>
    </div>
  </form>
</div>
@endsection

@push('scripts')
<script>
  const originalName = "{{ $product->name }}";
  const originalDescription = "{{ $product->description }}";
  const originalSeoTitle = "{{ $product->seo_title }}";
  const originalSeoDescription = "{{ $product->seo_description }}";
  const originalSlug = "{{ $product->slug }}";
  const isEditPage = true;
  const level = 0;
  const existingVariants = @json($existingVariants);
  const baseSku = document.getElementById('sku').value || '';
</script>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script src="{{ asset('admin/assets/js/form-script.js') }}"></script>
<script src="{{ asset('admin/assets/js/seo-handler-edit.js') }}"></script>
<script src="{{ asset('admin/assets/js/product-edit-page.js') }}"></script>

@endpush
