@extends ('web-layouts.app')

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

<div class="container py-4">
    <h3 class="mb-4">Search Results for "{{ request('query') }}"</h3>

    @if($products->isEmpty())
        <div class="alert alert-info">No products found matching your search.</div>
    @else
        <div class="row g-4"> @foreach($products as $product)
                @php
                    $images = is_array($product->image) ? $product->image : json_decode($product->image, true);
                @endphp
                
                <div class="col-md-3 col-sm-6 d-flex align-items-stretch mb-4"> <div class="card shadow-sm h-100 w-100 d-flex flex-column">

                        <div class="product-img-wrapper">
                            @if(!empty($images) && count($images) > 0)
                                <img src="{{ asset('uploads/' . $images[0]) }}" alt="{{ $product->name }}" class="img-fluid">
                            @else
                                <img src="https://via.placeholder.com/358x358" alt="{{ $product->name }}" class="img-fluid">
                            @endif
                        </div>

                        <div class="card-body text-center d-flex flex-column">
                            <h6 class="card-title-custom fw-bold mb-2">{{ $product->name }}</h6>
                            <p class="text-danger fw-bold mb-1">{{ number_format($product->price, 0, ',', '.') }} đ</p>
                            <p class="text-muted small mb-1">Stock: {{ $product->stock }}</p>
                            <p class="text-muted small mb-3">{{ $product->category->name ?? 'N/A' }}</p>

                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary btn-sm mt-auto w-100">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div> <div class="d-flex justify-content-center mt-4">
            {{ $products->appends(['query' => request('query')])->links() }}
        </div>
    @endif
</div>
@endsection