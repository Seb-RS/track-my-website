<?php

use App\Models\PingResult;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::call(function () {
    $urls = ['https://sebdev.cl', 'https://lab.sebdev.cl'];

    foreach ($urls as $url) {
        $response = Http::get($url);
        $statusCode = $response->status();

        PingResult::create([
            'url' => $url,
            'status_code' => $statusCode
        ]);
    }
})->everyFiveMinutes();
