<?php

namespace Domain\Restaurants\Models;

use Illuminate\Database\Eloquent\Model;

use Domain\Restaurants\Builders\MealBuilder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Freshbitsweb\LaravelCartManager\Traits\Cartable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Meal extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Cartable;

    protected $guarded = [];
    protected $casts = [
        'regular_price' => 'float',
    ];
    protected $attributes = [
        'is_active' => true
    ];

    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function extras(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(MealExtra::class);
    }

    public function offers(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Offer::class);
    }

    public function offer()
    {
        return $this->hasOne(Offer::class)->where('is_active', true)->latestOfMany();
    }

    public function newEloquentBuilder($query): MealBuilder
    {
        return new MealBuilder($query);
    }

    public function extra()
    {
        return $this->hasOne(MealExtra::class);
    }
}
