<?php

namespace App\Services\ModuleState\Commands;

use Illuminate\Support\Facades\Artisan;

class InstallModuleCommand
{
    public static function execute(string $module){
        Artisan::call('app:install-module', ['name' => $module]);
    }
}
