<?php

namespace Domain\Restaurants\Models;

use Illuminate\Database\Eloquent\Model;
use Domain\Restaurants\Casts\ExtraCaster;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MealExtra extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'options' => ExtraCaster::class,
    ];

}
