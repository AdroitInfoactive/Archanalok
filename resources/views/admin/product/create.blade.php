@extends('admin.layouts.master')

@section('content')
<div class="container">
    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <!-- Product Details -->
        <div class="card mb-4">
            <div class="card-header">Product Details</div>
            <div class="card-body">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" id="title" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label for="media">Media</label>
                    <input type="file" name="media[]" id="media" class="form-control" multiple>
                </div>
            </div>
        </div>

        <!-- Pricing and Inventory -->
        <div class="row">
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">Pricing</div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="number" name="price" id="price" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="compare_at_price">Compare-at Price</label>
                            <input type="number" name="compare_at_price" id="compare_at_price" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">Inventory</div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="quantity">Quantity</label>
                            <input type="number" name="quantity" id="quantity" class="form-control" required>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="track_inventory" id="track_inventory" class="form-check-input" checked>
                            <label for="track_inventory" class="form-check-label">Track Inventory</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Variants Section -->
        <div class="card mb-4">
            <div class="card-header">Variants</div>
            <div class="card-body">
                <div id="variant-container">
                    <!-- Variants will be dynamically added here -->
                </div>
                <button type="button" class="btn btn-primary" id="add-variant">Add Variant</button>
            </div>
        </div>

        <button type="submit" class="btn btn-success">Save Product</button>
    </form>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Add new variant dynamically
        $('#add-variant').on('click', function() {
            let variantHtml = `
                <div class="form-group row">
                    <div class="col-md-4">
                        <input type="text" name="variant_names[]" class="form-control" placeholder="Variant Name">
                    </div>
                    <div class="col-md-4">
                        <input type="text" name="variant_values[]" class="form-control" placeholder="Variant Value">
                    </div>
                    <div class="col-md-4">
                        <button type="button" class="btn btn-danger remove-variant">Remove</button>
                    </div>
                </div>
            `;
            $('#variant-container').append(variantHtml);
        });

        // Remove a variant
        $(document).on('click', '.remove-variant', function() {
            $(this).closest('.form-group').remove();
        });
    });
</script>
@endsection
