<?php

namespace Domain\Restaurants\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Domain\Restaurants\Builders\CategoryBuilder;
use Domain\Restaurants\Builders\RestaurantBuilder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Restaurant extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];
    protected $attributes = [
        'shipping_price' => 0,
        'is_active'      => true,
    ];
    protected $casts = [
        'shipping_price' => 'float',
        'is_active'      => 'boolean',
        'address'        => 'json'
    ];

    /**
     * @return HasMany|CategoryBuilder
     */
    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function ratings()
    {
        return $this->hasMany(RestaurantRating::class);
    }

    public function avgRating(): Attribute
    {
        return Attribute::make(
            get: function () {
                $avg_rating = $this->ratings()->avg('rating');

                return round((float) $avg_rating, 1);
            },
        );
    }

    public function newEloquentBuilder($query): RestaurantBuilder
    {
        return new RestaurantBuilder($query);
    }

    public function categoryMeals(): \Illuminate\Database\Eloquent\Relations\HasManyThrough
    {
        return $this->hasManyThrough(Meal::class, Category::class);
    }

}
