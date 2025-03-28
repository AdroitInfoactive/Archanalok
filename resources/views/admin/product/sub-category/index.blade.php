@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Product Sub Category</h1>
        </div>
    </section>
    <div class="card card-primary">
        <div class="card-header">
            <h4>All Product Sub Categories</h4>
            <div class="card-header-action">
                <a href="{{ route('admin.sub-category.create') }}" class="btn btn-primary">
                    Create New
                </a>
            </div>
        </div>
        <div class="card-body">
            {{ $dataTable->table() }}
        </div>
    </div>
@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
