<?php

namespace App\Services\UploadModule\Repositories;

use App\Services\UploadModule\Commands\ClearCacheModuleCommand;
use App\Services\UploadModule\Commands\EnableModuleCommand;
use App\Services\UploadModule\Commands\MigrateModuleCommand;
use App\Services\UploadModule\Commands\PublishAssetsModuleCommand;
use App\Services\UploadModule\Commands\PublishConfigModuleCommand;
use App\Services\UploadModule\Contracts\UploadModuleContract;
use Illuminate\Support\Facades\Artisan;
use Nwidart\Modules\Facades\Module;

class UploadModuleRepo implements UploadModuleContract
{

    public function __construct(
        public      EnableModuleCommand          $enableModuleCommand,
        public      MigrateModuleCommand         $migrateModuleCommand,
        public      PublishConfigModuleCommand   $publishConfigModuleCommand,
        public      PublishAssetsModuleCommand   $publishAssetsModuleCommand,
        public      ClearCacheModuleCommand      $clearCacheModuleCommand
    ){}

    public function upload($request){
        $file = $request->file('module');

        $originalName = $this->getModuleName($file);

        $filePath = $this->storeModule($file, $originalName);

        $this->installModule($filePath, $originalName);
    }


    private function installModule($filePath, $dirName){
        $zip = new \ZipArchive();

        if ($zip->open(storage_path("app/{$filePath}")) === true) {
            $modulePath = base_path("Modules/$dirName");

            $zip->extractTo($modulePath);
            $zip->close();

            $moduleName = basename($filePath, '.zip');

            if (!Module::has($moduleName)) {
                $this->enableModule($moduleName);
                $this->migrateModule($moduleName);
                $this->publishConfigModule($moduleName);
                $this->publishAssetsModule($moduleName);
                $this->clearCache();
            }

        } else {
            throw new \Exception('Could not open ZIP file.');
        }

    }
    private function getModuleName($module){
        return pathinfo($module->getClientOriginalName(), PATHINFO_FILENAME);
    }

    private function storeModule($file, string $moduleName){
        return $file->storeAs('modules', "{$moduleName}.zip");
    }

    private function enableModule(string $module) :void{
        $this->enableModuleCommand::execute($module);
    }

    private function migrateModule(string $module) :void{
        $this->migrateModuleCommand::execute($module);
    }

    private function publishConfigModule(string $module) :void{
        $this->publishConfigModuleCommand::execute($module);
    }

    private function publishAssetsModule(string $module) :void{
        $this->publishAssetsModuleCommand::execute($module);
    }

    private function clearCache() :void{
        $this->clearCacheModuleCommand::execute();
    }
}
