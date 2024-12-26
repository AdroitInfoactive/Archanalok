<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VariantMaster extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];
    public function details()
    {
        return $this->hasMany(VariantDetail::class, 'variant_master_id');
    }
}

