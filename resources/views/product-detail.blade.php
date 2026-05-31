@extends('web-layouts.app')

@section('title', $product->name)

@section('content')
<div class="container py-4">
    <div class="row">

        <div class="col-md-6">
            @if(!empty($product->image) && is_array($product->image) && count($product->image) > 0)
            <div class="main-image-container mb-3">
                <img id="mainProductImage" src="{{ asset('uploads/' . $product->image[0]) }}" class="img-fluid rounded shadow" alt="{{ $product->name }}" style="width: 100%; max-height: 500px; object-fit: contain;">
            </div>

            @if(count($product->image) > 1)
            <div class="d-flex flex-wrap gap-2 mt-2">
                @foreach($product->image as $index => $img)
                <img src="{{ asset('uploads/' . $img) }}"
                    class="img-thumbnail product-thumb {{ $index === 0 ? 'border-primary' : '' }}"
                    style="width: 80px; height: 80px; object-fit: cover; cursor: pointer;"
                    onclick="changeMainImage('{{ asset('uploads/' . $img) }}', this)">
                @endforeach
            </div>
            @endif
            @else
            <div class="main-image-container mb-3">
                <img src="https://via.placeholder.com/500x500" class="img-fluid rounded shadow" alt="{{ $product->name }}" style="width: 100%; max-height: 500px; object-fit: contain;">
            </div>
            @endif
        </div>

        <div class="col-md-6">
            <h3>{{ $product->name }}</h3>

            <p class="text-danger fs-4 fw-bold">{{ number_format($product->price, 0, ',', '.') }} đ</p>

            <div class="mb-3">
                <strong>Category:</strong> {{ $product->category->name ?? 'N/A' }}
            </div>

            <div class="mb-3">
                <strong>Stock:</strong>
                @if($product->stock > 0)
                <span class="badge bg-success">{{ $product->stock }} available</span>
                @else
                <span class="badge bg-danger">Out of stock</span>
                @endif
            </div>

            <div class="mb-3">
                <strong>Added:</strong> {{ $product->created_at->format('M d, Y') }}
            </div>

            <div class="mt-4">
                @if($product->stock > 0)
                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="d-inline">
                    @csrf
                    <button class="btn btn-outline-success btn-lg">Add to Cart</button>
                </form>
                @else
                <button class="btn btn-secondary btn-lg" disabled>
                    <i class="fas fa-times"></i> Out of Stock
                </button>
                @endif

                <a href="{{ route('products.index') }}" class="btn btn-outline-primary btn-lg ms-2">Back to Products</a>
            </div>
        </div>

    </div>
    <div class="row mt-5">
        <div class="col-12">
            <h4 class="border-bottom pb-2">Description</h4>
            <p class="text-muted" style="line-height: 1.6;">{!! nl2br(e($product->description ?? 'No description available.')) !!}</p>
        </div>
    </div>
</div>

<script>
    function changeMainImage(imageSrc, thumbnailElement) {
        document.getElementById('mainProductImage').src = imageSrc;

        document.querySelectorAll('.product-thumb').forEach(thumb => {
            thumb.classList.remove('border-primary');
        });

        thumbnailElement.classList.add('border-primary');
    }
</script>
@endsection