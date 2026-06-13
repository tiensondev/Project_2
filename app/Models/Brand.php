<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable = ['name', 'logo', 'status', 'description'];

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
}
