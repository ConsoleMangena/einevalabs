<?php

use App\Jobs\PruneOldContactSubmissions;
use Illuminate\Support\Facades\Schedule;

/*
| Order management and housekeeping.
|
| cPanel does not run a scheduler by default - add the `schedule:run` cron
| entry documented in README.md, or none of this executes.
*/

Schedule::command('orders:abandon-stale --hours=24')
    ->hourly()
    ->withoutOverlapping()
    ->onOneServer();

/*
| Contact messages are personal data with no long-term retention need. The
| 180-day window keeps enough history for follow-up while keeping the table
| small, which matters because the admin list is unindexed-by-relevance and
| gets slow fast.
*/
Schedule::job(new PruneOldContactSubmissions(days: 180))
    ->dailyAt('03:10')
    ->withoutOverlapping();
