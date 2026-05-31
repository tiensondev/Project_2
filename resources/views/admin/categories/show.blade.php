@extends('admin.layouts.app')

@section('title', 'Category Details')

@section('content')
    <h1>Category Details</h1>

    <div class="card mb-4">
        <div class="card-body">
            <table class="table table-bordered">
                <tr><th>ID</th><td>{{ $category->id }}</td></tr>
                <tr><th>Name</th><td>{{ $category->name }}</td></tr>
                <tr><th>Description</th><td>{{ $category->description }}</td></tr>
                <tr><th>Status</th><td>{!! $category->status_badge !!}</td></tr>
                <tr><th>Created At</th><td>{{ $category->created_at }}</td></tr>
                <tr><th>Updated At</th><td>{{ $category->updated_at }}</td></tr>
            </table>

            <a href="{{ route('admin.categories.list') }}" class="btn btn-secondary">Back</a>
            <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-warning">Edit</a>
        </div>
    </div>
@endsection