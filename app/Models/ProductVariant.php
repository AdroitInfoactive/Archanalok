<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    public function images()
    {
    return $this->hasMany(ProductImage::class, 'variant_id', 'id');
    }
    protected $fillable = [
        'product_id',
        'variation_code',
        'sku',
        'sale_price',
        'offer_price',
        'distributor_price',
        'min_order_qty',
        'wholesale_price',
        'weight',
        'qty',
        'status',
        'variation_ids',
        // etc…
      ];

}
