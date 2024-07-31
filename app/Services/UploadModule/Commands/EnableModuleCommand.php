<?php

namespace App\Services\UploadModule\Commands;

use Illuminate\Support\Facades\Artisan;

class EnableModuleCommand
{
    public static function execute(string $module) : void{
        Artisan::call('app:enable-module', ['name' => $module]);
    }
}
