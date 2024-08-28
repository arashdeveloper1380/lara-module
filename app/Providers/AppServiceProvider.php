<?php

namespace App\Providers;

use App\Crud\Contract\CrudRepositoryContract;
use App\Crud\Repositories\CrudRepository;
use App\Services\ModuleState\Contracts\ModuleManagementContract;
use App\Services\ModuleState\Repositories\ModuleManagementRepo;
use App\Services\UploadModule\Contracts\UploadModuleContract;
use App\Services\UploadModule\Repositories\UploadModuleRepo;
use CrudGenerator\Contracts\Repositories\CrudGeneratorRepositoryContract;
use CrudGenerator\repositories\Write\CrudGeneratorGeneratorRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application Services.
     */

    private static array $repos = [
        ModuleManagementContract::class         => ModuleManagementRepo::class,
        UploadModuleContract::class             => UploadModuleRepo::class,
        CrudGeneratorRepositoryContract::class  => CrudGeneratorGeneratorRepository::class,
        CrudRepositoryContract::class           => CrudRepository::class
    ];

    public function register(): void{
        foreach ($this::$repos as $contract => $repository){
            $this->app->singleton($contract, $repository);
        }
    }

    /**
     * Bootstrap any application Services.
     */
    public function boot(): void{
        //
    }
}
