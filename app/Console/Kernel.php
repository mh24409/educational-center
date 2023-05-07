<?php

namespace App\Console;

use App\Models\Course;
use App\Models\Quiz;
use App\Models\User;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Carbon\Carbon;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $now_date = Carbon::now('Africa/Cairo');
            $date = $now_date->toArray();
            Quiz::whereDate('date', Carbon::today())
                ->where('start_time', '<=', $date['hour'] . ':' . $date['minute'] . ':' . $date['second'])
                ->where('end_time', '>', $date['hour'] . ':' . $date['minute'] . ':' . $date['second'])
                ->where('status', 'inactive')
                ->update(['status' => 'active']);

            Quiz::whereDate('date', Carbon::today())
                ->where('start_time', '<', $date['hour'] . ':' . $date['minute'] . ':' . $date['second'])
                ->where('end_time', '<', $date['hour'] . ':' . $date['minute'] . ':' . $date['second'])
                ->where('status', 'active')
                ->update(['status' => 'expired']);

            Course::whereDate('end_date', '>', Carbon::today())
                ->whereDate('start_date', '<', Carbon::today())
                ->where('status', 0)
                ->update(['status' => 1]);

            Course::whereDate('end_date', '<', Carbon::today())
                ->where('status', 1)
                ->update(['status' => 0]);
        })->cron('* * * * *');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
