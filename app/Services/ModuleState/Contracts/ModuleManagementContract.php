<?php

namespace App\Services\ModuleState\Contracts;

interface ModuleManagementContract{

    public function enableModule(string $module) :void;
    public function disableModule(string $module) :void;
    public function installModule(string $module) :void;
    public function uninstallModule(string $module) :void;
    public function exportModule(string $module) :void;

}
