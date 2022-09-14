<?php

namespace App\Http\Controllers;

use Domain\Restaurants\Models\Meal;
use Domain\Restaurants\Models\Category;
use Domain\Restaurants\Models\Restaurant;

use Illuminate\Http\Request;
use Domain\Restaurants\Resources\MealResource;
use Domain\Restaurants\Resources\CategoryResource;

class RestaurantCategoryController extends Controller
{
    public function index(Restaurant $restaurant)
    {
        /** @var Category $categories */
        $categories = $restaurant
            ->categories()
            ->active()
            ->orderBy('order')
            ->get();

        return CategoryResource::collection($categories);
    }

    public function show(Restaurant $restaurant, Category $category)
    {
        $category->load(['meals', 'meals.extras', 'meals.offer']);
        return new CategoryResource($category);
    }

}
