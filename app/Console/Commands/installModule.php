<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class installModule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:install-module {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'install module with name';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $moduleName = $this->argument('name');

        $this->info("install module: $moduleName");
        Artisan::call("module:enable $moduleName");

        $this->info("Running migrations for module: $moduleName");
        Artisan::call("module:migrate $moduleName");

        $this->info("Publishing config for module: $moduleName");
        Artisan::call("module:publish-config $moduleName");

        $this->info("Publishing assets for module: $moduleName");
        Artisan::call("module:publish $moduleName");

        $this->info("Module $moduleName disabled successfully!");
    }
}
