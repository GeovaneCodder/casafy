<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "address",
        "bedrooms",
        "bathrooms",
        "total_area",
        "purchased",
        "value",
        "discount",
        "owner_id",
        "expired",
    ];

    protected $casts = [
        'bedrooms' => 'integer',
        'bathrooms' => 'integer',
        'total_area' => 'integer',
        'purchased' => 'boolean',
        'discount' => 'integer',
        'expired' => 'boolean',
    ];
}
