<?php

namespace Domain\Auth\Models;

use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;
    use Notifiable;

    protected $guarded = [];

    protected $casts = [
        'device_info' => 'json',
    ];
    protected $attributes = [
        'version' => 1
    ];

    public function generateTokenName()
    {
        return $this->device_type . '-' . $this->device_id;
    }

    public function authable()
    {
        return $this->morphTo();
    }
}
