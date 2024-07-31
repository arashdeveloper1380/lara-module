<?php

namespace App\Services\UploadModule\Commands;

use Illuminate\Support\Facades\Artisan;

class PublishAssetsModuleCommand
{
    public static function execute(string $module) : void{
        Artisan::call('module:publish', ['module' => $module]);
    }
}
