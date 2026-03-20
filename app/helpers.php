<?php

use App\Models\Setting;

if (!function_exists('setting')) {

    function setting($column)
    {
        $setting = Setting::first();

        return $setting->$column ?? null;
    }

}