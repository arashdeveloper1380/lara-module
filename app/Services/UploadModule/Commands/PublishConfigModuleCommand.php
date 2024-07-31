<?php

namespace App\Services\UploadModule\Commands;

use Illuminate\Support\Facades\Artisan;

class PublishConfigModuleCommand
{
    public static function execute(string $module) : void{
        Artisan::call('module:publish-config', ['module' => $module]);
    }
}
