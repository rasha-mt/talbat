<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Domain\Users\Models\User;
use Domain\Users\Models\Location;
use Illuminate\Support\Facades\Auth;
use Domain\Users\Requests\LocationRequest;
use Domain\Users\Resources\LocationResource;

class LocationController extends Controller
{
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();
        return LocationResource::collection($user->locations()->get());

    }

    public function store(LocationRequest $request)
    {
        /** @var User $user */
        $user = Auth::user();
        $user->locations()->create($request->validated());

        return $this->success();
    }

    public function update(LocationRequest $request, Location $location)
    {
        $location->update($request->validated());

        return $this->success();
    }

    public function destroy(Location $location)
    {
        $location->delete();

        return $this->success();
    }

}
