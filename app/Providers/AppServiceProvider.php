<?php

namespace App\Providers;

use App\Services\ModuleState\Contracts\ModuleManagementContract;
use App\Services\ModuleState\Repositories\ModuleManagementRepo;
use App\Services\UploadModule\Contracts\UploadModuleContract;
use App\Services\UploadModule\Repositories\UploadModuleRepo;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application Services.
     */

    private static array $repos = [
        ModuleManagementContract::class => ModuleManagementRepo::class,
        UploadModuleContract::class => UploadModuleRepo::class
    ];

    public function register(): void
    {
        foreach ($this::$repos as $contract => $repository){
            $this->app->singleton($contract, $repository);
        }
//        $this->app->singleton(
//            ModuleManagementContract::class,
//            ModuleManagementRepo::class
//        );
//
//        $this->app->singleton(
//            UploadModuleContract::class,
//            UploadModuleRepo::class
//        );
    }

    /**
     * Bootstrap any application Services.
     */
    public function boot(): void
    {
        //
    }
}
