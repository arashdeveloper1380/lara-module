<?php

namespace App\Services\UploadModule\Commands;

use Illuminate\Support\Facades\Artisan;

class ClearCacheModuleCommand
{
    public static function execute() : void{
        Artisan::call('route:cache');
        Artisan::call('view:cache');
        Artisan::call('cache:clear');
    }
}
