@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Variant Master</h1>
    </div>
</section>

<div class="card card-primary">
    <div class="card-header">
        <h4>All Variant Masters</h4>
    </div>
    <div class="card-body">
        <!-- Form for adding or editing variants -->
        <form id="variantForm">
            <div class="form-group">
                <div class="row">
                    <div class="col-md-4">
                        <input type="text" id="variantName" placeholder="Enter variant name" name="name"
                            class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <button type="button" id="submitVariant" class="btn btn-primary mt-2">Add</button>
                    </div>
                </div>
            </div>
        </form>
        <span class="text-danger">Double click on the below names to edit the text.</span>
        <table id="variantsTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Status</th>
                    <th>Actions</th>
                    <th>Drag</th> <!-- Drag handle column -->
                </tr>
            </thead>
            <tbody id="sortable">
                @if($variants->isEmpty())
                    <tr>
                        <td colspan="4">No variants found.</td>
                    </tr>
                @else
                    @foreach($variants as $variant)
                        <tr data-id="{{ $variant->id }}">
                            {{-- <td contenteditable="true" class="editable-cell">{{ $variant->name }}
                            </td> --}}
                            <td contenteditable="true" class="editable-cell"
                                data-original-name="{{ $variant->name }}">{{ $variant->name }}</td>

                            <td>
                                <select class="form-control status" data-id="{{ $variant->id }}">
                                    <option value="1"
                                        {{ $variant->status == 1 ? 'selected' : '' }}>
                                        Active</option>
                                    <option value="0"
                                        {{ $variant->status == 0 ? 'selected' : '' }}>
                                        Inactive</option>
                                </select>
                            </td>
                            <td>
                                <a href="{{ route('admin.variant-master.destroy', $variant->id) }}"
                                    class="btn btn-danger delete-item btn-sm">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                            <td class="drag-handle">
                                <i class="fa fa-arrows-alt"></i> <!-- Drag icon -->
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        <!-- {{ $variants->links() }} -->
    </div>
</div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script>
        $(document).ready(function () {
            // Handle adding a new variant via AJAX
            $('#submitVariant').on('click', function () {
                $.ajax({
                    url: "{{ route('admin.variant-master.store') }}",
                    type: "POST",
                    data: {
                        name: $('#variantName').val(),
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        $('#variantsTable tbody').append(`
                            <tr data-id="${response.id}">
                                <td contenteditable="true" class="editable-cell">${response.name}</td>

                                <td>
                                    <select class="form-control status" data-id="${response.id}">
                                        <option value="1" ${response.status == 1 ? 'selected' : ''}>Active</option>
                                        <option value="0" ${response.status == 0 ? 'selected' : ''}>Inactive</option>
                                    </select>
                                </td>

                                <td>
                                    <a href="${deleteVariantRoute(response.id)}" class="btn btn-danger btn-sm delete-link">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        `);
                        $('#variantName').val(''); // Clear the input field after submission
                        toastr.success(
                        'Variant added successfully!'); // Show success message
                    },
                    error: function (xhr) {
                        // Check for validation errors
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            // Loop through each error and display them in toastr
                            $.each(errors, function (key, value) {
                                toastr.error(value[
                                    0
                                ]); // Display the first error message for each field
                            });
                        } else {
                            toastr.error(
                                'An error occurred. Please try again.'
                            ); // General error message
                        }
                    }
                });
            });

            function deleteVariantRoute(variantId) {
                return "{{ route('admin.variant-master.destroy', ':id') }}".replace(':id', variantId);
            }

            // Handle inline editing
            $('#variantsTable').on('blur', '.editable-cell', function () {
                var row = $(this).closest('tr');
                var id = row.data('id');
                var name = $(this).text().trim();

                // Prevent sending an empty name
                if (!name) {
                    toastr.error('Variant name cannot be empty.');
                    return;
                }

                // Check if the name has changed
                if ($(this).data('original-name') !== name) {
                    $.ajax({
                        url: "/admin/variant-master/" + id,
                        type: "PUT",
                        data: {
                            name: name,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function (response) {
                            $(this).data('original-name', name); // Update original name
                            toastr.success('Variant updated successfully');
                        },
                        error: function (xhr) {
                            if (xhr.status === 422) {
                                var errors = xhr.responseJSON.errors;
                                $.each(errors, function (key, value) {
                                    toastr.error(value[
                                        0
                                        ]); // Show the first error message for the field
                                });
                            }
                        }
                    });
                }
            });

            // Handle status change
            $('#variantsTable').on('change', '.status', function () {
                var row = $(this).closest('tr');
                var id = row.data('id');
                var status = $(this).val();
                var name = row.find('.editable-cell').text().trim(); // Get the current name

                // Update status without sending the name unless it has changed
                $.ajax({
                    url: "/admin/variant-master/" + id,
                    type: "PUT",
                    data: {
                        status: status,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        toastr.success('Status updated successfully');
                    },
                    error: function (xhr) {
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            $.each(errors, function (key, value) {
                                toastr.error(value[
                                    0
                                    ]); // Show the first error message for the field
                            });
                        }
                    }
                });
            });


            // Make table rows draggable for ordering
            $("#sortable").sortable({
                handle: ".drag-handle", // Use this as the draggable area
                update: function (event, ui) {
                    var order = [];
                    $('#sortable tr').each(function (index) {
                        order.push({
                            id: $(this).data('id'),
                            position: index + 1
                        });
                    });

                    $.ajax({
                        url: "{{ route('admin.variant-master.updateOrder') }}",
                        type: "POST",
                        data: {
                            order: order,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function (response) {
                            toastr.success('Order updated successfully');
                        }
                    });
                }
            });
        });

    </script>
@endpush

@push('styles')
    <style>
        .drag-handle {
            cursor: move;
            /* Display a drag cursor */
            text-align: center;
            width: 50px;
        }

    </style>
@endpush
