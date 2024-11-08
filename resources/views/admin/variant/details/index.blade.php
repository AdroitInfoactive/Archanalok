@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Variant Details</h1>
        </div>
    </section>
    <div class="card card-primary">
        <div class="card-header">
            <h4>All Variant Details</h4>
            <div class="card-header-action">
                <a href="{{ route('admin.variant-details.create') }}" class="btn btn-primary">
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


