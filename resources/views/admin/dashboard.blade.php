@extends('admin.layouts.app')

@section('title', 'Admin Dashboard')

@section('breadcrumb')
<li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
<div class="container-fluid">

    <div class="row g-4">
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm bg-primary text-white h-100 rounded-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h3 class="fw-bold mb-0">{{ $totalOrders }}</h3>
                            <p class="mb-0">Total Orders</p>
                        </div>
                        <i class="bi bi-cart-fill fs-2 opacity-25"></i>
                    </div>
                </div>
                <a href="{{ route('admin.orders.index') }}"
                    class="card-footer bg-dark bg-opacity-10 text-white text-decoration-none text-center border-0 py-2">
                    Manage Orders <i class="bi bi-arrow-right-short"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm bg-success text-white h-100 rounded-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h3 class="fw-bold mb-0">{{ $totalProducts }}</h3>
                            <p class="mb-0">Products</p>
                        </div>
                        <i class="bi bi-box-seam-fill fs-2 opacity-25"></i>
                    </div>
                </div>
                <a href="{{ route('admin.products.list') }}"
                    class="card-footer bg-dark bg-opacity-10 text-white text-decoration-none text-center border-0 py-2">
                    Manage Products <i class="bi bi-arrow-right-short"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm bg-warning text-dark h-100 rounded-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h3 class="fw-bold mb-0">{{ $totalUsers }}</h3>
                            <p class="mb-0">Customers</p>
                        </div>
                        <i class="bi bi-people-fill fs-2 opacity-25"></i>
                    </div>
                </div>
                <a href="{{ route('admin.users.index') }}"
                    class="card-footer bg-dark bg-opacity-10 text-dark text-decoration-none text-center border-0 py-2">
                    Manage Users <i class="bi bi-arrow-right-short"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm bg-danger text-white h-100 rounded-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h3 class="fw-bold mb-0">{{ $totalCategories }}</h3>
                            <p class="mb-0">Categories</p>
                        </div>
                        <i class="bi bi-list-stars fs-2 opacity-25"></i>
                    </div>
                </div>
                <a href="{{ route('admin.categories.list') }}"
                    class="card-footer bg-dark bg-opacity-10 text-white text-decoration-none text-center border-0 py-2">
                    Manage Categories <i class="bi bi-arrow-right-short"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm bg-info text-white h-100 rounded-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h3 class="fw-bold mb-0">{{ $todayOrders }}</h3>
                            <p class="mb-0">Today's Orders</p>
                        </div>
                        <i class="bi bi-list-stars fs-2 opacity-25"></i>
                    </div>
                </div>            
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm bg-secondary text-white h-100 rounded-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h3 class="fw-bold mb-0">{{ number_format($todayRevenue, 0, ',', '.') }} đ</h3>
                            <p class="mb-0">Today's Revenue</p>
                        </div>
                        <i class="bi bi-currency-dollar fs-2 opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm bg-dark text-white h-100 rounded-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h3 class="fw-bold mb-0">{{ $pendingOrders }}</h3>
                            <p class="mb-0">Pending Orders</p>
                        </div>
                        <i class="bi bi-clock fs-2 opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm bg-light text-dark h-100 rounded-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h3 class="fw-bold mb-0">{{ $completedOrders }}</h3>
                            <p class="mb-0">Completed Orders</p>
                        </div>
                        <i class="bi bi-check2-circle fs-2 opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Chart --}}

    <div class="card mt-4 border-0 shadow-sm rounded-3">

    <div class="card-header bg-white">
        <h5 class="fw-bold mb-0">Revenue Monthly</h5>
    </div>

    <div class="card-body">

        @include('admin.charts.monthly-chart')

    </div>

    {{-- Chart --}}
    <div class="card mt-4 border-0 shadow-sm rounded-3">
        <div class="card-header bg-white">
            <h5 class="fw-bold mb-0">Revenue Weekly</h5>
        </div>
        <div class="card-body">
            @include('admin.charts.weekly-chart')
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="row mt-5">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white py-3 border-bottom-0">
                    <h5 class="mb-0 fw-bold">Quick Actions</h5>
                </div>

                <div class="card-body p-4">
                    <div class="d-flex gap-3">
                        <a href="{{ route('admin.products.create') }}"
                            class="btn btn-primary px-4 py-2">
                            <i class="bi bi-plus-circle me-2"></i>Add Product
                        </a>

                        <a href="{{ route('admin.categories.create') }}"
                            class="btn btn-success px-4 py-2">
                            <i class="bi bi-folder-plus me-2"></i>Add Category
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection