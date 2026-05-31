@extends('web-layouts.app')

@section('content')
<style>
    .product-img-wrapper {
        width: 100%;
        height: 250px;
        overflow: hidden;
    }

    .product-img-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .card-title-custom {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        height: 40px;
    }
</style>

<div class="container mt-4">
    <h3 class="mb-4">Product List With Categories: {{ $currentCategory->name ?? 'All Categories' }}</h3>

    <div class="row mb-4">
        <div class="col-md-12">
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('products.index') }}" class="btn btn-outline-primary {{ !request('category') ? 'active' : '' }}">
                    All Categories
                </a>
                @foreach($categories as $category)
                <a href="{{ route('products.index', ['category' => $category->id]) }}" class="btn btn-outline-primary {{ request('category') == $category->id ? 'active' : '' }}">
                    {{ $category->name }}
                </a>
                @endforeach
            </div>
        </div>
    </div>

    <div class="row">
        @forelse($products as $product)
        <div class="col-md-3 d-flex align-items-stretch mb-4">
            <div class="card shadow-sm h-100 w-100 d-flex flex-column">
                
                <div class="product-img-wrapper">
                    @if(!empty($product->image) && is_array($product->image) && count($product->image) > 0)
                        <img src="{{ asset('uploads/' . $product->image[0]) }}" alt="{{ $product->name }}" class="img-fluid">
                    @else
                        <img src="https://via.placeholder.com/358x358" alt="{{ $product->name }}" class="img-fluid">
                    @endif
                </div>

                <div class="card-body text-center d-flex flex-column mt-auto">
                    <h6 class="card-title-custom fw-bold">{{ $product->name }}</h6>
                    <p class="text-danger fw-bold mb-1">{{ number_format($product->price, 0, ',', '.') }} đ</p>
                    <p class="text-muted small mb-1">Stock: {{ $product->stock }}</p>
                    <p class="text-muted small mb-3">{{ $product->category->name ?? 'N/A' }}</p>

                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary btn-sm mt-auto w-100">
                        View Details
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-info text-center py-4">
                <h5>No products found</h5>
                <p class="mb-0">Please check back later for new products.</p>
            </div>
        </div>
        @endforelse
    </div>

    @if($products->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $products->links() }}
    </div>
    @endif
</div>
@endsection