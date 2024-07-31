<?php

namespace App\Services\ModuleState\Repositories;

use App\Services\ModuleState\Commands\DisableModuleCommand;
use App\Services\ModuleState\Commands\EnableModuleCommand;
use App\Services\ModuleState\Commands\ExportModuleCommand;
use App\Services\ModuleState\Commands\InstallModuleCommand;
use App\Services\ModuleState\Commands\UninstallModuleCommand;
use App\Services\ModuleState\Concerns\ModuleConcern;
use App\Services\ModuleState\Contracts\ModuleManagementContract;

class ModuleManagementRepo implements ModuleManagementContract
{
    use ModuleConcern;
    public function __construct(
        public DisableModuleCommand $disableModuleCommand,
        public EnableModuleCommand $enableModuleCommand,
        public InstallModuleCommand $installModuleCommand,
        public UninstallModuleCommand $uninstallModuleCommand,
        public ExportModuleCommand $exportModuleCommand,
    ){}

    public function enableModule(string $module) : void{
        $this->moduleConcern($module);
        $this->handleModuleEnable($module);
    }

    public function disableModule(string $module) : void{
        $this->moduleConcern($module);
        $this->handleModuleDisable($module);
    }

    public function installModule(string $module) :void{
        $this->moduleConcern($module);
        $this->handleModuleInstall($module);
    }
    public function uninstallModule(string $module) :void{
        $this->moduleConcern($module);
        $this->handleModuleUninstall($module);
    }

    public function exportModule(string $module) :void{
        $this->moduleConcern($module);
        $this->exportModuleCommand::execute($module);
    }

    private function handleModuleEnable(string $module) :void{
        $this->enableModuleCommand::execute($module);
    }

    private function handleModuleDisable(string $module) :void{
        $this->disableModuleCommand::execute($module);
    }

    private function handleModuleInstall(string $module) :void{
        $this->installModuleCommand::execute($module);
    }

    private function handleModuleUninstall(string $module) :void{
        $this->uninstallModuleCommand::execute($module);
    }
}
