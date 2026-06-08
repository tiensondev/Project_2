@extends('admin.layouts.app')

@section('title', 'Edit Product Detail')

@section('content')
<div class="container-fluid mt-4">
    <div class="card shadow-sm">

        <div class="card-header bg-white py-3">
            <h3 class="card-title mb-0 fw-bold">
                Edit Product Detail
            </h3>
        </div>

        <div class="card-body">

            @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST"
                action="{{ route('admin.product-details.update', $productDetail->id) }}">

                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Product *</label>

                    <select name="product_id"
                        class="form-select @error('product_id') is-invalid @enderror"
                        required>

                        <option value="">Select Product</option>

                        @foreach($products as $product)
                        <option value="{{ $product->id }}"
                            {{ old('product_id', $productDetail->product_id) == $product->id ? 'selected' : '' }}>
                            {{ $product->name }}
                        </option>
                        @endforeach

                    </select>

                    @error('product_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="row">

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">CPU</label>

                            <input type="text"
                                name="cpu"
                                class="form-control"
                                value="{{ old('cpu', $productDetail->cpu) }}">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">RAM</label>

                            <input type="text"
                                name="ram"
                                class="form-control"
                                value="{{ old('ram', $productDetail->ram) }}">
                        </div>
                    </div>

                </div>

                <div class="row">

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Storage</label>

                            <input type="text"
                                name="storage"
                                class="form-control"
                                value="{{ old('storage', $productDetail->storage) }}">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">GPU</label>

                            <input type="text"
                                name="gpu"
                                class="form-control"
                                value="{{ old('gpu', $productDetail->gpu) }}">
                        </div>
                    </div>

                </div>

                <div class="row">

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Screen</label>

                            <input type="text"
                                name="screen"
                                class="form-control"
                                value="{{ old('screen', $productDetail->screen) }}">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Color</label>

                            <input type="text"
                                name="color"
                                class="form-control"
                                value="{{ old('color', $productDetail->color) }}">
                        </div>
                    </div>

                </div>

                <div class="row">

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Price *</label>

                            <input type="number"
                                name="price"
                                class="form-control @error('price') is-invalid @enderror"
                                value="{{ old('price', $productDetail->price) }}"
                                required>

                            @error('price')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Stock *</label>

                            <input type="number"
                                name="stock"
                                class="form-control @error('stock') is-invalid @enderror"
                                value="{{ old('stock', $productDetail->stock) }}"
                                required>

                            @error('stock')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>

                </div>

                <div class="d-flex gap-2">
                    <button type="submit"
                        class="btn btn-success px-4">
                        Update Product Detail
                    </button>

                    <a href="{{ route('admin.product-details.index') }}"
                        class="btn btn-secondary px-4">
                        Cancel
                    </a>
                </div>

            </form>

        </div>
    </div>
</div>
@endsection