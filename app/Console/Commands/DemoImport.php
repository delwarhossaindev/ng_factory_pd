<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Database\Seeders\DatabaseSeeder;

class DemoImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will import demo data!';

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
        $this->call('migrate:fresh');
        $this->call('db:seed', ['--force' => true, '--class' => DatabaseSeeder::class]);
        echo "Demo data imported successfully!\n";
    }
}
