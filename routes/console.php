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
    $json = file_get_contents(storage_path('web_list.json'));

    $data = json_decode($json, true);

    $pages = [];

    foreach ($data as $item) {
        if (isset($item['url']) && isset($item['name']) && isset($item['id'])) {
            $pages[] = $item;
        }
    }

    foreach ($pages as $page) {
        $response = Http::get($page['url']);
        $statusCode = $response->status();

        PingResult::create([
            'web_id' => $page['id'],
            'status_code' => $statusCode
        ]);
    }
})->everyMinute();
