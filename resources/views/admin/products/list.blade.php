@extends('admin.layouts.app')

@section('title', 'Products')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Products List</h1>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary shadow-sm">
        <i class="fas fa-plus fa-sm text-white-50"></i> Add Product
    </a>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<!-- Search Filter -->
<div class="card shadow mb-4">
    <div class="card-body">
        <form action="{{ route('admin.products.search') }}" method="GET" class="row g-3 shadow-sm p-3 mb-4 bg-white rounded">
            <div class="col-md-4">
                <label class="form-label">Category</label>
                <select name="category" class="form-select">
                    <option value="">-- All Categories --</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Product Name</label>
                <input type="text" name="name" class="form-control"
                    placeholder="Search by name..." value="{{ request('name') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label">&nbsp;</label>
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-search"></i> Search
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Products Table -->
<div class="card shadow mb-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3">ID</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Category</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr>
                        <td class="ps-3">#{{ $product->id }}</td>
                        <td>
                            @if(!empty($product->image) && is_array($product->image) && isset($product->image[0]))
                            <img src="{{ asset('uploads/' . $product->image[0]) }}" alt="{{ $product->name }}" style="width: 70px; height: 70px; object-fit: cover; border-radius: 5px;">
                            @else
                            <img src="{{ asset('uploads/default-placeholder.png') }}" alt="No image" style="width: 70px; height: 70px; object-fit: cover;">
                            @endif
                        </td>
                        <td><strong>{{ $product->name }}</strong></td>
                        <td class="text-danger fw-bold">
                            {{ number_format($product->price, 0, ',', '.') }} đ
                        </td>
                        <td>
                            @if($product->stock <= 5)
                                <span class="badge bg-warning text-dark">Only {{ $product->stock }} left</span>
                                @else
                                <span class="badge bg-info">{{ $product->stock }}</span>
                                @endif
                        </td>
                        <td><span class="badge bg-secondary">{{ $product->category_name }}</span></td>
                        <td>
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('admin.products.show', $product->id) }}" class="btn btn-info btn-sm text-white">
                                    <i class="fas fa-eye"></i> View
                                </a>
                                <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-warning btn-sm text-white">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Delete this product?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            No products found matching your criteria.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    @if(method_exists($products, 'links'))
    <div class="card-footer bg-white">
        <div class="d-flex justify-content-between align-items-center">

            <div class="text-muted">
                Showing {{ $products->firstItem() }} to {{ $products->lastItem() }}
                of {{ $products->total() }} results
            </div>

            <div>
                {{ $products->appends(request()->query())->links('pagination::bootstrap-4') }}
            </div>

        </div>
    </div>
    @endif
</div>
@endsection