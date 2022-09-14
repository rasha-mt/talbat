<?php

namespace Domain\Restaurants\Casts;

use Illuminate\Support\Str;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class ExtraCaster implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes)
    {

        if (!isset($attributes['options'])) {
            $attributes = [
                'options_list' => [
                    'title'                 => '',
                    'price'                 => 0,
                    'extra_price_over_main' => 0
                ],
            ];
        } else {
            $attributes = json_decode($attributes['options'], true);
        }
        $layouts = [];

        foreach ($attributes as $attribute => $value) {

            if (is_array($value)) {
                $layouts[] = [
                    'layout'     => 'options_list',
                    'key'        => Str::random(10),
                    'attributes' => $value,
                ];
            }
        }

        return collect($layouts);
    }

    public function set($model, string $key, $value, array $attributes)
    {

        $settings = [];

        foreach ($value as $keys => $values) {
            $settings[]= $values['attributes'];
        }

        return ['options' => json_encode($settings)];
    }

}