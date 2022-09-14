<?php

namespace Domain\Restaurants\Models;

use Illuminate\Database\Eloquent\Model;
use Domain\Restaurants\Builders\CategoryBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $attributes = [
        'is_active' => true,
        'order'     => 0
    ];

    public function restaurant(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function meals()
    {
        return $this->hasMany(Meal::class);
    }

    public function newEloquentBuilder($query): CategoryBuilder
    {
        return new CategoryBuilder($query);
    }
}
