<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    public function wishlists()
    {
        return $this->hasMany(\App\Models\Wishlist::class);
    }

    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
        'loyalty_points',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
        'is_admin'          => 'boolean',
    ];

    public function isAdmin(): bool
    {
        return (bool) $this->is_admin;
    }

    // relasi bwt rekomendasi
    public function orders()
    {
        return $this->hasMany(\App\Models\Order::class);
    }

    public function orderItems()
    {
        return $this->hasManyThrough(
            \App\Models\OrderItem::class,
            \App\Models\Order::class,
            'user_id',   // foreign key di orders
            'order_id',  // foreign key di order_items
            'id',        // pk users
            'id'         // pk orders
        );
    }
}
