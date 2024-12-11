<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function mainCategory()
    {
    return $this->belongsTo(Category::class, 'main_category_id');
    }

    public function category()
    {
    return $this->belongsTo(Category::class, 'category_id');
    }

    public function subCategory()
    {
    return $this->belongsTo(Category::class, 'sub_category_id');
    }
}
