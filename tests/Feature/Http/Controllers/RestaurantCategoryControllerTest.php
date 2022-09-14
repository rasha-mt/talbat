<?php

namespace Http\Controllers;

use Database\Factories\UserFactory;
use Database\Factories\CategoryFactory;
use Database\Factories\RestaurantFactory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RestaurantCategoryControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function test_can_list_restaurant_categories()
    {
        $restaurant = RestaurantFactory::new()->withCategory(3)->create();
        $user = UserFactory::new()->create();

        $this->setUser($user)
            ->getJson("api/v1/restaurants/{$restaurant->id}/categories")
            ->assertSuccessful()
            ->assertJsonCount(3, 'data.*')
            ->assertJsonStructure([
                'data' => [
                    [
                        'id',
                        'name',
                    ]
                ]
            ]);
    }

    public function test_can_list_category_meals()
    {
        $restaurant = RestaurantFactory::new()->create();
        CategoryFactory::new()->withMeals()->create([
            'restaurant_id' => $restaurant->id
        ]);
        $user = UserFactory::new()->create();

        $this->setUser($user)
            ->getJson("api/v1/restaurants/{$restaurant->id}/categories/1")
            ->assertSuccessful()
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'meals' => [
                        [
                            'extras',
                            'offer'
                        ]
                    ],
                ]
            ]);
    }
}
