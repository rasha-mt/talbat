<?php

namespace Http\Controllers;

use Database\Factories\OfferFactory;
use Database\Factories\CategoryFactory;
use App\Http\Controllers\OfferController;
use Tests\TestCase;
use Database\Factories\RestaurantFactory;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class OfferControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function test_list_offers()
    {
        $restaurant = RestaurantFactory::new()->create();
        CategoryFactory::new()->withMeals()->create([
            'restaurant_id' => $restaurant->id
        ]);

        OfferFactory::new()->create([
            'meal_id' => 1
        ]);

        $this->setUser()->getJson('api/v1/offers')
            ->assertSuccessful()
            ->assertJsonStructure([
                'data' => [
                    [
                        'id',
                        'title',
                        'discount',
                        'discount_type',
                    ]
                ]
            ]);

    }
}
