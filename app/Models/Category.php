<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'status',
    ];

    public function getStatusBadgeAttribute()
    {
        if ($this->status == 1) {
            return '<span class="badge bg-success">Active</span>';
        }

        return '<span class="badge bg-danger">Hidden</span>';
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function show($id)
    {
        $category = \App\Models\Category::findOrFail($id);

        $products = $category->products;

        return view('frontend.category', compact('category', 'products'));
    }
}
