@extends('admin.layouts.app')

@section('title', 'Orders Management')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Orders List</h1>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('admin.orders.search') }}" method="GET" class="row g-3 shadow-sm p-3 mb-4 bg-white rounded">
                <div class="col-md-2">
                    <label class="form-label">Order ID</label>
                    <input type="text" name="id" class="form-control" value="{{ request('id') }}" placeholder="Order ID">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Customer Name</label>
                    <input type="text" name="customer_name" class="form-control" value="{{ request('customer_name') }}" placeholder="Customer name">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" class="form-control" value="{{ request('phone') }}" placeholder="Phone">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Pending</option>
                        <option value="2" {{ request('status') === '2' ? 'selected' : '' }}>Processing</option>
                        <option value="3" {{ request('status') === '3' ? 'selected' : '' }}>Completed</option>
                        <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">From Date</label>
                    <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
                </div>

                <div class="col-md-4">
                    <label class="form-label">To Date</label>
                    <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
                </div>

                <div class="col-md-4 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Search
                    </button>

                    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
                        Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Recent Orders</h6>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3" style="width: 80px">ID</th>
                            <th>Customer Name</th>
                            <th>Phone</th>
                            <th>Shipping Address</th>
                            <th>Status</th>
                            <th>Total Order</th>
                            <th>Order Date</th>
                            <th class="text-center" style="width: 200px">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($orders as $order)
                        <tr>
                            <td class="ps-3 fw-bold">#{{ $order->id }}</td>

                            <td>
                                <strong>{{ $order->customer_name }}</strong>
                            </td>

                            <td class="fw-bold text-secondary">
                                {{ $order->phone ?? 'N/A' }}
                            </td>

                            <td>
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
                            </td>

                            <td>{!! $order->status_badge !!}</td>

                            <td class="fw-bold text-danger">
                                {{ number_format($order->total, 0, ',', '.') }} đ
                            </td>

                            <td class="text-muted">
                                {{ $order->created_at->format('d/m/Y H:i') }}
                            </td>

                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('admin.orders.show', $order->id) }}"
                                       class="btn btn-info btn-sm text-white">
                                        <i class="fas fa-eye"></i> View
                                    </a>

                                    <form action="{{ route('admin.orders.destroy', $order->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Are you sure you want to delete this order?');">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="fas fa-box-open fa-3x mb-3 d-block"></i>
                                No orders found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if(isset($orders) && method_exists($orders, 'links') && $orders->total() > 0)
        <div class="card-footer bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted small">
                    Showing {{ $orders->firstItem() }} to {{ $orders->lastItem() }} of {{ $orders->total() }} results
                </div>

                <div>
                    {{ $orders->appends(request()->query())->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection