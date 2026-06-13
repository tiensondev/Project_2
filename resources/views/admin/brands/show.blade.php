@extends('admin.layouts.app')

@section('title', 'Brand Details')

@section('content')
    <h1>Brand Details</h1>

    <div class="card mb-4">
        <div class="card-body">
            <table class="table table-bordered">
                <tr><th>ID</th><td>{{ $brand->id }}</td></tr>
                <tr><th>Name</th><td>{{ $brand->name }}</td></tr>
                <tr><th>Description</th><td>{{ $brand->description }}</td></tr>
                <tr><th>Status</th><td>{!! $brand->status_badge !!}</td></tr>
                <tr><th>Created At</th><td>{{ $brand->created_at }}</td></tr>
                <tr><th>Updated At</th><td>{{ $brand->updated_at }}</td></tr>
            </table>

            <a href="{{ route('admin.brands.index') }}" class="btn btn-secondary">Back</a>
            <a href="{{ route('admin.brands.edit', $brand->id) }}" class="btn btn-warning">Edit</a>
        </div>
    </div>
@endsection