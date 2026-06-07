<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductDetail;
use Illuminate\Http\Request;

class ProductDetailController extends Controller
{
    public function index()
    {
        $details = ProductDetail::with('product')->latest()->get();
        $products = Product::all();

        return view(
            'admin.product-details.index',
            compact('details', 'products')
        );
    }

    public function create()
    {
        $products = Product::all();

        return view('admin.product-details.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'cpu' => 'nullable|string|max:255',
            'ram' => 'nullable|string|max:255',
            'storage' => 'nullable|string|max:255',
            'gpu' => 'nullable|string|max:255',
            'screen' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        ProductDetail::create($request->all());

        return redirect()->route('admin.product-details.index')
            ->with('success', 'Product detail created successfully.');
    }

    public function edit(ProductDetail $productDetail)
    {
        $products = Product::all();

        return view('admin.product-details.edit', compact('productDetail', 'products'));
    }

    public function show(ProductDetail $productDetail)
    {
        return view('admin.product-details.show', compact('productDetail'));
    }

    public function update(Request $request, ProductDetail $productDetail)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'cpu' => 'nullable|string|max:255',
            'ram' => 'nullable|string|max:255',
            'storage' => 'nullable|string|max:255',
            'gpu' => 'nullable|string|max:255',
            'screen' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        $productDetail->update($request->all());

        return redirect()->route('admin.product-details.index')
            ->with('success', 'Product detail updated successfully.');
    }

    public function destroy(ProductDetail $productDetail)
    {
        $productDetail->delete();

        return redirect()->route('admin.product-details.index')
            ->with('success', 'Product detail deleted successfully.');
    }

    public function search(Request $request)
    {
        $products = Product::all();

        $details = ProductDetail::with('product')
            ->when($request->filled('product_id'), function ($query) use ($request) {
                $query->where('product_id', $request->product_id);
            })
            ->when($request->filled('cpu'), function ($query) use ($request) {
                $query->where('cpu', 'like', '%' . $request->cpu . '%');
            })
            ->when($request->filled('ram'), function ($query) use ($request) {
                $query->where('ram', 'like', '%' . $request->ram . '%');
            })
            ->get();

        return view('admin.product-details.index', compact('details', 'products'));
    }
}
