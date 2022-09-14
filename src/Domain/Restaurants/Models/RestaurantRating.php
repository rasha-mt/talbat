<?php

namespace Domain\Restaurants\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RestaurantRating extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $casts = [
        'rating' => 'integer'
    ];

}
