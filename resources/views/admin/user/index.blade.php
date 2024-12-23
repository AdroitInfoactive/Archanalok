@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Users</h1>
        </div>
    </section>
    <section class="section">
        <div class="card card-primary">
            <div class="card-header">
                <h4>All Users</h4>
            </div>
            <div class="card-body">
                {{ $dataTable->table() }}
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    <script>
        $(document).on('change', '.status-dropdown', function () {
    var status = $(this).val();
    var userId = $(this).data('id');

    $.ajax({
        url: '{{ route("admin.user.updateStatus") }}',
        method: 'POST',
        data: {
            id: userId,
            status: status,
            _token: '{{ csrf_token() }}'
        },
        success: function (response) {
            if (response.success) {
                toastr.success(response.message);
            } else {
                toastr.error(response.message);
            }
        },
        error: function () {
            toastr.error('Something went wrong. Please try again.');
        }
    });
});

    </script>
@endpush
