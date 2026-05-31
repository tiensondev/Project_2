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

<div class="container">

    <!-- Banner -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div id="carouselExample" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="https://laptop88.vn/media/banner/747x350Macbook.jpg" class="d-block w-100" alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="https://laptop88.vn/media/banner/747x350-ASUS-VIVOBOOK.jpg" class="d-block w-100" alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="https://laptop88.vn/media/banner/PMAX-Victus16_747x3503.jpg" class="d-block w-100" alt="...">
                    </div>
                    <div
                        class="carousel-item">
                        <img src="https://laptop88.vn/media/banner/747x350-Mn-hnh-my-tnh.jpg" class="d-block w-100" alt="...">
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Categories -->
    <h3 class="mb-3">Laptop Categories</h3>

    <div class="row mb-5">
        @forelse($categories as $category)
        <div class="col-md-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h5>{{ $category->name }}</h5>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <p class="text-center">No categories available</p>
        </div>
        @endforelse
    </div>


    <!-- Products -->
    <h3 class="mb-3">Laptops</h3>

    <div class="row g-4">
        @forelse($latestProducts as $product)
        <div class="col-6 col-md-4 col-lg-3 d-flex">
            <div class="card w-100 shadow-sm d-flex flex-column">
                @if(!empty($product->image) && is_array($product->image) && count($product->image) > 0)
                <div class="product-img-wrapper">
                    <img src="{{ asset('uploads/' . $product->image[0]) }}" alt="{{ $product->name }}" class="img-fluid">
                </div>
                @else
                <div class="product-img-wrapper">
                    <img src="https://via.placeholder.com/358x358" alt="{{ $product->name }}" class="img-fluid">
                </div>
                @endif

                <div class="card-body text-center d-flex flex-column mt-auto">
                    <h6 class="card-title-custom fw-bold">{{ $product->name }}</h6>
                    <p class="text-danger fw-bold mb-1">{{ number_format($product->price, 0) }} đ</p>
                    <p class="text-muted small mb-1">Stock: {{ $product->stock }}</p>
                    <p class="text-muted small mb-3">{{ $product->category->name ?? 'N/A' }}</p>
                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary btn-sm mt-auto w-100">
                        View Details
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <p class="text-muted">No products available</p>
        </div>
        @endforelse
    </div>
</div>

@endsection