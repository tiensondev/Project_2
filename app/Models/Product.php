<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'stock',
        'brand_id',
        'category_id',
        'description',
        'image', 
    ];

    protected $casts = [
        'image' => 'array',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function specs()
    {
        return $this->hasMany(ProductSpec::class);
    }
    public function details()
    {
        return $this->hasMany(ProductDetail::class);
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}
