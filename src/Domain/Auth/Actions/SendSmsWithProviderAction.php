<?php

namespace Domain\Auth\Actions;

use Domain\Users\Models\User;

class SendSmsWithProviderAction
{
    /**
     * @param  User  $auth
     */
    public function __invoke($auth, $message = null, $code = null)
    {
        $code = $code ?? $auth->verification_code;
        $mobile = $auth->getVerificationMobile();

    }

}