<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Domain\Users\Models\User;
use Illuminate\Support\Facades\Auth;
use Domain\Restaurants\Models\Restaurant;
use Domain\Restaurants\Resources\RestaurantResource;

class RestaurantController extends Controller
{
    public function index()
    {
        /** @var User $user */
        $user = Auth::user() ?? User::find(2);
        $location = $user->currentLocation;

        $restaurants = Restaurant::query()
            ->active()
            ->when($location, function ($query, $location) {
                $query->nearBy($location?->latitude, $location?->longitude);
            })
            ->orderBy('order')
            ->paginate();

        return RestaurantResource::collection($restaurants);

    }
}
