<?php

namespace Domain\Auth\Models\Concerns;

use Domain\Auth\Models\Device;
use Illuminate\Database\QueryException;

trait HasDevices
{
    public function devices()
    {
        return $this->morphMany(Device::class, 'authable');
    }

    public function registerDevice($deviceData)
    {
        Device::where('device_id', $deviceData['device_id'])->delete();
        // try {
        $device = $this->devices()->updateOrCreate([
            'device_id'   => $deviceData['device_id'],
            'device_type' => $deviceData['device_type'],
        ], [
            'device_info'  => $deviceData['device_info'] ?? null,
            'version'      => $deviceData['version'] ?? '1',
            'device_token' => $deviceData['device_token']
        ]);

        return $device;
//        } catch (QueryException $e) {
//            return $this->devices()
//                ->where('device_id', $deviceData['device_id'])
//                ->where('device_type', $deviceData['device_type'])
//                ->first();
//        }
    }

    public function device($name)
    {
        [$type, $id] = explode('-', $name, 2);

        return $this->devices()
            ->where('device_id', $id)
            ->where('device_type', $type)
            ->first();
    }

    public function removeDeviceTokens($name)
    {
        [$type, $id] = explode('-', $name, 2);

        $device = $this->devices()
            ->where('device_id', $id)
            ->where('device_type', $type)
            ->delete();

    }

}