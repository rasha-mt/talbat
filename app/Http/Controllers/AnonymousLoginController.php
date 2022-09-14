<?php

namespace App\Http\Controllers;

use Domain\Users\Models\User;
use Domain\Auth\Models\Device;
use App\Http\Resources\UserResource;
use Domain\Users\Requests\AnonymousLoginRequest;
use Domain\Auth\Actions\CreateOrUpdateDeviceTokensAction;

class AnonymousLoginController extends Controller
{
    public function __invoke(
        AnonymousLoginRequest            $request,
        CreateOrUpdateDeviceTokensAction $createOrUpdateDeviceTokensAction,
    )
    {
        $device_type = $request->device_type ?? $request->headers->get('device_type');
        $device_id = $request->device_id ?? $request->headers->get('device_id');
        $device = Device::where('device_type', $device_type)->where('device_id', $device_id)->first();

        if ($device and !$device?->authable?->verified_at) {
            $user = $device->authable;
        } else {
            $user = User::query()->create();
        }
        /** @var User $user */
        $device = ($createOrUpdateDeviceTokensAction)($request, $user);

        $token = $user->createToken($device->generateTokenName())->plainTextToken;

        return (new UserResource($user))->additionalMeta([
            'token' => $token,
        ]);
    }
}
