@extends('web-layouts.app')

@section('title', $product->name)

@section('content')
<div class="container py-4">
    <div class="row">

        {{-- Product Images --}}
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
                                 onclick="changeMainImage('{{ asset('uploads/' . $img) }}', this)"
                                 alt="{{ $product->name }}">
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

        {{-- Product Info --}}
        <div class="col-md-6">
            <h3>{{ $product->name }}</h3>

            <div class="mb-3">
                <strong>Category:</strong> {{ $product->category->name ?? 'N/A' }}
            </div>

            <div class="mb-3">
                <strong>Added:</strong> {{ $product->created_at->format('M d, Y') }}
            </div>

            @if($product->details->count() > 0)
                @php
                    $firstDetail = $product->details->first();
                @endphp

                <form id="addToCartForm" action="{{ route('cart.add', $product->id) }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="productDetailSelect" class="form-label fw-bold">
                            Choose Configuration
                        </label>

                        <select id="productDetailSelect" name="product_detail_id" class="form-control">
                            @foreach($product->details as $detail)
                                <option value="{{ $detail->id }}"
                                        data-price="{{ $detail->price }}"
                                        data-stock="{{ $detail->stock }}">
                                    {{ $detail->cpu }} / {{ $detail->ram }} / {{ $detail->storage }} /
                                    {{ $detail->gpu }} / {{ $detail->screen }} / {{ $detail->color }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <strong class="fw-bold">Price:</strong>
                        <span id="productPrice" class="text-danger fw-bold">
                            {{ number_format($firstDetail->price ?? 0, 0, ',', '.') }} đ
                        </span>
                    </div>

                    <div class="mb-3">
                        <strong class="fw-bold">Stock:</strong>
                        <span id="productStock">
                            {{ $firstDetail->stock ?? 0 }}
                        </span>
                    </div>

                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity</label>
                        <input type="number"
                               id="quantity"
                               name="quantity"
                               value="1"
                               min="1"
                               max="{{ $firstDetail->stock ?? 1 }}"
                               class="form-control"
                               style="width:120px;">
                    </div>

                    <button type="submit" id="addToCartBtn" class="btn btn-outline-success btn-lg"
                            {{ ($firstDetail->stock ?? 0) <= 0 ? 'disabled' : '' }}>
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

    {{-- Description --}}
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

    const select = document.getElementById('productDetailSelect');
    const priceText = document.getElementById('productPrice');
    const stockText = document.getElementById('productStock');
    const quantityInput = document.getElementById('quantity');
    const addToCartBtn = document.getElementById('addToCartBtn');

    if (select) {
        select.addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];

            const price = Number(selectedOption.dataset.price || 0);
            const stock = Number(selectedOption.dataset.stock || 0);

            priceText.textContent = new Intl.NumberFormat('vi-VN').format(price) + ' đ';
            stockText.textContent = stock;

            quantityInput.max = stock;
            quantityInput.value = stock > 0 ? 1 : 0;

            addToCartBtn.disabled = stock <= 0;
        });
    }
</script>
@endsection