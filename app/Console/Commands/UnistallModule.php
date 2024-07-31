<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class UnistallModule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:unistall-module {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Unistall Module';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $moduleName = $this->argument('name');

        $this->info("Disabling module: $moduleName");
        Artisan::call("module:disable $moduleName");

        $this->info("Rolling back migrations for module: $moduleName");
        Artisan::call("module:migrate-rollback $moduleName");


        $this->info("Module $moduleName uninstalled successfully!");

    }
}
