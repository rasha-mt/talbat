<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use App\Http\Resources\SettingResource;

class SettingController extends Controller
{
    public function index()
    {

        $settings = Setting::all();

        return SettingResource::collection($settings);
    }
}