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

    .hot-product-banner {
        overflow: hidden;
        border-radius: 8px;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .hot-product-banner:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }

    .hot-product-banner img {
        width: 100%;
        height: auto;
        display: block;
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
    <h3 class="mb-4 fw-bold text-uppercase position-relative pb-2" style="border-bottom: 2px solid #dc3545; width: fit-content;">
        CATEGORIES
    </h3>

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
    <h3 class="mb-4 fw-bold text-uppercase position-relative pb-2" style="border-bottom: 2px solid #dc3545; width: fit-content;">
        LAPTOPS
    </h3>

    <div class="row g-4">
        @forelse($allProducts as $product)
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
                    <p class="text-danger fw-bold mb-1">
                        @if($product->details->count() > 0)
                            From {{ number_format($product->details->min('price'), 0, ',', '.') }} đ
                        @else
                        {{ number_format($product->price, 0, ',', '.') }} đ
                        @endif
                    </p>
                    <p class="text-muted small mb-1">Stock: {{ $product->details->sum('stock') }}</p>
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

        <hr class="my-5 text-muted">

        <div class="mb-5">
            <h3 class="mb-4 fw-bold text-uppercase position-relative pb-2" style="border-bottom: 2px solid #dc3545; width: fit-content;">
                SẢN PHẨM HOT
            </h3>

            <div class="row g-3">
                <div class="col-6 col-md-3">
                    <a href="{{ route('products.show', $product->id = 9) }}" class="d-block hot-product-banner">
                        <img src="{{ asset('/storage/295x380LenovoIdeapadSlim32-moi-nhat.jpg') }}" alt="Lenovo Ideapad">
                    </a>
                </div>

                <div class="col-6 col-md-3">
                    <a href="#" class="d-block hot-product-banner">
                        <img src="{{ asset('storage/295x380MacbookM5.jpg') }}" alt="Macbook M5">
                    </a>
                </div>

                <div class="col-6 col-md-3">
                    <a href="#" class="d-block hot-product-banner">
                        <img src="{{ asset('/storage/295x380HPVICTUS15_bannernew.jpg') }}" alt="HP Victus 15">
                    </a>
                </div>

                <div class="col-6 col-md-3">
                    <a href="#" class="d-block hot-product-banner">
                        <img src="{{ asset('/storage/295x380BannerDell152025.jpg') }}" alt="Dell 15 2025">
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection