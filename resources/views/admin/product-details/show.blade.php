@extends('admin.layouts.app')

@section('title', 'Product Detail')

@section('content')
<div class="container-fluid mt-4">
    <div class="card shadow-sm">

        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0 fw-bold">Product Detail</h3>
        </div>

        <div class="card-body">
            <table class="table table-bordered align-middle">
                <tr>
                    <th style="width: 220px;">ID</th>
                    <td>#{{ $productDetail->id }}</td>
                </tr>

                <tr>
                    <th>Product</th>
                    <td>{{ $productDetail->product->name ?? 'N/A' }}</td>
                </tr>

                <tr>
                    <th>CPU</th>
                    <td>{{ $productDetail->cpu ?? 'N/A' }}</td>
                </tr>

                <tr>
                    <th>RAM</th>
                    <td>{{ $productDetail->ram ?? 'N/A' }}</td>
                </tr>

                <tr>
                    <th>Storage</th>
                    <td>{{ $productDetail->storage ?? 'N/A' }}</td>
                </tr>

                <tr>
                    <th>GPU</th>
                    <td>{{ $productDetail->gpu ?? 'N/A' }}</td>
                </tr>

                <tr>
                    <th>Screen</th>
                    <td>{{ $productDetail->screen ?? 'N/A' }}</td>
                </tr>

                <tr>
                    <th>Color</th>
                    <td>{{ $productDetail->color ?? 'N/A' }}</td>
                </tr>

                <tr>
                    <th>Price</th>
                    <td class="text-danger fw-bold">
                        {{ number_format($productDetail->price, 0, ',', '.') }} đ
                    </td>
                </tr>

                <tr>
                    <th>Stock</th>
                    <td>
                        @if($productDetail->stock <= 5)
                            <span class="badge bg-warning text-dark">
                            Only {{ $productDetail->stock }} left
                            </span>
                            @else
                            <span class="badge bg-info">
                                {{ $productDetail->stock }}
                            </span>
                            @endif
                    </td>
                </tr>
            </table>

            <div class="d-flex gap-2 mt-3">
                <a href="{{ route('admin.product-details.index') }}" class="btn btn-secondary">
                    Back
                </a>
                <a href="{{ route('admin.product-details.edit', $productDetail->id) }}" class="btn btn-warning text-white">
                    Edit
                </a>
            </div>
        </div>
    </div>
</div>
@endsection