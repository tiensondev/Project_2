@extends('admin.layouts.app')

@section('title', 'Order Details #' . $order->id)

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Order Details #{{ $order->id }}</h1>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Customer Information</h6>
                </div>
                <div class="card-body">
                    <p><strong>Name:</strong> {{ $order->customer_name }}</p>
                    <p><strong>Status:</strong> {!! $order->status_badge !!}</p>
                    <p><strong>Order Date:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>

                    <p><strong>Shipping Address: </strong>
                        @php
                        $fullAddress = implode(', ', array_filter([
                        $order->address_detail,
                        $order->ward,
                        $order->district,
                        $order->province
                        ]));
                        @endphp
                        <span class="text-truncate d-inline-block" style="max-width: 700px;" title="{{ $fullAddress }}">
                            {{ !empty($fullAddress) ? $fullAddress : 'No address provided' }}
                        </span>
                    </p>


                    <p>
                        <strong>Contact (Email):</strong><br>
                        {{ $order->user->email ?? 'N/A' }}
                    </p>

                    <hr>
                    <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-bold">Update Status</label>
                            <select name="status" class="form-select" {{ $order->status == App\Models\Order::STATUS_CANCEL ? 'disabled' : '' }}>
                                <option value="{{ App\Models\Order::STATUS_PENDING }}" {{ $order->status == App\Models\Order::STATUS_PENDING ? 'selected' : '' }}>Pending</option>
                                <option value="{{ App\Models\Order::STATUS_PROCESSING }}" {{ $order->status == App\Models\Order::STATUS_PROCESSING ? 'selected' : '' }}>Processing</option>
                                <option value="{{ App\Models\Order::STATUS_COMPLETED }}" {{ $order->status == App\Models\Order::STATUS_COMPLETED ? 'selected' : '' }}>Completed</option>
                                <option value="{{ App\Models\Order::STATUS_CANCEL }}" {{ $order->status == App\Models\Order::STATUS_CANCEL ? 'selected' : '' }}>Cancel</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary w-100" {{ $order->status == App\Models\Order::STATUS_CANCEL ? 'disabled' : '' }}>
                            Update Status
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Order Items</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-3">Product Name</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th class="text-end pe-3">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($order->orderDetails) && $order->orderDetails->count() > 0)
                                @foreach($order->orderDetails as $detail)
                                <tr>
                                    <td class="ps-3">
                                        <strong>{{ $detail->product->name ?? 'Product Deleted' }}</strong>
                                    </td>
                                    <td>{{ number_format($detail->price, 0, ',', '.') }} đ</td>
                                    <td>x {{ $detail->quantity }}</td>
                                    <td class="text-end pe-3 fw-bold text-primary">
                                        {{ number_format($detail->price * $detail->quantity, 0, ',', '.') }} đ
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="4" class="text-center py-3 text-muted">No items found in this order.</td>
                                </tr>
                                @endif
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <td colspan="3" class="text-end fw-bold">Grand Total:</td>
                                    <td class="text-end pe-3 fw-bold text-danger h5">
                                        {{ number_format($order->total, 0, ',', '.') }} đ
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection