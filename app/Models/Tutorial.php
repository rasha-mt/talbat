<?php

namespace App\Models;

use App\Scopes\OrderScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tutorial extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $casts = [
        'order' => 'int',
    ];

    protected $attributes = [
        'enabled' => true,
    ];

    public function scopeEnabled($query)
    {
        return $query->where('enabled', true);
    }

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new OrderScope('order'));
    }
}
