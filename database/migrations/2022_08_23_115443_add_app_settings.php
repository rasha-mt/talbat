<?php

use App\Models\Setting;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {

    public function up()
    {
        Setting::firstOrCreate([
            'key' => Setting::NEARBY_RESTAURANT_DISTANCE,
        ],
            [
                'value'       => '1000',
                'type'        => Setting::NUMBER_TYPE,
                'category'    => Setting::APP_SETTINGS,
                'description' => 'Restaurant distance near by zoon ',
            ]
        );
    }

};
