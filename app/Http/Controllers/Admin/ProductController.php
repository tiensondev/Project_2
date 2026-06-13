<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Brand;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        $products = Product::join('categories', 'products.category_id', '=', 'categories.id')
            ->select('products.*', 'categories.name as category_name')
            ->oldest('products.created_at')
            ->get();

        return view('admin.products.list', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::where('status', 1)->get();
        $brands = Brand::all();
        return view('admin.products.create', compact('categories', 'brands'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'price' => 'required|numeric|min:0',
                'stock' => 'required|integer|min:0',
                'brand_id' => 'required|exists:brands,id',
                'category_id' => 'required|exists:categories,id',
                'description' => 'nullable|string',
                'image' => 'nullable|array',
                'image.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            ],
            [
                'name.required' => 'Product name is required.',
                'price.required' => 'Price is required.',
                'price.numeric' => 'Price must be a number.',
                'price.min' => 'Price must be at least 0.',
                'stock.required' => 'Stock quantity is required.',
                'stock.integer' => 'Stock must be an integer.',
                'stock.min' => 'Stock must be at least 0.',
                'brand_id.required' => 'Brand is required.',
                'brand_id.exists' => 'Selected brand does not exist.',
                'category_id.required' => 'Category is required.',
                'category_id.exists' => 'Selected category does not exist.',
                'image.array' => 'Images data must be an array.',
                'image.*.image' => 'Each uploaded file must be an image.',
                'image.*.mimes' => 'Each image must be a file of type: jpeg, png, jpg, gif.',
                'image.*.max' => 'Each image size must not exceed 2MB.',
            ]
        );

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $imageNames = [];

            foreach ($request->file('image') as $file) {
                $filename = time() . '-' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads'), $filename);
                $imageNames[] = $filename;
            }

            $data['image'] = $imageNames;
        } else {
            $data['image'] = null;
        }

        Product::create($data);

        return redirect()->route('admin.products.list')->with('success', 'Product created successfully!');
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        $brands = Brand::all();
        return view('admin.products.show', compact('product', 'categories', 'brands'));
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::where('status', 1)->get();
        $brands = Brand::all();
        return view('admin.products.edit', compact('product', 'categories', 'brands'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate(
            [
                'name' => 'required|string|max:255',
                'price' => 'required|numeric|min:0',
                'stock' => 'required|integer|min:0',
                'brand_id' => 'required|exists:brands,id',
                'category_id' => 'required|exists:categories,id',
                'description' => 'nullable|string',
                'image' => 'nullable|array',
                'image.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            ],
            [
                'name.required' => 'Product name is required.',
                'price.required' => 'Price is required.',
                'price.numeric' => 'Price must be a number.',
                'price.min' => 'Price must be at least 0.',
                'stock.required' => 'Stock quantity is required.',
                'stock.integer' => 'Stock must be an integer.',
                'stock.min' => 'Stock must be at least 0.',
                'brand_id.required' => 'Brand is required.',
                'brand_id.exists' => 'Selected brand does not exist.',
                'category_id.required' => 'Category is required.',
                'category_id.exists' => 'Selected category does not exist.',
                'image.array' => 'Images data must be an array.',
                'image.*.image' => 'The image field must be an image.',
                'image.*.mimes' => 'The image field must be a file of type: jpeg, png, jpg, gif.',
                'image.*.max' => 'Each image size must not exceed 2MB.',
            ]
        );

        $data = $request->except('image');

        if ($request->hasFile('image')) {

            if (!empty($product->image) && is_array($product->image)) {
                foreach ($product->image as $oldImage) {
                    $oldImagePath = public_path('uploads/' . $oldImage);
                    if (file_exists($oldImagePath)) {
                        @unlink($oldImagePath);
                    }
                }
            }

            $imageNames = [];
            foreach ($request->file('image') as $file) {
                $filename = time() . '-' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads'), $filename);
                $imageNames[] = $filename;
            }

            $data['image'] = $imageNames;
        } else {
            $data['image'] = $product->image;
        }

        $product->update($data);

        return redirect()->route('admin.products.list')->with('success', 'Product updated successfully!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if (!empty($product->image) && is_array($product->image)) {
            foreach ($product->image as $img) {
                $imagePath = public_path('uploads/' . $img);
                if (file_exists($imagePath)) {
                    @unlink($imagePath);
                }
            }
        }

        $product->delete();

        return redirect()->route('admin.products.list')->with('success', 'Product deleted successfully.');
    }

    public function search(Request $request)
    {
        $categories = Category::all();

        $query = Product::join('categories', 'products.category_id', '=', 'categories.id')
            ->select('products.*', 'categories.name as category_name');

        if ($request->filled('category')) {
            $query->where('products.category_id', $request->category);
        }

        if ($request->filled('name')) {
            $query->where('products.name', 'like', '%' . $request->name . '%');
        }

        $products = $query->get();

        return view('admin.products.list', compact('products', 'categories'));
    }
}
