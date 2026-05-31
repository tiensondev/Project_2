@extends('admin.layouts.app')

@section('title', 'Edit Order #' . $order->id)

@section('content')
<div class="container-fluid">

    {{-- ALERT MESSAGE --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            Edit Order #{{ $order->id }}
        </h1>
    </div>

    <div class="row">
        <div class="col-md-12">

            <div class="card shadow mb-4">

                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Order Information
                    </h6>
                </div>

                <div class="card-body">

                    <form action="{{ route('admin.orders.update', $order->id) }}"
                        method="POST">

                        @csrf
                        @method('PUT')

                        {{-- Customer ID --}}
                        <div class="mb-3">
                            <label class="form-label">
                                Customer ID
                            </label>

                            <input type="text"
                                class="form-control"
                                value="{{ $order->user_id }}"
                                disabled>
                        </div>

                        {{-- Total --}}
                        <div class="mb-3">
                            <label class="form-label">
                                Total Amount
                            </label>

                            <input type="text"
                                class="form-control"
                                value="{{ number_format($order->total, 0, ',', '.') }} đ"
                                disabled>
                        </div>

                        {{-- Status --}}
                        <div class="mb-4">

                            <label class="form-label">
                                Order Status
                            </label>

                            <select name="status" class="form-select">

                                <option value="{{ \App\Models\Order::STATUS_PENDING }}"
                                    {{ $order->status == \App\Models\Order::STATUS_PENDING ? 'selected' : '' }}>
                                    Pending
                                </option>

                                <option value="{{ \App\Models\Order::STATUS_PROCESSING }}"
                                    {{ $order->status == \App\Models\Order::STATUS_PROCESSING ? 'selected' : '' }}>
                                    Processing
                                </option>

                                <option value="{{ \App\Models\Order::STATUS_COMPLETED }}"
                                    {{ $order->status == \App\Models\Order::STATUS_COMPLETED ? 'selected' : '' }}>
                                    Completed
                                </option>

                                <option value="{{ \App\Models\Order::STATUS_CANCEL }}"
                                    {{ $order->status == \App\Models\Order::STATUS_CANCEL ? 'selected' : '' }}>
                                    Cancelled
                                </option>

                            </select>

                        </div>

                        {{-- Buttons --}}
                        <div class="d-flex gap-2">

                            <button type="submit"
                                class="btn btn-success">
                                Update Status
                            </button>

                            <a href="{{ route('admin.orders.index') }}"
                                class="btn btn-secondary border">
                                Cancel
                            </a>

                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>

</div>
@endsection