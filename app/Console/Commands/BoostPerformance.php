<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class BoostPerformance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clear:app';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will optimize your application performance!';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->call('cache:clear');
        $this->call('view:clear');
        $this->call('config:clear');
        $this->call('route:clear');
        echo "Performance optimized!";
    }
}
