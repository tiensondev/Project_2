@extends('web-layouts.app')

@section('title', $product->name)

@section('content')
<div class="container py-4">
    <div class="row">

        <div class="col-md-6">
            @if(!empty($product->image) && is_array($product->image) && count($product->image) > 0)
            <div class="main-image-container mb-3">
                <img id="mainProductImage"
                    src="{{ asset('uploads/' . $product->image[0]) }}"
                    class="img-fluid rounded shadow"
                    alt="{{ $product->name }}"
                    style="width: 100%; max-height: 500px; object-fit: contain;">
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
                <img src="https://via.placeholder.com/500x500"
                    class="img-fluid rounded shadow"
                    alt="{{ $product->name }}"
                    style="width: 100%; max-height: 500px; object-fit: contain;">
            </div>
            @endif
        </div>

        <div class="col-md-6">
            <h3>{{ $product->name }}</h3>

            <div class="mb-3">
                <strong>Category:</strong> {{ $product->category->name ?? 'N/A' }}
            </div>

            <div class="mb-3">
                <strong>Added:</strong> {{ $product->created_at->format('M d, Y') }}
            </div>

            @if($product->details->count() > 0)

            <form id="addToCartForm" action="{{ route('cart.add', $product->id) }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-bold">Choose Configuration</label>

                    <select name="product_detail_id" class="form-select" required>
                        <option value="">-- Select configuration --</option>

                        @foreach($product->details as $detail)
                        <option value="{{ $detail->id }}">
                            {{ $detail->cpu }} /
                            {{ $detail->ram }} /
                            {{ $detail->storage }} /
                            {{ $detail->gpu }} /
                            {{ $detail->screen }} /
                            {{ $detail->color }}
                            - Stock: {{ $detail->stock }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <strong class="fw-bold">Price:</strong>
                    <span id="productPrice" class="text-danger fw-bold">
                        {{ number_format($product->details->first()->price ?? $product->price, 0, ',', '.') }} đ
                    </span>
                </div>

                <div class="mb-3">
                    <label class="form-label">Quantity</label>
                    <input type="number"
                        name="quantity"
                        value="1"
                        min="1"
                        class="form-control"
                        style="width:120px;">
                </div>

                <button type="submit" class="btn btn-outline-success btn-lg">
                    Add to Cart
                </button>

                <a href="{{ route('products.index') }}" class="btn btn-outline-primary btn-lg ms-2">
                    Back to Products
                </a>
            </form>

            @else

            <div class="alert alert-warning mt-3">
                This product has no configuration yet.
            </div>

            <button class="btn btn-secondary btn-lg" disabled>
                Cannot add to cart
            </button>

            <a href="{{ route('products.index') }}" class="btn btn-outline-primary btn-lg ms-2">
                Back to Products
            </a>

            @endif
        </div>

    </div>

    <div class="row mt-5">
        <div class="col-12">
            <h4 class="border-bottom pb-2">Description</h4>
            <p class="text-muted" style="line-height: 1.6;">
                {!! nl2br(e($product->description ?? 'No description available.')) !!}
            </p>
        </div>
    </div>
</div>

<script>
    function changeMainImage(imageSrc, thumbnailElement) {
        const mainImage = document.getElementById('mainProductImage');

        if (mainImage) {
            mainImage.src = imageSrc;
        }

        document.querySelectorAll('.product-thumb').forEach(thumb => {
            thumb.classList.remove('border-primary');
        });

        thumbnailElement.classList.add('border-primary');
    }
</script>
@endsection