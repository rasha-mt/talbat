<?php

namespace Domain\Users\Builders;

use Illuminate\Database\Eloquent\Builder;

class UserBuilder extends Builder
{
    public function anonymous()
    {
        return $this->whereNull('verified_at');
    }

}