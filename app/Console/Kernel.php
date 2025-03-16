<?php

namespace App\Console;

use App\Jobs\BillStudentsJob;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('bill:students')
            ->everyTenMinutes()
            ->runInBackground()
            ->withoutOverlapping()
            ->appendOutputTo(storage_path('logs/bill-students.log'))
            ->onFailure(function () {
                \Log::error('Bill students command failed');
            })
            ->onSuccess(function () {
                \Log::info('Bill students completed successfully');
            });
        // $schedule->job(new BillStudentsJob)->everyTenMinutes();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
