@extends('admin.layouts.app')

@section('title', 'Brands')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Brands Management</h1>
        <a href="{{ route('admin.brands.create') }}" class="btn btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Add Brand
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="dataTable" width="100%" cellspacing="0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 50px;">ID</th>
                            <th>Brand Name</th>
                            <th>Description</th>
                            <th style="width: 120px;">Status</th>
                            <th style="width: 180px;" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($brands as $brand)
                            <tr>
                                <td>#{{ $brand->id }}</td>
                                <td><strong>{{ $brand->name }}</strong></td>
                                <td class="text-muted">
                                    {{ $brand->description ?? 'No description available' }}
                                </td>
                                <td>{!! $brand->status_badge !!}</td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('admin.brands.show', $brand->id) }}" 
                                           class="btn btn-info btn-sm text-white">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                        <a href="{{ route('admin.brands.edit', $brand->id) }}" 
                                           class="btn btn-warning btn-sm text-white">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('admin.brands.destroy', $brand->id) }}" 
                                              method="POST" 
                                              onsubmit="return confirm('Delete this brand?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="fas fa-folder-open fa-3x mb-3 d-block"></i>
                                    No brands found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection