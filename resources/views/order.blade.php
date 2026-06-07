@extends('web-layouts.app')

@section('title', 'My Orders')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-9">

            <div class="card shadow border-0 overflow-hidden" style="border-radius: 8px;">
                {{-- Header đồng bộ --}}
                <div class="card-header bg-primary text-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-shopping-bag me-2"></i> My Order History</h5>
                </div>

                <div class="card-body p-0">
                    @if($orders->isEmpty())
                    <div class="text-center py-5 text-muted">
                        <i class="fas fa-box-open fa-3x mb-3 text-secondary"></i>
                        <p class="mb-0">You have no orders yet.</p>
                    </div>
                    @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light text-secondary small text-uppercase">
                                <tr>
                                    <th class="py-3" width="15%">Order ID</th>
                                    <th class="py-3">Date</th>
                                    <th class="py-3">Total Amount</th>
                                    <th class="py-3">Status</th>
                                    <th class="text-center pe-4 py-3">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                <tr style="border-bottom: 1px solid #f2f2f2;">
                                    <td class="ps-4 fw-bold text-secondary">
                                        {{ ($orders->currentPage() - 1) * $orders->perPage() + $loop->iteration }}
                                    </td>

                                    <td class="text-muted small">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="fw-bold text-danger">{{ number_format($order->total, 0, ',', '.') }}đ</td>

                                    <td>
                                        @if($order->status == '1')
                                        <span class="badge bg-warning text-dark px-2 py-1 small">Pending</span>
                                        @elseif($order->status == '2')
                                        <span class="badge bg-info text-white px-2 py-1 small">Processing</span>
                                        @elseif($order->status == '3')
                                        <span class="badge bg-success px-2 py-1 small">Completed</span>
                                        @else($order->status == '0')
                                        <span class="badge bg-danger px-2 py-1 small">Cancelled</span>
                                        @endif
                                    </td>

                                    <td class="text-center pe-4">
                                        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-primary btn-sm fw-bold px-3" style="border-radius: 4px;">
                                            View Details
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if($orders->hasPages())
                    <div class="card-footer bg-white border-0 py-3 d-flex justify-content-end">
                        {{ $orders->links('pagination::bootstrap-5') }}
                    </div>
                    @endif
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>
@endsection