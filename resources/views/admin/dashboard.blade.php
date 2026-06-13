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
                            <h3 class="fw-bold mb-0">{{ $totalBrands }}</h3>
                            <p class="mb-0">Brands</p>
                        </div>
                        <i class="bi bi-tag fs-2 opacity-25"></i>
                    </div>
                </div>
                <a href="{{ route('admin.brands.index') }}"
                    class="card-footer bg-dark bg-opacity-10 text-white text-decoration-none text-center border-0 py-2">
                    Manage Brands <i class="bi bi-arrow-right-short"></i>
                </a>
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
        <div class="row mt-4">
            {{-- Monthly Chart --}}
            <div class="col-lg-6 mb-4 mb-lg-0">
                <div class="card border-0 shadow-sm rounded-3 h-100">
                    <div class="card-header bg-white py-3 border-bottom-0">
                        <h5 class="fw-bold mb-0 text-dark">Revenue Monthly</h5>
                    </div>
                    <div class="card-body">
                        @include('admin.charts.monthly-chart')
                    </div>
                </div>
            </div>

            {{-- Weekly Chart --}}
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm rounded-3 h-100">
                    <div class="card-header bg-white py-3 border-bottom-0">
                        <h5 class="fw-bold mb-0 text-dark">Revenue Weekly</h5>
                    </div>
                    <div class="card-body">
                        @include('admin.charts.weekly-chart')
                    </div>
                </div>
            </div>
        </div>

    </div>
    @endsection