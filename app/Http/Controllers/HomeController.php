<?php

namespace App\Http\Controllers;

use App\Models\PingResult;
use Carbon\Carbon;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        $json = file_get_contents(storage_path('web_list.json'));
        $data = json_decode($json, true);

        $results = [];

        foreach ($data as $page) {
            $days = [];

            $statuses = PingResult::where('web_id', $page['id'])
                ->where('created_at', '>=', Carbon::now()->subDays(60))
                ->orderBy('created_at', 'asc')
                ->get();

            for ($i = 0; $i < 60; $i++) {
                $pingResults = $statuses->filter(function ($result) use ($i) {
                    return $result->created_at->toDateString() === Carbon::now()->subDays($i)->toDateString();
                });

                if ($pingResults->isNotEmpty()) {
                    $average = $pingResults->avg('status_code');
                    $date = Carbon::parse($pingResults->last()->created_at)->format('d-m-Y');
                    $days[] = ['status_code' => $average, 'date' => $date];
                } else {
                    $date = Carbon::now()->subDays($i)->format('d-m-Y');
                    $days[] = ['status_code' => null, 'date' => $date];
                }
            }

            $days = array_reverse($days);

            $results[] = [
                'id' => $page['id'],
                'name' => $page['name'],
                'url' => $page['url'],
                'days' => $days,
            ];
        }

        $webs = json_decode(json_encode($results));
        return Inertia::render('Home/Show', compact('webs'));
    }
}
