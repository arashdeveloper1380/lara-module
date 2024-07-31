<?php

namespace App\Services\ModuleState\Commands;

use Illuminate\Support\Facades\Artisan;

class DisableModuleCommand
{
    public static function execute(string $module) : void{
        Artisan::call('app:disable-module', ['name' => $module]);
    }
}
