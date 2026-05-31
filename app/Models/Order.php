<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    const STATUS_PENDING = '1';
    const STATUS_PROCESSING = '2';
    const STATUS_COMPLETED = '3';
    const STATUS_CANCEL = '0';

    use HasFactory;

    protected $fillable = [
        'user_id',
        'customer_name',
        'phone',
        'province',
        'district',
        'ward',
        'address_detail',
        'total',
        'status',
    ];

    public function getStatusBadgeAttribute()
    {
        return match ((int)$this->status) {

            1 => '<span class="badge bg-warning text-dark">
                Pending
              </span>',

            2 => '<span class="badge bg-info text-dark">
                Processing                                                                                                      
              </span>',

            3 => '<span class="badge bg-success">
                Completed
              </span>',

            0 => '<span class="badge bg-danger">
                Cancelled
              </span>',

            default => '<span class="badge bg-secondary">
                        Unknown
                    </span>',
        };
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }
}
