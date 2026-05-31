@extends('admin.layouts.app')

@section('title', 'Product Details')

@section('content')
<h1>Product Details</h1>

<div class="card mb-4">
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th>ID</th>
                <td>{{ $product->id }}</td>
            </tr>
            <tr>
                <th>Image</th>
                <td>
                    @if(!empty($product->image) && is_array($product->image) && isset($product->image[0]))
                    <img src="{{ asset('uploads/' . $product->image[0]) }}" alt="{{ $product->name }}" style="width: 70px; height: 70px; object-fit: cover; border-radius: 5px;">
                    @else
                    <img src="{{ asset('uploads/default-placeholder.png') }}" alt="No image" style="width: 70px; height: 70px; object-fit: cover;">
                    @endif
                </td>
            </tr>
            <tr>
                <th>Name</th>
                <td>{{ $product->name }}</td>
            </tr>
            <tr>
                <th>Price</th>
                <td>{{ number_format($product->price, 2) }}</td>
            </tr>
            <tr>
                <th>Stock</th>
                <td>{{ $product->stock }}</td>
            </tr>
            <tr>
                <th>Category ID</th>
                <td>{{ $product->category_id }}</td>
            </tr>
            <tr>
                <th>Description</th>
                <td>{{ $product->description }}</td>
            </tr>
            <tr>
                <th></th>
            </tr>
            <tr>
                <th>Updated at</th>
                <td>{{ $product->updated_at }}</td>
            </tr>
        </table>
        <br>
        <a href="{{ route('admin.products.list') }}" class="btn btn-secondary">Back</a>
        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-warning">Edit</a>
    </div>
</div>
@endsection