<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Clean old search logs every week (keep last 6 months)
        $schedule->command('search:clean-logs')
            ->weekly()
            ->sundays()
            ->at('03:00')
            ->name('clean-old-search-logs');

        // Example: Rebuild search indexes daily (if needed for large datasets)
        // $schedule->command('scout:import', ['model' => 'App\\Models\\BlogPost'])
        //          ->dailyAt('02:00')
        //          ->name('rebuild-blog-index');
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

