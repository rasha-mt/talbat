<?php

use App\Models\Setting;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Setting::firstOrCreate([
            'key' => Setting::PL_SMS_TOKEN,
        ],
            [
                'value'       => 'PS',
                'type'        => Setting::TEXT_TYPE,
                'category'    => Setting::SMS_SETTING,
                'description' => 'Sms token for PL Provider',
            ]
        );

        Setting::firstOrCreate([
            'key' => Setting::IS_SMS_TOKEN,
        ],
            [
                'value'       => 'IS',
                'type'        => Setting::TEXT_TYPE,
                'category'    => Setting::SMS_SETTING,
                'description' => 'Sms token for IS Provider',
            ]
        );

        Setting::firstOrCreate([
            'key' => Setting::PL_SMS_SENDER,
        ],
            [
                'value'       => 'PS',
                'type'        => Setting::TEXT_TYPE,
                'category'    => Setting::SMS_SETTING,
                'description' => ' sms sender for PL Provider',
            ]
        );

        Setting::firstOrCreate([
            'key' => Setting::IS_SMS_TOKEN,
        ],
            [
                'value'       => 'IS',
                'type'        => Setting::TEXT_TYPE,
                'category'    => Setting::SMS_SETTING,
                'description' => 'sms sender for IS Provider',
            ]
        );
    }


};
