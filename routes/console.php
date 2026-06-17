<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

use Illuminate\Support\Facades\Schedule;
use App\Models\Proyek;

Artisan::command('app:publish-scheduled-projects', function () {
    $count = Proyek::where('status', 'scheduled')
        ->where('scheduled_at', '<=', now())
        ->update(['status' => 'open', 'open_at' => now()]);
    $this->info("Published {$count} scheduled projects.");
})->purpose('Publish scheduled projects whose scheduled time has arrived');

Schedule::command('app:publish-scheduled-projects')->everyMinute();
