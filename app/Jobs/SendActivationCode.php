<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Domain\Users\Models\User;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Domain\Auth\Actions\SendSmsISProviderAction;
use Domain\Auth\Actions\SendSmsPSProviderAction;

class SendActivationCode implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function handle()
    {
        $message = $this->user->smsText();
        $mobile = (integer)$this->user->mobile;

        preg_match('/^(?<cc>0|972|970)?(?<code>[0-9]{2})(?<n>[0-9]+)/', $mobile, $mobile_prefix);

        $mob_number = '0' . $mobile_prefix['code'];
        // Palatine

        if (in_array((int) $mob_number[2], [6, 9])) {
            app(SendSmsPSProviderAction::class)($this->user, $message);
        }

        // Israel
        if (in_array((int) $mob_number[2], [0, 1, 2, 3, 4, 5, 7, 8])) {

            app(SendSmsISProviderAction::class)($this->user, $message);

        }
    }
}
