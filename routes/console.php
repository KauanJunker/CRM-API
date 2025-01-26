<?php

use App\Console\Commands\NotifyDeadlineTaskOfUsers;
use App\Jobs\NotifyTaskDeadline;
use App\Jobs\SendAppointmentReminder;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::job(new NotifyTaskDeadline())->everyTwoHours();
Schedule::job(new SendAppointmentReminder())->everyMinute();
