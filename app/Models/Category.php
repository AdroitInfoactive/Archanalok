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
}
