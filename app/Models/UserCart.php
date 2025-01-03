<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCart extends Model
{
    use HasFactory;

    protected $table = 'user_carts';
    protected $fillable = [
        'user_id',
        'product_id',
        'variant_id',
        'name',
        'price',
        'sale_price',
        'offer_price',
        'quantity',
        'weight',
        'tax',
        'image',
        'variant_code',
    ];

    /**
     * Get the user associated with the cart item.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the product associated with the cart item.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the variant associated with the cart item.
     */
    public function variant()
    {
        return $this->belongsTo(ProductVariant::class);
    }
}
