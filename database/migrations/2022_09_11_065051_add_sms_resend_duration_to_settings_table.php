<?php

use App\Models\Setting;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Setting::firstOrCreate([
            'key' => Setting::RESEND_CODE_DURATION,
        ],
            [
                'value' => '60',
                'type' => Setting::NUMBER_TYPE,
                'category' => Setting::APP_SETTINGS,
                'description' => 'Resend sms after duration ',
            ]
        );
    }

};
