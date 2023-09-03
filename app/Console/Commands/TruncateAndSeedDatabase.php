<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class TruncateAndSeedDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'database:truncate-and-seed';

    /**
     * This command description.
     *
     * @var string
     */
    protected $description = 'This command truncates and re-seed the db everyday at midnight UTC..';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        Artisan::call('migrate:fresh --seed');
    }
}
