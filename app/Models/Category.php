<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    public function mainCategory()
    {
        return $this->belongsTo(MainCategory::class);
    }
    // write relationship between main category and category
    public function subCategories()
    {
        return $this->hasMany(SubCategory::class);
    }
    /* public function mainCategory()
    {
        return $this->belongsTo(MainCategory::class, 'main_category_id');
    }

    public function subcategories()
    {
        return $this->hasMany(SubCategory::class, 'category_id');
    } */
}
