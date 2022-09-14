<?php

namespace App\Models;

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    public const TEXT_TYPE = 'text';
    public const NUMBER_TYPE = 'number';
    public const BOOLEAN_TYPE = 'boolean';
    public const URL_TYPE = 'url';
    public const APP_SETTINGS = 'App Setting';

    public const RESEND_MAX_WITHIN = 24;
    public const RESEND_MAX_LIMIT = 3;
    public const NEARBY_RESTAURANT_DISTANCE = 'nearby_restaurant_distance';
    public const CURRENCY = 'IL';
    public const SMS_API_TOKEN = 'sms_api_token';
    public const PL_SMS_TOKEN = 'pl_sms_token';
    public const IS_SMS_TOKEN = 'is_sms_token';
    public const SMS_SETTING = 'sms_setting';
    public const PL_SMS_SENDER = 'pl_sms_sender';
    public const IS_SMS_SENDER = 'is_sms_sender';
    public const RESEND_CODE_DURATION = 'resend_code_duration';


    protected $guarded = [];

    protected $attributes = [
        'category' => 'uncategorized',
    ];

    public static function value(string $key)
    {
        return Cache::remember("setting.${key}", now()->addMinutes(30), function () use ($key) {
            return self::where('key', $key)->firstOrFail()->value;
        });
    }

    public static function fake(string $key, $value)
    {
        return Cache::set("setting.${key}", $value);
    }

    public static function set($key, $value)
    {
        self::where('key', $key)->update([
            'value' => $value,
        ]);

        Cache::forget("setting.${key}");
    }
}
