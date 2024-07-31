<?php

namespace App\Services\UploadModule\Commands;

use Illuminate\Support\Facades\Artisan;

class MigrateModuleCommand
{
    public static function execute(string $module) : void{
        Artisan::call('module:migrate', ['module' => $module]);
    }
}
