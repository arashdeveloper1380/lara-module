<?php

namespace App\Services\ModuleState\Commands;

use Illuminate\Support\Facades\Artisan;

class ExportModuleCommand
{
    public static function execute(string $module) : void{
        Artisan::call('app:export-module', ['name' => $module]);
    }
}
