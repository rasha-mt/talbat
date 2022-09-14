<?php

namespace Domain\Restaurants\Builders;

use App\Models\Setting;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;

class CategoryBuilder extends Builder
{

    public function active(): self
    {
        return $this->where('is_active', true);
    }

}