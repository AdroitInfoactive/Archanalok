<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function mainCategory()
    {
        return $this->belongsTo(MainCategory::class, 'main_category_id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }
    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }
    public function brandName()
    {
    return $this->belongsTo(Brand::class, 'brand');
    }
    public function materialDetail()
    {
    return $this->belongsTo(VariantDetail::class, 'material', 'id');
    }
    public function unitDetail()
    {
    return $this->belongsTo(VariantDetail::class, 'units', 'id');
    }
    public function weightTypeDetail()
    {
    return $this->belongsTo(VariantDetail::class, 'weight_type', 'id');
    }
    public function variants()
    {
    return $this->hasMany(ProductVariant::class);
    }
}
