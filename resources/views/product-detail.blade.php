@extends('web-layouts.app')

@section('title', $product->name)

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
<div class="container pt-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent p-0 m-0 align-items-center" style="font-size: 0.95rem;">
            {{-- Trang chủ --}}
            <li class="breadcrumb-item">
                <a href="{{ route('products.index') }}" class="text-decoration-none text-dark">Trang chủ</a>
            </li>

            <li class="breadcrumb-item">
                <a href="{{ route('category.show', $product->category->id) }}" class="text-decoration-none text-dark">
                    {{ $product->category->name }}
                </a>
            </li>

            {{-- Tên sản phẩm hiện tại (Active - Không bấm được) --}}
            <li class="breadcrumb-item active text-dark text-truncate" aria-current="page" style="max-width: 500px;">
                {{ $product->name }}
            </li>
        </ol>
    </nav>
</div>
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
                <strong>Brand:</strong> {{ $product->brand->name ?? 'N/A' }}
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
        <div class="col-md-6 mb-4">
            <table class="table table-bordered align-middle">
                <tbody>
                    <tr class="table-light">
                        <th colspan="2" class="text-uppercase fw-bold">Specifications</th>
                    </tr>
                    @if($product->details->count() > 0)
                    @php
                    $firstDetail = $product->details->first();
                    @endphp
                    <tr>
                        <td width="35%" class="fw-semibold">Processor</td>
                        <td id="specCpu">{{ $firstDetail->cpu }}</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold">Graphics (GPU)</td>
                        <td id="specGpu">{{ $firstDetail->gpu }}</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold">RAM</td>
                        <td id="specRam">{{ $firstDetail->ram }}</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold">Storage (ROM)</td>
                        <td id="specStorage">{{ $firstDetail->storage }}</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold">Screen</td>
                        <td id="specScreen">{{ $firstDetail->screen }}</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold">Color</td>
                        <td id="specColor">{{ $firstDetail->color }}</td>
                    </tr>
                    @else
                    <tr>
                        <td colspan="2" class="text-center py-3">No specifications available.</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <div class="col-md-6">
            <h4 class="border-bottom pb-2 fw-bold">Description</h4>
            <p class="text-muted" style="line-height: 1.6; text-align: justify;">
                {!! nl2br(e($product->description ?? 'No description available.')) !!}
            </p>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-12">
            <h4 class="mb-4 fw-bold text-uppercase position-relative pb-2" style="border-bottom: 2px solid #dc3545; width: fit-content;">
                PRODUCTS YOU MAY ALSO LIKE
            </h4>
        </div>

        @if(isset($relatedProducts) && $relatedProducts->count() > 0)
        @foreach($relatedProducts as $related)
        <div class="col-6 col-md-4 col-lg-3 d-flex">
            <div class="card w-100 shadow-sm d-flex flex-column">
                @if(!empty($related->image) && is_array($related->image) && count($related->image) > 0)
                <div class="product-img-wrapper">
                    <img src="{{ asset('uploads/' . $related->image[0]) }}" alt="{{ $related->name }}" class="img-fluid">
                </div>
                @else
                <div class="product-img-wrapper">
                    <img src="https://via.placeholder.com/358x358" alt="{{ $related->name }}" class="img-fluid">
                </div>
                @endif

                <div class="card-body text-center d-flex flex-column mt-auto">
                    <h6 class="card-title-custom fw-bold">{{ $related->name }}</h6>
                    <p class="text-danger fw-bold mb-1">
                        @if($related->details->count() > 0)
                        From {{ number_format($related->details->min('price'), 0, ',', '.') }} đ
                        @else
                        {{ number_format($related->price, 0, ',', '.') }} đ
                        @endif
                    </p>
                    <p class="text-muted small mb-1">Stock: {{ $related->details->sum('stock') }}</p>
                    <p class="text-muted small mb-3">{{ $related->category->name ?? 'N/A' }}</p>
                    <a href="{{ route('products.show', $related->id) }}" class="btn btn-primary btn-sm mt-auto w-100">
                        View Details
                    </a>
                </div>
            </div>
        </div>
        @endforeach
        @endif
    </div>
</div>

@if($product->details->count() > 0)
<div id="product-details-data" style="display: none;"
    data-json="{{ json_encode($product->details->keyBy('id')) }}">
</div>
@endif

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

    const specCpu = document.getElementById('specCpu');
    const specGpu = document.getElementById('specGpu');
    const specRam = document.getElementById('specRam');
    const specStorage = document.getElementById('specStorage');
    const specScreen = document.getElementById('specScreen');
    const specColor = document.getElementById('specColor');

    if (select) {
        const dataContainer = document.getElementById('product-details-data');
        const detailsMap = dataContainer ? JSON.parse(dataContainer.dataset.json) : {};

        select.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const detailId = this.value;

            const price = Number(selectedOption.dataset.price || 0);
            const stock = Number(selectedOption.dataset.stock || 0);

            priceText.textContent = new Intl.NumberFormat('vi-VN').format(price) + ' đ';
            stockText.textContent = stock;

            quantityInput.max = stock;
            quantityInput.value = stock > 0 ? 1 : 0;
            addToCartBtn.disabled = stock <= 0;

            if (detailsMap[detailId]) {
                const info = detailsMap[detailId];
                if (specCpu) specCpu.textContent = info.cpu || 'N/A';
                if (specGpu) specGpu.textContent = info.gpu || 'N/A';
                if (specRam) specRam.textContent = info.ram || 'N/A';
                if (specStorage) specStorage.textContent = info.storage || 'N/A';
                if (specScreen) specScreen.textContent = info.screen || 'N/A';
                if (specColor) specColor.textContent = info.color || 'N/A';
            }
        });
    }
</script>
@endsection