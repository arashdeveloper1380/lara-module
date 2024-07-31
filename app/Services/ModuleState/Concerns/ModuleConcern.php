<?php

namespace App\Services\ModuleState\Concerns;

trait ModuleConcern{
    public function moduleConcern(string $module) :void{
        $this->isNotStringModuleName($module);
        $this->isNullModuleName($module);
    }

    private function isNotStringModuleName(string $module){
        if (!is_string($module)) {
            throw new \Exception("module {$module} not found");
        }
    }

    private function isNullModuleName(string $module){
        if (is_null($module)) {
            throw new \Exception("module {$module} not found");
        }
    }
}
