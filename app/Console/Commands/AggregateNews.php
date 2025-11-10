<?php

namespace App\Console\Commands;

use App\Services\ContentServices\NewsAggregatorService;
use Illuminate\Console\Command;

class AggregateNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'automate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Aggregate News Contents Automatically';

    /**
     * Execute the console command.
     */
    public function handle(NewsAggregatorService $aggregator)
    {
        $aggregator->aggregate();
        $this->info('Articles fetched and stored.');
    }
}
