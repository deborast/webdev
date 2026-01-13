<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'description',
        'image',
        'price',
        'stock',
        'discount_percent',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // bwt statistik penjualan / rekomen
    public function orderItems()
    {
        return $this->hasMany(\App\Models\OrderItem::class);
    }
}
