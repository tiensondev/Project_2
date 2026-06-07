<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $fillable = ['cart_id', 'product_id', 'product_detail_id', 'quantity'];

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function cart() {
        return $this->belongsTo(Cart::class, 'cart_id');
    }
    public function productDetail()
    {
        return $this->belongsTo(ProductDetail::class, 'product_detail_id');
    }
}
