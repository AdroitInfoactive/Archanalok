<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'address',
        'city',
        'state',
        'country',
        'zip',
        'company',
        'gst',
        'is_default_billing',
        'is_default_shipping',
    ];

    // Relationships
    public function stateName()
    {
        return $this->belongsTo(State::class, 'state', 'id');
    }
}
