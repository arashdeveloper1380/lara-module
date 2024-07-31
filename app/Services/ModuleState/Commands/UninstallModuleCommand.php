<?php

namespace App\Services\ModuleState\Commands;

use Illuminate\Support\Facades\Artisan;

class UninstallModuleCommand
{
    public static function execute(string $module) :void{
        Artisan::call('app:unistall-module', ['name' => $module]);
    }
}
