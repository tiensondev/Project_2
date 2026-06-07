<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class ProductDetail extends Model
{
    use HasFactory;

    protected $table = 'product_details';

    protected $fillable = [
        'product_id',
        'cpu',
        'ram',
        'storage',
        'gpu',
        'screen',
        'color',
        'price',
        'stock',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    // Có thể xuất hiện trong nhiều OrderDetail
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }
}