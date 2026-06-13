@extends('admin.layouts.app')

@section('title', 'Product Details')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Product Details List</h1>
    <a href="{{ route('admin.product-details.create') }}" class="btn btn-primary">
        <i class="fas fa-plus fa-sm text-white-50"></i> Add Product Detail
    </a>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="card shadow mb-4">
    <div class="card-body">
        <form action="{{ route('admin.product-details.search') }}" method="GET" class="row g-3 shadow-sm p-3 mb-4 bg-white rounded">
            <div class="col-md-4">
                <label class="form-label">Product</label>
                <select name="product_id" class="form-select">
                    <option value="">-- All Products --</option>
                    @foreach($products as $product)
                    <option value="{{ $product->id }}" {{ request('product_id') == $product->id ? 'selected' : '' }}>
                        {{ $product->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label">CPU</label>
                <input type="text" name="cpu" class="form-control"
                    placeholder="Search CPU..." value="{{ request('cpu') }}">
            </div>

            <div class="col-md-3">
                <label class="form-label">RAM</label>
                <input type="text" name="ram" class="form-control"
                    placeholder="Search RAM..." value="{{ request('ram') }}">
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

<div class="card shadow mb-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3">ID</th>
                        <th>Product</th>
                        <th>CPU</th>
                        <th>RAM</th>
                        <th>Storage</th>
                        <th>GPU</th>
                        <th>Screen</th>
                        <th>Color</th>
                        <th style="min-width: 120px;">Price</th>
                        <th>Stock</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($details as $detail)
                    <tr>
                        <td class="ps-3">#{{ $detail->id }}</td>

                        <td>
                            <strong>{{ $detail->product->name ?? 'N/A' }}</strong>
                        </td>

                        <td>{{ $detail->cpu ?? 'N/A' }}</td>
                        <td>{{ $detail->ram ?? 'N/A' }}</td>
                        <td>{{ $detail->storage ?? 'N/A' }}</td>
                        <td>{{ $detail->gpu ?? 'N/A' }}</td>
                        <td>{{ $detail->screen ?? 'N/A' }}</td>
                        <td>{{ $detail->color ?? 'N/A' }}</td>

                        <td class="text-danger fw-bold text-nowrap">
                            {{ number_format($detail->price, 0, ',', '.') }} đ
                        </td>

                        <td>
                            @if($detail->stock <= 5)
                                <span class="badge bg-warning text-dark">Only {{ $detail->stock }} left</span>
                                @else
                                <span class="badge bg-info">{{ $detail->stock }}</span>
                                @endif
                        </td>

                        <td>
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('admin.product-details.show', $detail->id) }}" class="btn btn-info btn-sm text-white">
                                    <i class="fas fa-eye"></i> View
                                </a>

                                <a href="{{ route('admin.product-details.edit', $detail->id) }}" class="btn btn-warning btn-sm text-white">
                                    <i class="fas fa-edit"></i> Edit
                                </a>

                                <form action="{{ route('admin.product-details.destroy', $detail->id) }}" method="POST" onsubmit="return confirm('Delete this product detail?');">
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
                        <td colspan="11" class="text-center py-5 text-muted">
                            No product details found matching your criteria.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if(method_exists($details, 'links'))
    <div class="card-footer bg-white">
        <div class="d-flex justify-content-between align-items-center">

            <div class="text-muted">
                Showing {{ $details->firstItem() }} to {{ $details->lastItem() }}
                of {{ $details->total() }} results
            </div>

            <div>
                {{ $details->appends(request()->query())->links('pagination::bootstrap-4') }}
            </div>

        </div>
    </div>
    @endif
</div>
@endsection