<?php

namespace App\Console\Commands;

use App\Models\ModuleStatus;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Nwidart\Modules\Facades\Module;

class DisableModule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:disable-module {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Disable Module';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $moduleName = $this->argument('name');

        $this->info("disable module: $moduleName");
        $this->disableModuleCommand($moduleName);
        $this->clearCache();

        $existModule = $this->existModule($moduleName);

        if(!$existModule){
            $this->createModuleOnDBWhenModuleNotExist($moduleName);
        }else{
            $this->updateModuleOnDBWhenModuleExist($existModule, $moduleName);
        }

        $this->info("Module $moduleName disabled successfully!");
    }

    private function disableModuleCommand(string $moduleName) :void{
        Artisan::call("module:disable $moduleName");
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
            'status'    => 0
        ]);
    }

    private function updateModuleOnDBWhenModuleExist(
        $module,
        string $name,
    ){
        $module->update([
            'name'      => $name,
            'class'     => "Modules//$name",
            'status'    => 0
        ]);
    }

    private function clearCache(){

    }
}
