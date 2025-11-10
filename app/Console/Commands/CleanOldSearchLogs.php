<?php

namespace App\Console\Commands;

use App\Models\SearchLog;
use Illuminate\Console\Command;

class CleanOldSearchLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'search:clean-logs {--months=6 : Number of months to keep}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean old search logs to maintain database performance';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $months = (int) $this->option('months');
        
        $this->info("Cleaning search logs older than {$months} months...");

        $deletedCount = SearchLog::query()
            ->where('created_at', '<', now()->subMonths($months))
            ->delete();

        $this->info("Successfully deleted {$deletedCount} old search log(s).");

        return Command::SUCCESS;
    }
}

