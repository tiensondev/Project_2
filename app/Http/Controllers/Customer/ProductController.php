<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category','brand']);

        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }

        if ($request->has('brand') && $request->brand) {
            $query->where('brand_id', $request->brand);
        }

        $products = $query->paginate(12);
        $categories = Category::where('status', 1)->get();
        $brands = Brand::where('status', 1)->get();

        return view('products', compact('products', 'categories', 'brands'));
    }

    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);

        return view('product-detail', compact('product'));
    }

    public function home()
    {
        $categories = Category::where('status', 1)->get();

        $allProducts = Product::orderBy('created_at', 'desc')->get();

        return view('home', compact('categories', 'allProducts'));
    }


    public function search(Request $request)
    {
        $query = Product::with('category')->whereHas('category', function ($query) {
            $query->where('status', 1);
        });

        if ($request->has('query') && $request->q) {
            $searchTerm = $request->q;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('description', 'like', '%' . $searchTerm . '%');
            });
        }

        $products = $query->paginate(12);
        $categories = Category::where('status', 1)->get();

        return view('search', compact('products', 'categories'));
    }

    public function showbycategory($id)
    {
        $products = Product::with('category')
            ->where('category_id', $id)
            ->whereHas('category', function ($query) {
                $query->where('status', 1);
            })
            ->paginate(12);

        $categories = Category::where('status', 1)->get();
        $currentCategory = Category::findOrFail($id);

        return view('products', compact('products', 'categories', 'currentCategory'));
    }
}
