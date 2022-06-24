<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class ProjectSetup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate database and run seed command';

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
        Artisan::call('optimize');
        //Migrate Database
        echo "Migrating Database...";
        Artisan::call('migrate');
        echo "Database Migration Successfully!!!";
        //RUN SEEDER
        echo "Running Seeders ...";
        Artisan::call("db:seed", ['--class' => 'DatabaseSeeder']);
        echo "Database Seeding Completed Successfully!!!";
        echo "Done";
        return 0;
    }
}
