<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Wishlist extends Model
{
    use HasFactory;
    function product() : BelongsTo {
        return $this->belongsTo(Product::class);
    }
    // public function prodct_variant()
    // {
    //     return $this->hasMany(ProductVariant::class);
    // }
}
