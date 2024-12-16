<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;
    // write relationship between main category and category
    public function mainCategory()
    {
        return $this->belongsTo(MainCategory::class);
    }
    // write for category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
   /*  public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    } */

    public function products()
    {
        return $this->hasMany(Product::class, 'sub_category_id');
    }
}
