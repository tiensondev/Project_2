@extends('admin.layouts.app')

@section('title', 'Create Product Detail')

@section('content')
<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Create Product Detail</h1>
    </div>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center bg-white py-3">
            <h5 class="mb-0">Add New Product Detail</h5>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.product-details.store') }}" method="POST">
                @csrf

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="product_id" class="form-label">Product *</label>
                        <select name="product_id" id="product_id"
                            class="form-select @error('product_id') is-invalid @enderror" required>
                            <option value="">Select Product</option>

                            @foreach($products as $product)
                            <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                {{ $product->name }}
                            </option>
                            @endforeach
                        </select>

                        @error('product_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="cpu" class="form-label">CPU</label>
                        <input type="text" name="cpu"
                            class="form-control @error('cpu') is-invalid @enderror"
                            id="cpu" value="{{ old('cpu') }}"
                            placeholder="Example: Intel Core i5-1240P">

                        @error('cpu')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="ram" class="form-label">RAM</label>
                        <input type="text" name="ram"
                            class="form-control @error('ram') is-invalid @enderror"
                            id="ram" value="{{ old('ram') }}"
                            placeholder="Example: 8GB DDR4">

                        @error('ram')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="storage" class="form-label">Storage</label>
                        <input type="text" name="storage"
                            class="form-control @error('storage') is-invalid @enderror"
                            id="storage" value="{{ old('storage') }}"
                            placeholder="Example: 512GB SSD">

                        @error('storage')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="gpu" class="form-label">GPU</label>
                        <input type="text" name="gpu"
                            class="form-control @error('gpu') is-invalid @enderror"
                            id="gpu" value="{{ old('gpu') }}"
                            placeholder="Example: Intel Iris Xe">

                        @error('gpu')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="screen" class="form-label">Screen</label>
                        <input type="text" name="screen"
                            class="form-control @error('screen') is-invalid @enderror"
                            id="screen" value="{{ old('screen') }}"
                            placeholder="Example: 14 inch FHD">

                        @error('screen')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="color" class="form-label">Color</label>
                        <input type="text" name="color"
                            class="form-control @error('color') is-invalid @enderror"
                            id="color" value="{{ old('color') }}"
                            placeholder="Example: Silver">

                        @error('color')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label for="price" class="form-label">Price *</label>
                        <input type="number" name="price"
                            class="form-control @error('price') is-invalid @enderror"
                            id="price" value="{{ old('price') }}"
                            step="0.01" required>

                        @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label for="stock" class="form-label">Stock *</label>
                        <input type="number" name="stock"
                            class="form-control @error('stock') is-invalid @enderror"
                            id="stock" value="{{ old('stock') }}"
                            required>

                        @error('stock')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success px-4">
                        Create Product Detail
                    </button>

                    <a href="{{ route('admin.product-details.index') }}" class="btn btn-secondary px-4">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection