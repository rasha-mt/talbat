<?php

namespace Domain\Auth\Actions;

use Illuminate\Http\Request;
use Domain\Users\Models\User;
use Domain\Auth\Models\Device;

class CreateOrUpdateDeviceTokensAction
{
    public function __invoke(Request $request, User $user)
    {
        /**
         * @var Device $device
         */
        $device = $user->registerDevice($this->getDeviceData($request));

        return $device;
    }

    private function getDeviceData(Request $request)
    {
        $device_data = collect(['device_id', 'device_type', 'device_info','device_token'])
            ->mapWithKeys(function ($key) use ($request
            ) {
                return [$key => $request->$key ?? $request->headers->get($key)];
            })->toArray();

        $device_data['version'] = $request->headers->get('app-version', 1);

        return $device_data;
    }

}