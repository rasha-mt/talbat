<?php

namespace Domain\Users\Listeners;


use Domain\Users\Events\LoggedOut;

class RemoveDevices
{
    public function handle(LoggedOut $event)
    {
        $auth = $event->auth;

        if ($event->fromAllDevices()) {
            $auth->tokens()->delete();
            $auth->devices()->delete();
        } else {
            $currentAccessToken = $auth->currentAccessToken();
            $auth->removeDeviceTokens($currentAccessToken->name);
            $currentAccessToken->delete();
        }
    }
}
