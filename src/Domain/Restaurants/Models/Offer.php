<?php

namespace Domain\Restaurants\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Offer extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $casts = [
        'discount' => 'float'
    ];

    const PERCENT_DISCOUNT = 'percent';
    const AMOUNT_DISCOUNT = 'amount';
    const PER_TOTAL_DISCOUNT = 'per_total';

    public function meal()
    {
        return $this->belongsTo(Meal::class);
    }

    public static function discountTypes()
    {
        return [
            self::PERCENT_DISCOUNT   => self::PERCENT_DISCOUNT,
            self::AMOUNT_DISCOUNT    => self::AMOUNT_DISCOUNT,
            self::PER_TOTAL_DISCOUNT => self::PER_TOTAL_DISCOUNT
        ];
    }
}
