<?php

namespace App\Http\Controllers;

use Spatie\Searchable\Search;

use Domain\Restaurants\Models\Meal;
use Illuminate\Http\Request;
use Domain\Restaurants\Models\Restaurant;

class SearchController extends Controller
{
    public function __invoke(Request $request)
    {
        $searchResults = (new Search())
            ->registerModel(Restaurant::class, 'name')
            ->registerModel(Meal::class, 'name')
            ->search($request->keyword);


    }

}