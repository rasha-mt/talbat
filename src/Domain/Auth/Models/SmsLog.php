<?php

namespace Domain\Auth\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SmsLog extends Model
{
    protected $guarded = [];

    protected $casts = [
        'message' => 'json',
    ];
}
