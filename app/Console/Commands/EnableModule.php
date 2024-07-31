<?php

namespace App\Console\Commands;

use App\Models\ModuleStatus;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Nwidart\Modules\Facades\Module;

class EnableModule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:enable-module {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'enable module';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $moduleName = $this->argument('name');

        $this->info("enable module: $moduleName");

        $this->enableModuleCommand($moduleName);

        $existModule = $this->existModule($moduleName);

        if(!$existModule){
            $this->createModuleOnDBWhenModuleNotExist($moduleName);
        }else{
            $this->updateModuleOnDBWhenModuleExist($existModule, $moduleName);
        }

        $this->info("Module $moduleName enable successfully!");
    }

    private function enableModuleCommand(string $moduleName) :void{
        Artisan::call("module:enable $moduleName");
    }

    private function existModule(string $moduleName){
        return ModuleStatus::query()->where('name', $moduleName)->first();
    }
    private function createModuleOnDBWhenModuleNotExist(
        string $name,
    ){
        ModuleStatus::query()->create([
            'name'      => $name,
            'class'     => "Modules//$name",
            'status'    => 1
        ]);
    }

    private function updateModuleOnDBWhenModuleExist(
        $module,
        string $name,
    ){
        $module->update([
            'name'      => $name,
            'class'     => "Modules//$name",
            'status'    => 1
        ]);
    }
}
