<?php

namespace Domain\Users\Events;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LoggedOut
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $auth;

    public $from_all;

    public function __construct($auth, $from_all)
    {
        $this->auth = $auth;
        $this->from_all = $from_all;
    }

    public function fromAllDevices()
    {
        return $this->from_all == 'true';
    }
}
