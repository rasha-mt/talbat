<?php

namespace Domain\Users\Models;

use Laravel\Sanctum\HasApiTokens;
use Domain\Users\Builders\UserBuilder;
use Illuminate\Notifications\Notifiable;
use Domain\Auth\Models\Concerns\HasDevices;
use Illuminate\Database\Eloquent\SoftDeletes;
use Domain\Auth\Models\Concerns\MobileActivation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 *
 * @method UserBuilder query()
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasDevices, MobileActivation;

    use SoftDeletes;

    protected $guarded = [
    ];

    protected $casts = [
        'is_verified' => 'boolean',
        'mobile'      => 'string',
    ];

    protected $attributes = [
        'used_times'  => 0,
        'is_verified' => false
    ];

    public function locations(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Location::class);
    }

    public function currentLocation()
    {
        return $this->hasOne(Location::class)->latestOfMany();
    }

    public function newEloquentBuilder($query)
    {
        return new UserBuilder($query);
    }
}
