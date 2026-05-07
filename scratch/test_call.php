<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Services\ExotelService;
use App\Models\Hospital;

try {
    $service = app(ExotelService::class);
    $hospital = Hospital::find(4);
    
    if (!$hospital) {
        die("Hospital ID 4 not found.\n");
    }

    $contacts = $hospital->contacts->pluck('contact')->toArray();
    echo "Hospital: " . $hospital->hospital_name . "\n";
    echo "Contacts: " . implode(', ', $contacts) . "\n";

    $log = $service->createLogAndStartDial('7757911857', $contacts, 'Antigravity Test', 4);
    
    echo "Call Log ID: " . $log->id . "\n";
    echo "Exotel SID: " . $log->call_sid . "\n";
    echo "Status: " . $log->status . "\n";

} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
