<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Domain\Restaurants\Models\Meal;
use Domain\Restaurants\Resources\OfferResource;

class OfferController extends Controller
{
    public function index()
    {
        /** @var Meal $meals */
        $meals = Meal::query()
            ->active()
            ->has('offer')
            ->with('offer')
            ->paginate();

        return OfferResource::collection($meals);

    }
}
