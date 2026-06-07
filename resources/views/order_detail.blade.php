@extends('web-layouts.app')

@section('title', 'Order Details #' . $order->id)

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-9">

            <div class="card shadow border-0 overflow-hidden mb-4" style="border-radius: 8px;">
                <div class="card-header bg-primary text-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">Order Details #{{ $order->id }}</h5>
                    <a href="{{ route('orders.index') }}" class="btn btn-light btn-sm fw-bold text-primary px-3" style="border-radius: 4px;">
                        <i class="fas fa-arrow-left me-1"></i> Back to List
                    </a>
                </div>

                <div class="card-body">
                    <div class="row mb-4 pt-2">
                        <div class="col-md-6 border-end mb-3 mb-md-0">
                            <h6 class="fw-bold text-primary mb-3"><i class="fas fa-map-marker-alt me-2"></i>Shipping Info</h6>
                            <p class="mb-2 text-dark"><strong>Recipient Name:</strong> {{ $order->user->name }}</p>
                            <p class="mb-2 text-dark"><strong>Phone Number:</strong> {{ $order->user->phone }}</p>
                            <p class="mb-0 text-muted small" style="line-height: 1.5;">
                                <strong>Address:</strong> {{ $order->address_detail }}, {{ $order->ward }}, {{ $order->district }}, {{ $order->province }}
                            </p>
                        </div>
                        <div class="col-md-6 ps-md-4">
                            <h6 class="fw-bold text-primary mb-3"><i class="fas fa-info-circle me-2"></i>Order Summary</h6>
                            <p class="mb-2 text-dark"><strong>Order Date:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                            <p class="mb-2 text-dark"><strong>Payment Method:</strong> Cash on Delivery (COD)</p>
                            <p class="mb-0 text-dark">
                                <strong>Status:</strong>
                                @if($order->status == 1 || $order->status == 'pending')
                                <span class="badge bg-warning text-dark ms-1">Pending</span>
                                @elseif($order->status == 2 || $order->status == 'processing')
                                <span class="badge bg-info text-dark ms-1">Processing</span>
                                @elseif($order->status == 3 || $order->status == 'completed')
                                <span class="badge bg-success ms-1">Completed</span>
                                @else
                                <span class="badge bg-danger ms-1">Cancelled</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    <hr class="text-muted opacity-25 my-4">

                    <h6 class="fw-bold text-primary mb-3"><i class="fas fa-box me-2"></i>Order Items</h6>
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead class="table-light text-secondary small text-uppercase">
                                <tr>
                                    <th class="py-2">Product</th>
                                    <th class="text-center py-2">Price</th>
                                    <th class="text-center py-2">Quantity</th>
                                    <th class="text-end pe-3 py-2">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->orderDetails as $detail)
                                <tr style="border-bottom: 1px solid #f9f9f9;">
                                    <td>
                                        <div class="d-flex align-items-center py-1">
                                            @if($detail->product)
                                            @php
                                            $imgSrc = $detail->product->image;
                                            if (is_array($imgSrc)) {
                                            $imgSrc = $imgSrc[0] ?? null;
                                            } elseif (is_string($imgSrc) && str_starts_with($imgSrc, '[')) {
                                            $decoded = json_decode($imgSrc, true);
                                            $imgSrc = $decoded[0] ?? null;
                                            }
                                            @endphp

                                            @if(!empty($imgSrc))
                                            <img src="{{ asset('uploads/' . $imgSrc) }}" alt="{{ $detail->product->name }}" style="width: 60px; height: 60px; object-fit: cover; border-radius: 5px;" class="me-3 border">
                                            @else
                                            <div class="bg-light border rounded d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px;">
                                                <i class="fas fa-image text-muted"></i>
                                            </div>
                                            @endif
                                            @else
                                            <div class="bg-light border rounded d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px;">
                                                <i class="fas fa-exclamation-triangle text-muted"></i>
                                            </div>
                                            @endif

                                            <div>
                                                <span class="fw-bold text-dark d-block mb-0">{{ $detail->product->name ?? 'Product Deleted' }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center text-muted">{{ number_format($detail->price, 0, ',', '.') }}đ</td>
                                    <td class="text-center text-dark">x{{ $detail->quantity }}</td>
                                    <td class="text-end fw-bold text-dark pe-3">{{ number_format($detail->price * $detail->quantity, 0, ',', '.') }}đ</td>
                                </tr>
                                @endforeach

                                <tr>
                                    <td colspan="3" class="text-end fw-bold text-secondary border-0 pt-4 fs-6">Total Amount:</td>
                                    <td class="text-end fw-bold text-danger border-0 pt-4 fs-5 pe-3">
                                        {{ number_format($order->total, 0, ',', '.') }}đ
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection