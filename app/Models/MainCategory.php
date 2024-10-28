<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainCategory extends Model
{
    use HasFactory;
    // build relationshiop with categories

    public function categories()
    {
        return $this->hasMany(Category::class);
    }
    // build relationship with subcategories
    public function subCategories()
    {
        return $this->hasMany(SubCategory::class);
    }
}
